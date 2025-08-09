<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Program;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegistrationController extends Controller
{
    /**
     * Show the registration form for a program.
     */
    public function create(Program $program, Request $request)
    {
        if (!$program->is_active) {
            abort(404);
        }

        $affiliate = null;
        if ($request->ref) {
            $affiliate = User::where('referral_code', $request->ref)
                ->where('role', 'affiliate')
                ->where('is_active', true)
                ->first();
        }

        return Inertia::render('registration/create', [
            'program' => $program,
            'affiliate' => $affiliate,
            'ref' => $request->ref,
        ]);
    }

    /**
     * Store a new registration.
     */
    public function store(StoreRegistrationRequest $request, Program $program)
    {
        if (!$program->is_active) {
            abort(404);
        }

        $data = $request->validated();
        $affiliate = null;

        // Find affiliate if referral code provided
        if ($data['referral_code']) {
            $affiliate = User::where('referral_code', $data['referral_code'])
                ->where('role', 'affiliate')
                ->where('is_active', true)
                ->first();
        }

        // Create referral record
        $referralData = [
            'program_id' => $program->id,
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'customer_phone' => $data['phone'],
            'status' => 'pending',
            'customer_data' => [
                'address' => $data['address'] ?? null,
                'age' => $data['age'] ?? null,
                'motivation' => $data['motivation'] ?? null,
                'learning_goals' => $data['learning_goals'] ?? null,
                'previous_experience' => $data['previous_experience'] ?? null,
            ],
        ];

        if ($affiliate) {
            $commissionRate = $program->commission_rate ?? $affiliate->commission_rate;
            $commissionAmount = ($program->price * $commissionRate) / 100;

            $referralData['affiliate_id'] = $affiliate->id;
            $referralData['commission_rate'] = $commissionRate;
            $referralData['commission_amount'] = $commissionAmount;
        } else {
            // Create a referral without affiliate (direct registration)
            $referralData['affiliate_id'] = null;
            $referralData['commission_rate'] = 0;
            $referralData['commission_amount'] = 0;
        }

        $referral = Referral::create($referralData);

        // Send confirmation email (implement as needed)
        // Mail::to($data['email'])->send(new RegistrationConfirmation($referral));

        $referral->load('program');

        return Inertia::render('registration/success', [
            'referral' => $referral,
            'program' => $program,
            'affiliate' => $affiliate,
        ]);
    }


}