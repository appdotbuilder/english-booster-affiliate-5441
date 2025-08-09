<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAffiliateRequest;
use App\Http\Requests\UpdateAffiliateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    /**
     * Display a listing of affiliates.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'affiliate')
            ->withCount(['referrals', 'completedReferrals'])
            ->with(['referrals' => function($q) {
                $q->where('status', 'completed');
            }]);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('referral_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status && $request->status !== 'all') {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $affiliates = $query->latest()->paginate(15);

        // Calculate earnings for each affiliate
        $affiliates->getCollection()->transform(function ($affiliate) {
            $affiliate->setAttribute('total_earnings', $affiliate->getTotalEarnings());
            $affiliate->setAttribute('available_balance', $affiliate->getAvailableBalance());
            return $affiliate;
        });

        return Inertia::render('admin/affiliates/index', [
            'affiliates' => $affiliates,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new affiliate.
     */
    public function create()
    {
        return Inertia::render('admin/affiliates/create');
    }

    /**
     * Store a newly created affiliate.
     */
    public function store(StoreAffiliateRequest $request)
    {
        $affiliate = User::create([
            ...$request->validated(),
            'role' => 'affiliate',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.affiliates.show', $affiliate)
            ->with('success', 'Affiliate created successfully.');
    }

    /**
     * Display the specified affiliate.
     */
    public function show(User $affiliate)
    {
        if ($affiliate->role !== 'affiliate') {
            abort(404);
        }

        $affiliate->load([
            'referrals' => function($q) {
                $q->with('program')->latest()->take(10);
            },
            'clicks' => function($q) {
                $q->latest()->take(10);
            },
            'payouts' => function($q) {
                $q->latest()->take(10);
            }
        ]);

        $stats = [
            'total_clicks' => $affiliate->clicks()->count(),
            'total_referrals' => $affiliate->referrals()->count(),
            'completed_referrals' => $affiliate->completedReferrals()->count(),
            'pending_referrals' => $affiliate->referrals()->where('status', 'pending')->count(),
            'total_earnings' => $affiliate->getTotalEarnings(),
            'pending_earnings' => $affiliate->getPendingEarnings(),
            'total_payouts' => $affiliate->getTotalPayouts(),
            'available_balance' => $affiliate->getAvailableBalance(),
            'conversion_rate' => $affiliate->clicks()->count() > 0 
                ? round(($affiliate->referrals()->count() / $affiliate->clicks()->count()) * 100, 2) 
                : 0,
        ];

        return Inertia::render('admin/affiliates/show', [
            'affiliate' => $affiliate,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form for editing the specified affiliate.
     */
    public function edit(User $affiliate)
    {
        if ($affiliate->role !== 'affiliate') {
            abort(404);
        }

        return Inertia::render('admin/affiliates/edit', [
            'affiliate' => $affiliate,
        ]);
    }

    /**
     * Update the specified affiliate.
     */
    public function update(UpdateAffiliateRequest $request, User $affiliate)
    {
        if ($affiliate->role !== 'affiliate') {
            abort(404);
        }

        $affiliate->update($request->validated());

        return redirect()->route('admin.affiliates.show', $affiliate)
            ->with('success', 'Affiliate updated successfully.');
    }

    /**
     * Remove the specified affiliate.
     */
    public function destroy(User $affiliate)
    {
        if ($affiliate->role !== 'affiliate') {
            abort(404);
        }

        $affiliate->delete();

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate deleted successfully.');
    }
}