<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ScheduleExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('teacher_id', Auth::id())
            ->with(['class', 'subject'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->paginate(10);

        return view('guru.schedule', compact('schedules'));
    }

    public function exportPdf()
    {
        $schedules = Schedule::where('teacher_id', Auth::id())
            ->with(['class', 'subject'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $pdf = PDF::loadView('exports.schedule-pdf', [
            'schedules' => $schedules,
            'title' => 'Jadwal Mengajar - ' . Auth::user()->name
        ]);

        return $pdf->download('jadwal-mengajar.pdf');
    }

    public function exportExcel()
    {
        $schedules = Schedule::where('teacher_id', Auth::id())
            ->with(['class', 'subject'])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return Excel::download(new ScheduleExport($schedules), 'jadwal-mengajar.xlsx');
    }
}
