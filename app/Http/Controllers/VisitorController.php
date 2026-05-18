<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Visitor;
use Carbon\Carbon;

class VisitorController extends Controller
{
    /**
     * Display a listing of visitors with statistics and optional date filtering.
     */
    public function index(Request $request)
    {
        // Get the selected date for filtering, default to today
        $selectedDateStr = $request->input('date', Carbon::today()->toDateString());
        
        // Stats calculations (always relative to today)
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        $stats = [
            'total_today' => Visitor::whereBetween('time_in', [$todayStart, $todayEnd])->count(),
            'currently_in' => Visitor::whereNull('time_out')->count(),
            'checked_out_today' => Visitor::whereBetween('time_in', [$todayStart, $todayEnd])
                ->whereNotNull('time_out')
                ->count(),
        ];

        // Fetch filtered visitors list
        $query = Visitor::query();

        if ($selectedDateStr) {
            $filterDate = Carbon::parse($selectedDateStr);
            $query->whereDate('time_in', $filterDate);
        }

        $visitors = $query->orderBy('time_in', 'desc')->get();

        return view('dashboard', compact('visitors', 'stats', 'selectedDateStr'));
    }

    /**
     * Store a newly created visitor entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'time_in' => 'required|date',
            'time_out' => 'nullable|date|after_or_equal:time_in',
        ]);

        Visitor::create($validated);

        return redirect()->back()->with('success', 'Visitor registered successfully!');
    }

    /**
     * Update the specified visitor entry.
     */
    public function update(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'time_in' => 'required|date',
            'time_out' => 'nullable|date|after_or_equal:time_in',
        ]);

        $visitor->update($validated);

        return redirect()->back()->with('success', 'Visitor entry updated successfully!');
    }

    /**
     * Quick checkout for a visitor (sets time_out to now).
     */
    public function checkout(Visitor $visitor)
    {
        if (is_null($visitor->time_out)) {
            $visitor->update([
                'time_out' => now(),
            ]);
            return redirect()->back()->with('success', "{$visitor->name} has been checked out successfully.");
        }

        return redirect()->back()->with('error', 'Visitor is already checked out.');
    }

    /**
     * Remove the specified visitor entry.
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();

        return redirect()->back()->with('success', 'Visitor entry deleted successfully!');
    }
}
