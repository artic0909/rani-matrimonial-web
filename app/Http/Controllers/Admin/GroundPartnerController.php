<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExecutivePartner;
use App\Models\GroundPartner;
use App\Models\GpReferral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GroundPartnerController extends Controller
{
    /**
     * Display a listing of Ground Partners.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = strtolower((string) $request->query('status', 'all'));
        $epId = $request->query('ep_id', 'all');

        $query = GroundPartner::with('executivePartner')
            ->withCount([
                'referrals as total_referrals_count',
                'paidReferrals as paid_referrals_count',
            ])
            ->latest();

        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'inactive');
        }

        if (!empty($epId) && $epId !== 'all') {
            $query->where('ep_id', $epId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('mobile', 'LIKE', "%{$search}%")
                  ->orWhereHas('executivePartner', function ($epQ) use ($search) {
                      $epQ->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('code', 'LIKE', "%{$search}%");
                  });
            });
        }

        $partners = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => GroundPartner::count(),
            'active' => GroundPartner::where('status', 'active')->count(),
            'inactive' => GroundPartner::where('status', 'inactive')->count(),
            'eps_count' => GroundPartner::distinct('ep_id')->count('ep_id'),
            'paid_candidates' => GpReferral::where('payment_status', 'paid')->count(),
            'total_revenue' => (float) GpReferral::where('payment_status', 'paid')->sum('amount'),
        ];

        $executivePartners = ExecutivePartner::where('status', 'active')->orderBy('name')->get(['id', 'name', 'code', 'status']);

        return view('admin.ground_partner.index', compact('partners', 'executivePartners', 'counts', 'search', 'status', 'epId'));
    }

    /**
     * Store a newly created Ground Partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ep_id' => 'required|exists:executive_partners,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:ground_partners,code',
            'mobile' => 'required|string|max:25',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['ep_id', 'name', 'mobile', 'status']);

        if ($request->filled('code')) {
            $data['code'] = strtoupper(trim((string) $request->input('code')));
        } else {
            $data['code'] = GroundPartner::generateUniqueCode();
        }

        $partner = GroundPartner::create($data);
        $partner->load('executivePartner');

        $msg = "Ground Partner {$partner->name} ({$partner->code}) created successfully!";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'partner' => $partner,
            ]);
        }

        return redirect()->route('admin.ground-partners.index')->with('success', $msg);
    }

    /**
     * Display single Ground Partner details with referred candidates, monthly filters, and analytics.
     */
    public function show(Request $request, $id)
    {
        $partner = GroundPartner::with('executivePartner')->findOrFail($id);

        if ($request->wantsJson() && !$request->has('page') && !$request->has('filter_ajax')) {
            return response()->json([
                'success' => true,
                'partner' => $partner,
            ]);
        }

        // Filters for referred candidates
        $search = trim((string) $request->query('search', ''));
        $payStatus = strtolower((string) $request->query('payment_status', 'all'));
        $month = trim((string) $request->query('month', 'all'));

        $query = GpReferral::with('candidate')
            ->where('gp_id', $partner->id)
            ->latest('register_date');

        if ($payStatus === 'paid') {
            $query->where('payment_status', 'paid');
        } elseif ($payStatus === 'pending') {
            $query->where('payment_status', 'pending');
        }

        if (!empty($month) && $month !== 'all') {
            $query->whereRaw("DATE_FORMAT(register_date, '%Y-%m') = ?", [$month]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('payment_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('candidate', function ($cQ) use ($search) {
                      $cQ->where('first_name', 'LIKE', "%{$search}%")
                         ->orWhere('last_name', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%")
                         ->orWhere('candidate_code', 'LIKE', "%{$search}%")
                         ->orWhere('profile_id', 'LIKE', "%{$search}%");
                  });
            });
        }

        $referrals = $query->paginate(15)->withQueryString();

        // Partner Referral Metric Statistics
        $counts = [
            'total_candidates' => GpReferral::where('gp_id', $partner->id)->count(),
            'paid_candidates' => GpReferral::where('gp_id', $partner->id)->where('payment_status', 'paid')->count(),
            'pending_candidates' => GpReferral::where('gp_id', $partner->id)->where('payment_status', 'pending')->count(),
            'total_earnings' => (float) GpReferral::where('gp_id', $partner->id)->where('payment_status', 'paid')->sum('amount'),
        ];

        // Available distinct registration months for filter
        $months = GpReferral::where('gp_id', $partner->id)
            ->selectRaw("DATE_FORMAT(register_date, '%Y-%m') as month_key, DATE_FORMAT(register_date, '%M %Y') as month_label")
            ->distinct()
            ->orderByDesc('month_key')
            ->pluck('month_label', 'month_key');

        return view('admin.ground_partner.show', compact('partner', 'referrals', 'counts', 'months', 'month', 'payStatus', 'search'));
    }

    /**
     * Export referred candidates under this Ground Partner to Excel (CSV).
     */
    public function exportReferrals(Request $request, $id): StreamedResponse
    {
        $partner = GroundPartner::with('executivePartner')->findOrFail($id);

        $search = trim((string) $request->query('search', ''));
        $payStatus = strtolower((string) $request->query('payment_status', 'all'));
        $month = trim((string) $request->query('month', 'all'));

        $query = GpReferral::with('candidate')
            ->where('gp_id', $partner->id)
            ->latest('register_date');

        if ($payStatus === 'paid') {
            $query->where('payment_status', 'paid');
        } elseif ($payStatus === 'pending') {
            $query->where('payment_status', 'pending');
        }

        if (!empty($month) && $month !== 'all') {
            $query->whereRaw("DATE_FORMAT(register_date, '%Y-%m') = ?", [$month]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('payment_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('candidate', function ($cQ) use ($search) {
                      $cQ->where('first_name', 'LIKE', "%{$search}%")
                         ->orWhere('last_name', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%")
                         ->orWhere('candidate_code', 'LIKE', "%{$search}%")
                         ->orWhere('profile_id', 'LIKE', "%{$search}%");
                  });
            });
        }

        $records = $query->get();

        $filename = "GP_Referrals_{$partner->code}_" . date('Y_m_d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->streamDownload(function () use ($records, $partner) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // CSV Header Row
            fputcsv($file, [
                'Candidate ID / Code',
                'Candidate Full Name',
                'Candidate Mobile',
                'Gender',
                'City / State',
                'GP Code',
                'GP Name',
                'EP Code',
                'EP Name',
                'Registration Date',
                'Payment Status',
                '1st Payment Date',
                'Recharge Amount (INR)',
                'Payment Transaction ID'
            ]);

            foreach ($records as $ref) {
                $candidate = $ref->candidate;
                $candidateName = $candidate ? trim(($candidate->first_name ?? '') . ' ' . ($candidate->last_name ?? '')) : 'N/A';
                $candidateCode = $candidate ? ($candidate->candidate_code ?? $candidate->profile_id ?? ('RM' . $candidate->id)) : 'N/A';
                $mobile = $candidate->phone ?? 'N/A';
                $gender = ucfirst($candidate->gender ?? 'N/A');
                $location = trim(($candidate->city ?? '') . ', ' . ($candidate->state ?? ''), ', ');

                fputcsv($file, [
                    $candidateCode,
                    $candidateName,
                    $mobile,
                    $gender,
                    $location ?: 'N/A',
                    $partner->code,
                    $partner->name,
                    $partner->executivePartner->code ?? 'N/A',
                    $partner->executivePartner->name ?? 'N/A',
                    $ref->register_date ? $ref->register_date->format('Y-m-d H:i') : 'N/A',
                    strtoupper($ref->payment_status),
                    $ref->payment_date ? $ref->payment_date->format('Y-m-d H:i') : 'Pending',
                    number_format((float) $ref->amount, 2, '.', ''),
                    $ref->payment_id ?? 'N/A'
                ]);
            }

            fclose($file);
        }, $filename, $headers);
    }

    /**
     * Update the specified Ground Partner.
     */
    public function update(Request $request, $id)
    {
        $partner = GroundPartner::findOrFail($id);

        $request->validate([
            'ep_id' => 'required|exists:executive_partners,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:ground_partners,code,' . $id,
            'mobile' => 'required|string|max:25',
            'status' => 'required|in:active,inactive',
        ]);

        $partner->ep_id = $request->input('ep_id');
        $partner->name = trim((string) $request->input('name'));
        $partner->code = strtoupper(trim((string) $request->input('code')));
        $partner->mobile = trim((string) $request->input('mobile'));
        $partner->status = $request->input('status');
        $partner->save();
        $partner->load('executivePartner');

        $msg = "Ground Partner {$partner->name} ({$partner->code}) updated successfully!";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'partner' => $partner,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(Request $request, $id)
    {
        $partner = GroundPartner::findOrFail($id);
        $partner->status = ($partner->status === 'active') ? 'inactive' : 'active';
        $partner->save();

        $msg = "Ground Partner {$partner->name} status changed to " . ucfirst($partner->status) . ".";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $partner->status,
                'is_active' => $partner->isActive(),
                'message' => $msg,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Remove the specified Ground Partner.
     */
    public function destroy(Request $request, $id)
    {
        $partner = GroundPartner::findOrFail($id);
        $name = $partner->name;
        $code = $partner->code;

        $partner->delete();

        $msg = "Ground Partner {$name} ({$code}) deleted successfully.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return redirect()->route('admin.ground-partners.index')->with('success', $msg);
    }
}
