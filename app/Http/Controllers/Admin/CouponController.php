<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons with metrics and filtering
     */
    public function index(Request $request)
    {
        $today = now()->toDateString();

        $query = Coupon::withCount('usages')->latest('id');

        // Search filter (code or title)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'active') {
                $query->where('is_active', true)->whereDate('end_date', '>=', $today);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($status === 'expired') {
                $query->whereDate('end_date', '<', $today);
            }
        }

        $perPage = (int) $request->get('per_page', 10);
        $coupons = $query->paginate($perPage)->withQueryString();

        // Metrics Summary
        $counts = [
            'total' => Coupon::count(),
            'active' => Coupon::where('is_active', true)->whereDate('end_date', '>=', $today)->count(),
            'expired' => Coupon::whereDate('end_date', '<', $today)->count(),
            'total_usages' => CouponUsage::count(),
            'total_distributed' => (float) CouponUsage::sum('amount'),
        ];

        return view('admin.coupon.index', compact('coupons', 'counts'));
    }

    /**
     * Store a newly created coupon
     */
    public function store(Request $request)
    {
        $request->merge([
            'code' => strtoupper(preg_replace('/[^A-Za-z0-9_]/', '', (string) $request->code)),
        ]);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'title' => 'nullable|string|max:191',
            'amount' => 'required|numeric|min:1|max:100000',
            'end_date' => 'required|date|after_or_equal:today',
            'is_active' => 'nullable|boolean',
        ], [
            'code.required' => 'Please enter a coupon code.',
            'code.unique' => 'This coupon code already exists.',
            'amount.min' => 'Amount must be at least ₹1.',
            'end_date.after_or_equal' => 'End date cannot be in the past.',
        ]);

        $coupon = Coupon::create([
            'code' => $validated['code'],
            'title' => $validated['title'] ?: ($validated['code'] . ' Bonus'),
            'amount' => $validated['amount'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
            'usage_count' => 0,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Coupon '{$coupon->code}' of ₹" . number_format($coupon->amount, 2) . " created successfully!",
                'coupon' => $coupon,
            ]);
        }

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' created successfully!");
    }

    /**
     * Update an existing coupon
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->merge([
            'code' => strtoupper(preg_replace('/[^A-Za-z0-9_]/', '', (string) $request->code)),
        ]);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons')->ignore($coupon->id)],
            'title' => 'nullable|string|max:191',
            'amount' => 'required|numeric|min:1|max:100000',
            'end_date' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $coupon->update([
            'code' => $validated['code'],
            'title' => $validated['title'] ?: ($validated['code'] . ' Bonus'),
            'amount' => $validated['amount'],
            'end_date' => $validated['end_date'],
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Coupon '{$coupon->code}' updated successfully!",
                'coupon' => $coupon,
            ]);
        }

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' updated successfully!");
    }

    /**
     * Toggle coupon active/inactive status
     */
    public function toggleStatus($id): JsonResponse
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        $statusText = $coupon->is_active ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'is_active' => $coupon->is_active,
            'message' => "Coupon '{$coupon->code}' has been {$statusText}.",
        ]);
    }

    /**
     * Delete a coupon
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $code = $coupon->code;
        $coupon->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Coupon '{$code}' deleted successfully.",
            ]);
        }

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$code}' deleted successfully.");
    }

    /**
     * Fetch candidates who used this coupon
     */
    public function usages($id): JsonResponse
    {
        $coupon = Coupon::with(['usages.candidate' => function ($q) {
            $q->select('id', 'candidate_code', 'first_name', 'last_name', 'mobile', 'email', 'gender', 'created_at');
        }, 'usages.walletTransaction'])->findOrFail($id);

        $usages = $coupon->usages->map(function ($u) {
            return [
                'id' => $u->id,
                'candidate_id' => $u->candidate_id,
                'candidate_code' => $u->candidate->candidate_code ?? ('RM' . str_pad($u->candidate_id, 5, '0', STR_PAD_LEFT)),
                'candidate_name' => trim(($u->candidate->first_name ?? '') . ' ' . ($u->candidate->last_name ?? '')),
                'candidate_mobile' => $u->candidate->mobile ?? 'N/A',
                'amount' => (float) $u->amount,
                'transaction_id' => $u->walletTransaction->transaction_id ?? ('TXN-' . $u->id),
                'applied_at' => $u->created_at ? $u->created_at->format('d M Y, h:i A') : 'N/A',
            ];
        });

        return response()->json([
            'success' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'title' => $coupon->title,
                'amount' => (float) $coupon->amount,
                'usage_count' => $coupon->usage_count,
            ],
            'usages' => $usages,
        ]);
    }
}
