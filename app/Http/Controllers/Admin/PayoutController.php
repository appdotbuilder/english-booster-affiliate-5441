<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayoutRequest;
use App\Http\Requests\UpdatePayoutRequest;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayoutController extends Controller
{
    /**
     * Display a listing of payouts.
     */
    public function index(Request $request)
    {
        $query = Payout::with('affiliate');

        if ($request->search) {
            $query->whereHas('affiliate', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->affiliate_id) {
            $query->where('affiliate_id', $request->affiliate_id);
        }

        $payouts = $query->latest()->paginate(15);

        $affiliates = User::where('role', 'affiliate')->select('id', 'name')->get();

        return Inertia::render('admin/payouts/index', [
            'payouts' => $payouts,
            'filters' => $request->only(['search', 'status', 'affiliate_id']),
            'affiliates' => $affiliates,
            'statuses' => Payout::STATUSES,
            'methods' => Payout::METHODS,
        ]);
    }

    /**
     * Show the form for creating a new payout.
     */
    public function create(Request $request)
    {
        $affiliateId = $request->affiliate_id;
        $affiliates = User::where('role', 'affiliate')
            ->where('is_active', true)
            ->select('id', 'name', 'email')
            ->get()
            ->map(function ($affiliate) {
                $affiliate->setAttribute('available_balance', $affiliate->getAvailableBalance());
                return $affiliate;
            });

        $selectedAffiliate = null;
        if ($affiliateId) {
            $selectedAffiliate = User::find($affiliateId);
            if ($selectedAffiliate) {
                $selectedAffiliate->setAttribute('available_balance', $selectedAffiliate->getAvailableBalance());
            }
        }

        return Inertia::render('admin/payouts/create', [
            'affiliates' => $affiliates,
            'selected_affiliate' => $selectedAffiliate,
            'methods' => Payout::METHODS,
        ]);
    }

    /**
     * Store a newly created payout.
     */
    public function store(StorePayoutRequest $request)
    {
        $affiliate = User::find($request->affiliate_id);
        $availableBalance = $affiliate->getAvailableBalance();

        if ($request->amount > $availableBalance) {
            return redirect()->back()
                ->withErrors(['amount' => 'Payout amount exceeds available balance.'])
                ->withInput();
        }

        $payout = Payout::create($request->validated());

        return redirect()->route('admin.payouts.show', $payout)
            ->with('success', 'Payout created successfully.');
    }

    /**
     * Display the specified payout.
     */
    public function show(Payout $payout)
    {
        $payout->load('affiliate');

        return Inertia::render('admin/payouts/show', [
            'payout' => $payout,
        ]);
    }

    /**
     * Show the form for editing the specified payout.
     */
    public function edit(Payout $payout)
    {
        $payout->load('affiliate');

        return Inertia::render('admin/payouts/edit', [
            'payout' => $payout,
            'methods' => Payout::METHODS,
            'statuses' => Payout::STATUSES,
        ]);
    }

    /**
     * Update the specified payout.
     */
    public function update(UpdatePayoutRequest $request, Payout $payout)
    {
        $data = $request->validated();

        // Set processed_at when marking as completed
        if ($data['status'] === 'completed' && $payout->status !== 'completed') {
            $data['processed_at'] = now();
        }

        $payout->update($data);

        return redirect()->route('admin.payouts.show', $payout)
            ->with('success', 'Payout updated successfully.');
    }

    /**
     * Remove the specified payout.
     */
    public function destroy(Payout $payout)
    {
        if ($payout->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Cannot delete completed payout.');
        }

        $payout->delete();

        return redirect()->route('admin.payouts.index')
            ->with('success', 'Payout deleted successfully.');
    }
}