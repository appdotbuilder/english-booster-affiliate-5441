<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\Referral;
use App\Models\Payout;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_affiliates' => User::where('role', 'affiliate')->count(),
            'active_affiliates' => User::where('role', 'affiliate')->where('is_active', true)->count(),
            'total_programs' => Program::count(),
            'active_programs' => Program::where('is_active', true)->count(),
            'total_referrals' => Referral::count(),
            'completed_referrals' => Referral::where('status', 'completed')->count(),
            'pending_referrals' => Referral::where('status', 'pending')->count(),
            'total_commission_paid' => Payout::where('status', 'completed')->sum('amount'),
            'pending_payouts' => Payout::where('status', 'pending')->sum('amount'),
            'total_revenue' => Referral::where('status', 'completed')
                ->join('programs', 'referrals.program_id', '=', 'programs.id')
                ->sum('programs.price'),
        ];

        $recent_referrals = Referral::with(['affiliate', 'program'])
            ->latest()
            ->take(10)
            ->get();

        $top_affiliates = User::where('role', 'affiliate')
            ->withCount(['completedReferrals'])
            ->orderBy('completed_referrals_count', 'desc')
            ->take(5)
            ->get();

        $recent_payouts = Payout::with('affiliate')
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('admin/dashboard', [
            'stats' => $stats,
            'recent_referrals' => $recent_referrals,
            'top_affiliates' => $top_affiliates,
            'recent_payouts' => $recent_payouts,
        ]);
    }
}