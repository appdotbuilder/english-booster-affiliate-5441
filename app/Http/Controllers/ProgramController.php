<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\User;
use App\Services\AffiliateTrackingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private AffiliateTrackingService $trackingService
    ) {}
    /**
     * Display a listing of programs.
     */
    public function index(Request $request)
    {
        $query = Program::active();

        if ($request->type && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $programs = $query->latest()->paginate(12);

        // Track affiliate click if referral code present
        if ($request->ref) {
            $affiliate = User::where('referral_code', $request->ref)
                ->where('role', 'affiliate')
                ->where('is_active', true)
                ->first();

            if ($affiliate) {
                $this->trackingService->trackClick($request, $affiliate);
            }
        }

        return Inertia::render('programs/index', [
            'programs' => $programs,
            'program_types' => Program::TYPES,
            'filters' => $request->only(['search', 'type']),
            'ref' => $request->ref,
        ]);
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program, Request $request)
    {
        if (!$program->is_active) {
            abort(404);
        }

        // Track affiliate click if referral code present
        if ($request->ref) {
            $affiliate = User::where('referral_code', $request->ref)
                ->where('role', 'affiliate')
                ->where('is_active', true)
                ->first();

            if ($affiliate) {
                $this->trackingService->trackClick($request, $affiliate, $program);
            }
        }

        $relatedPrograms = Program::active()
            ->where('type', $program->type)
            ->where('id', '!=', $program->id)
            ->limit(3)
            ->get();

        return Inertia::render('programs/show', [
            'program' => $program,
            'related_programs' => $relatedPrograms,
            'ref' => $request->ref,
        ]);
    }


}