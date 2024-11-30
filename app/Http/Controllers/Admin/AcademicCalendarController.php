<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    public function index()
    {
        $events = AcademicCalendar::all();
        return view('admin.calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|string',
            'color' => 'required|string'
        ]);

        AcademicCalendar::create($validated);

        return response()->json(['message' => 'Event berhasil ditambahkan']);
    }

    public function update(Request $request, AcademicCalendar $calendar)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|string',
            'color' => 'required|string'
        ]);

        $calendar->update($validated);

        return response()->json(['message' => 'Event berhasil diupdate']);
    }

    public function destroy(AcademicCalendar $calendar)
    {
        $calendar->delete();
        return response()->json(['message' => 'Event berhasil dihapus']);
    }
}
