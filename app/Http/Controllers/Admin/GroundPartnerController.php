<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExecutivePartner;
use App\Models\GroundPartner;
use Illuminate\Http\Request;

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

        $query = GroundPartner::with('executivePartner')->latest();

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
        ];

        $executivePartners = ExecutivePartner::orderBy('name')->get(['id', 'name', 'code', 'status']);

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
     * Display the specified Ground Partner / Return JSON for Edit.
     */
    public function show(Request $request, $id)
    {
        $partner = GroundPartner::with('executivePartner')->findOrFail($id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'partner' => $partner,
            ]);
        }

        return view('admin.ground_partner.show', compact('partner'));
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

