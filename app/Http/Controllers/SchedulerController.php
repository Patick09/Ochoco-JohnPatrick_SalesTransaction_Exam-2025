<?php

namespace App\Http\Controllers;

use App\Models\Scheduler;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function index()
    {
        $schedulers = Scheduler::all();
        return view('schedulers.index', compact('schedulers'));
    }

    public function create()
    {
        return view('schedulers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event' => 'nullable|string',
        ]);

        Scheduler::create($request->only(['name', 'event']));

        return redirect()->route('schedulers.index')
            ->with('success', 'Scheduler created successfully.');
    }

    public function edit(Scheduler $scheduler)
    {
        return view('schedulers.edit', compact('scheduler'));
    }

    public function update(Request $request, Scheduler $scheduler)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event' => 'nullable|string',
        ]);

        $scheduler->update($request->only(['name', 'event']));

        return redirect()->route('schedulers.index')
            ->with('success', 'Scheduler updated successfully.');
    }

    public function destroy(Scheduler $scheduler)
    {
        $scheduler->delete();

        return redirect()->route('schedulers.index')
            ->with('success', 'Scheduler deleted successfully.');
    }
}
