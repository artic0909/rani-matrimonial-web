<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExecutivePartner;
use App\Models\GroundPartner;
use Illuminate\Http\Request;

class ExecutivePartnerController extends Controller
{
    /**
     * Display a listing of Executive Partners.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = strtolower((string) $request->query('status', 'all'));

        $query = ExecutivePartner::withCount('groundPartners')->latest();

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
     * Display the specified Executive Partner / Return JSON for Edit.
     */
    public function show(Request $request, $id)
    {
        $partner = ExecutivePartner::with(['groundPartners' => function ($q) {
            $q->latest();
        }])->findOrFail($id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'partner' => $partner,
            ]);
        }

        return view('admin.executive_partner.show', compact('partner'));
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

