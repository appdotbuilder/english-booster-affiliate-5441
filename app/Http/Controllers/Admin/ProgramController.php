<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs.
     */
    public function index(Request $request)
    {
        $query = Program::withCount(['referrals', 'clicks']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->type && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->status && $request->status !== 'all') {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $programs = $query->latest()->paginate(15);

        return Inertia::render('admin/programs/index', [
            'programs' => $programs,
            'filters' => $request->only(['search', 'type', 'status']),
            'program_types' => Program::TYPES,
        ]);
    }

    /**
     * Show the form for creating a new program.
     */
    public function create()
    {
        return Inertia::render('admin/programs/create', [
            'program_types' => Program::TYPES,
        ]);
    }

    /**
     * Store a newly created program.
     */
    public function store(StoreProgramRequest $request)
    {
        $program = Program::create($request->validated());

        return redirect()->route('admin.programs.show', $program)
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program)
    {
        $program->load([
            'referrals' => function($q) {
                $q->with('affiliate')->latest()->take(10);
            }
        ]);

        $stats = [
            'total_clicks' => $program->clicks()->count(),
            'total_referrals' => $program->referrals()->count(),
            'completed_referrals' => $program->referrals()->where('status', 'completed')->count(),
            'pending_referrals' => $program->referrals()->where('status', 'pending')->count(),
            'total_revenue' => $program->referrals()->where('status', 'completed')->count() * $program->price,
            'total_commissions' => $program->referrals()->where('status', 'completed')->sum('commission_amount'),
            'conversion_rate' => $program->clicks()->count() > 0 
                ? round(($program->referrals()->count() / $program->clicks()->count()) * 100, 2) 
                : 0,
        ];

        return Inertia::render('admin/programs/show', [
            'program' => $program,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form for editing the specified program.
     */
    public function edit(Program $program)
    {
        return Inertia::render('admin/programs/edit', [
            'program' => $program,
            'program_types' => Program::TYPES,
        ]);
    }

    /**
     * Update the specified program.
     */
    public function update(UpdateProgramRequest $request, Program $program)
    {
        $program->update($request->validated());

        return redirect()->route('admin.programs.show', $program)
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}