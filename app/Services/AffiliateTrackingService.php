<?php

namespace App\Services;

use App\Models\Click;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class AffiliateTrackingService
{
    /**
     * Track affiliate click.
     */
    public function trackClick(Request $request, User $affiliate, Program $program = null): void
    {
        // Avoid duplicate clicks from same IP in short time
        $recentClick = Click::where('affiliate_id', $affiliate->id)
            ->where('ip_address', $request->ip())
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();

        if ($recentClick) {
            return;
        }

        Click::create([
            'affiliate_id' => $affiliate->id,
            'program_id' => $program?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer_url' => $request->header('referer'),
            'landing_page' => $request->fullUrl(),
            'metadata' => [
                'utm_source' => $request->utm_source,
                'utm_medium' => $request->utm_medium,
                'utm_campaign' => $request->utm_campaign,
            ],
        ]);
    }
}