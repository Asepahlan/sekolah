<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('class_id', Auth::user()->class_id)
            ->with(['subject', 'teacher'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->paginate(10);

        return view('siswa.schedule', compact('schedules'));
    }
}
