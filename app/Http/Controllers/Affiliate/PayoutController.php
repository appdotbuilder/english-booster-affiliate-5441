<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayoutController extends Controller
{
    /**
     * Display affiliate payouts.
     */
    public function index(Request $request)
    {
        $affiliate = $request->user();
        
        $query = $affiliate->payouts();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $payouts = $query->latest()->paginate(15);

        $stats = [
            'available_balance' => $affiliate->getAvailableBalance(),
            'total_payouts' => $affiliate->getTotalPayouts(),
            'pending_payouts' => $affiliate->payouts()->where('status', 'pending')->sum('amount'),
        ];

        return Inertia::render('affiliate/payouts', [
            'payouts' => $payouts,
            'stats' => $stats,
            'filters' => $request->only(['status']),
        ]);
    }
}