<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReferralController extends Controller
{
    /**
     * Display affiliate referrals.
     */
    public function index(Request $request)
    {
        $affiliate = $request->user();
        
        $query = $affiliate->referrals()->with('program');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $referrals = $query->latest()->paginate(15);

        return Inertia::render('affiliate/referrals', [
            'referrals' => $referrals,
            'filters' => $request->only(['search', 'status']),
        ]);
    }
}