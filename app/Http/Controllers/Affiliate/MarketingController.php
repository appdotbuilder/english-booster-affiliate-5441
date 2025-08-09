<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MarketingController extends Controller
{
    /**
     * Display marketing materials.
     */
    public function index(Request $request)
    {
        $affiliate = $request->user();
        $programs = Program::active()->get();

        // Generate referral links for each program
        $programs->transform(function ($program) use ($affiliate) {
            $program->setAttribute('referral_link', url('/programs/' . $program->id . '?ref=' . $affiliate->referral_code));
            return $program;
        });

        $referralLink = url('/register?ref=' . $affiliate->referral_code);

        return Inertia::render('affiliate/marketing', [
            'programs' => $programs,
            'referral_link' => $referralLink,
            'affiliate' => $affiliate,
        ]);
    }
}