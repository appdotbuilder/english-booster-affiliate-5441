<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the affiliate dashboard.
     */
    public function index(Request $request)
    {
        $affiliate = $request->user();
        
        $affiliate->load([
            'referrals' => function($q) {
                $q->with('program')->latest()->take(10);
            },
            'payouts' => function($q) {
                $q->latest()->take(5);
            }
        ]);

        $stats = [
            'total_clicks' => $affiliate->clicks()->count(),
            'today_clicks' => $affiliate->clicks()->whereDate('created_at', today())->count(),
            'total_referrals' => $affiliate->referrals()->count(),
            'completed_referrals' => $affiliate->completedReferrals()->count(),
            'pending_referrals' => $affiliate->referrals()->where('status', 'pending')->count(),
            'total_earnings' => $affiliate->getTotalEarnings(),
            'pending_earnings' => $affiliate->getPendingEarnings(),
            'available_balance' => $affiliate->getAvailableBalance(),
            'total_payouts' => $affiliate->getTotalPayouts(),
            'conversion_rate' => $affiliate->clicks()->count() > 0 
                ? round(($affiliate->referrals()->count() / $affiliate->clicks()->count()) * 100, 2) 
                : 0,
        ];



        // Get referral link with domain
        $referralLink = url('/register?ref=' . $affiliate->referral_code);

        return Inertia::render('affiliate/dashboard', [
            'affiliate' => $affiliate,
            'stats' => $stats,
            'referral_link' => $referralLink,
        ]);
    }


}