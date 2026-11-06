<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExecutivePartner;
use App\Models\GroundPartner;
use App\Models\GpReferral;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExecutivePartnerController extends Controller
{
    /**
     * Display a listing of Executive Partners.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = strtolower((string) $request->query('status', 'all'));

        $query = ExecutivePartner::withCount([
            'groundPartners as ground_partners_count',
            'gpReferrals as total_candidates_count',
            'paidGpReferrals as paid_candidates_count',
        ])->latest();

        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'inactive');
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }

        $partners = $query->paginate(15)->withQueryString();

        $counts = [
            'total' => ExecutivePartner::count(),
            'active' => ExecutivePartner::where('status', 'active')->count(),
            'inactive' => ExecutivePartner::where('status', 'inactive')->count(),
            'total_gps' => GroundPartner::count(),
            'paid_candidates' => GpReferral::where('payment_status', 'paid')->count(),
            'total_revenue' => (float) GpReferral::where('payment_status', 'paid')->sum('amount'),
        ];

        return view('admin.executive_partner.index', compact('partners', 'counts', 'search', 'status'));
    }

    /**
     * Store a newly created Executive Partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:executive_partners,code',
            'mobile' => 'required|string|max:25',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'mobile', 'status']);

        if ($request->filled('code')) {
            $data['code'] = strtoupper(trim((string) $request->input('code')));
        } else {
            $data['code'] = ExecutivePartner::generateUniqueCode();
        }

        $partner = ExecutivePartner::create($data);

        $msg = "Executive Partner {$partner->name} ({$partner->code}) created successfully!";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'partner' => $partner,
            ]);
        }

        return redirect()->route('admin.executive-partners.index')->with('success', $msg);
    }

    /**
     * Display the specified Executive Partner with assigned GPs, referred candidates network, filters and analytics.
     */
    public function show(Request $request, $id)
    {
        $partner = ExecutivePartner::with(['groundPartners' => function ($q) {
            $q->withCount(['referrals', 'paidReferrals'])->latest();
        }])->findOrFail($id);

        if ($request->wantsJson() && !$request->has('page') && !$request->has('filter_ajax')) {
            return response()->json([
                'success' => true,
                'partner' => $partner,
            ]);
        }

        $activeTab = $request->query('tab', 'gps'); // 'gps' or 'candidates'
        $search = trim((string) $request->query('search', ''));
        $payStatus = strtolower((string) $request->query('payment_status', 'all'));
        $month = trim((string) $request->query('month', 'all'));
        $gpFilter = $request->query('gp_id', 'all');

        $gpIds = $partner->groundPartners->pluck('id')->toArray();

        // Query for referred candidates under all GPs of this EP
        $referralsQuery = GpReferral::with(['candidate', 'groundPartner'])
            ->whereIn('gp_id', $gpIds)
            ->latest('register_date');

        if (!empty($gpFilter) && $gpFilter !== 'all') {
            $referralsQuery->where('gp_id', $gpFilter);
        }

        if ($payStatus === 'paid') {
            $referralsQuery->where('payment_status', 'paid');
        } elseif ($payStatus === 'pending') {
            $referralsQuery->where('payment_status', 'pending');
        }

        if (!empty($month) && $month !== 'all') {
            $referralsQuery->whereRaw("DATE_FORMAT(register_date, '%Y-%m') = ?", [$month]);
        }

        if (!empty($search)) {
            $referralsQuery->where(function ($q) use ($search) {
                $q->where('payment_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('candidate', function ($cQ) use ($search) {
                      $cQ->where('first_name', 'LIKE', "%{$search}%")
                         ->orWhere('last_name', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%")
                         ->orWhere('candidate_code', 'LIKE', "%{$search}%")
                         ->orWhere('profile_id', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('groundPartner', function ($gQ) use ($search) {
                      $gQ->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('code', 'LIKE', "%{$search}%");
                  });
            });
        }

        $referrals = $referralsQuery->paginate(15)->withQueryString();

        // Analytics counts for EP network
        $counts = [
            'total_gps' => count($gpIds),
            'total_candidates' => GpReferral::whereIn('gp_id', $gpIds)->count(),
            'paid_candidates' => GpReferral::whereIn('gp_id', $gpIds)->where('payment_status', 'paid')->count(),
            'pending_candidates' => GpReferral::whereIn('gp_id', $gpIds)->where('payment_status', 'pending')->count(),
            'total_revenue' => (float) GpReferral::whereIn('gp_id', $gpIds)->where('payment_status', 'paid')->sum('amount'),
        ];

        // Available months for filtering
        $months = GpReferral::whereIn('gp_id', $gpIds)
            ->selectRaw("DATE_FORMAT(register_date, '%Y-%m') as month_key, DATE_FORMAT(register_date, '%M %Y') as month_label")
            ->distinct()
            ->orderByDesc('month_key')
            ->pluck('month_label', 'month_key');

        return view('admin.executive_partner.show', compact(
            'partner',
            'referrals',
            'counts',
            'months',
            'month',
            'payStatus',
            'gpFilter',
            'search',
            'activeTab'
        ));
    }

    /**
     * Export all referred candidates under this Executive Partner's network to Excel (CSV).
     */
    public function exportReferrals(Request $request, $id): StreamedResponse
    {
        $partner = ExecutivePartner::with('groundPartners')->findOrFail($id);
        $gpIds = $partner->groundPartners->pluck('id')->toArray();

        $search = trim((string) $request->query('search', ''));
        $payStatus = strtolower((string) $request->query('payment_status', 'all'));
        $month = trim((string) $request->query('month', 'all'));
        $gpFilter = $request->query('gp_id', 'all');

        $query = GpReferral::with(['candidate', 'groundPartner'])
            ->whereIn('gp_id', $gpIds)
            ->latest('register_date');

        if (!empty($gpFilter) && $gpFilter !== 'all') {
            $query->where('gp_id', $gpFilter);
        }

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
                  })
                  ->orWhereHas('groundPartner', function ($gQ) use ($search) {
                      $gQ->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('code', 'LIKE', "%{$search}%");
                  });
            });
        }

        $records = $query->get();

        $filename = "EP_Network_Referrals_{$partner->code}_" . date('Y_m_d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->streamDownload(function () use ($records, $partner) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Candidate ID / Code',
                'Candidate Full Name',
                'Candidate Mobile',
                'Gender',
                'Location',
                'Executive Partner Code',
                'Executive Partner Name',
                'Ground Partner Code',
                'Ground Partner Name',
                'Registration Date',
                'Payment Status',
                '1st Payment Date',
                'Recharge Amount (INR)',
                'Payment Transaction ID'
            ]);

            foreach ($records as $ref) {
                $candidate = $ref->candidate;
                $gp = $ref->groundPartner;
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
                    $gp->code ?? 'N/A',
                    $gp->name ?? 'N/A',
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
     * Update the specified Executive Partner.
     */
    public function update(Request $request, $id)
    {
        $partner = ExecutivePartner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:executive_partners,code,' . $id,
            'mobile' => 'required|string|max:25',
            'status' => 'required|in:active,inactive',
        ]);

        $partner->name = trim((string) $request->input('name'));
        $partner->code = strtoupper(trim((string) $request->input('code')));
        $partner->mobile = trim((string) $request->input('mobile'));
        $partner->status = $request->input('status');
        $partner->save();

        $msg = "Executive Partner {$partner->name} ({$partner->code}) updated successfully!";

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
        $partner = ExecutivePartner::findOrFail($id);
        $partner->status = ($partner->status === 'active') ? 'inactive' : 'active';
        $partner->save();

        $msg = "Executive Partner {$partner->name} status changed to " . ucfirst($partner->status) . ".";

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
     * Remove the specified Executive Partner.
     */
    public function destroy(Request $request, $id)
    {
        $partner = ExecutivePartner::findOrFail($id);
        $name = $partner->name;
        $code = $partner->code;

        $partner->delete();

        $msg = "Executive Partner {$name} ({$code}) deleted successfully.";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return redirect()->route('admin.executive-partners.index')->with('success', $msg);
    }
}
