<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all(); // Ambil semua jadwal
        return view('schedules.index', compact('schedules')); // Kembalikan tampilan
    }

    // Metode lainnya...
}
