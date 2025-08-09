<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReferralController extends Controller
{
    /**
     * Display a listing of referrals.
     */
    public function index(Request $request)
    {
        $query = Referral::with(['affiliate', 'program']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%')
                  ->orWhereHas('affiliate', function($aq) use ($request) {
                      $aq->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('program', function($pq) use ($request) {
                      $pq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->affiliate_id) {
            $query->where('affiliate_id', $request->affiliate_id);
        }

        if ($request->program_id) {
            $query->where('program_id', $request->program_id);
        }

        $referrals = $query->latest()->paginate(15);

        $affiliates = User::where('role', 'affiliate')->select('id', 'name')->get();
        $programs = Program::select('id', 'name')->get();

        return Inertia::render('admin/referrals/index', [
            'referrals' => $referrals,
            'filters' => $request->only(['search', 'status', 'affiliate_id', 'program_id']),
            'affiliates' => $affiliates,
            'programs' => $programs,
            'statuses' => Referral::STATUSES,
        ]);
    }

    /**
     * Display the specified referral.
     */
    public function show(Referral $referral)
    {
        $referral->load(['affiliate', 'program']);

        return Inertia::render('admin/referrals/show', [
            'referral' => $referral,
        ]);
    }

    /**
     * Update the specified referral.
     */
    public function update(Request $request, Referral $referral)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $referral->status;
        $newStatus = $request->status;

        // Calculate commission if marking as completed
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $commissionRate = $referral->program->commission_rate ?? $referral->affiliate->commission_rate;
            $commissionAmount = ($referral->program->price * $commissionRate) / 100;
            
            $referral->update([
                'status' => $newStatus,
                'commission_amount' => $commissionAmount,
                'commission_rate' => $commissionRate,
                'completed_at' => now(),
                'notes' => $request->notes,
            ]);
        } else {
            $referral->update([
                'status' => $newStatus,
                'notes' => $request->notes,
                'completed_at' => $newStatus === 'completed' ? ($referral->completed_at ?? now()) : null,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Referral status updated successfully.');
    }
}