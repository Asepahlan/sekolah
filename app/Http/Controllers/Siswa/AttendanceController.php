<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::where('class_id', Auth::user()->class_id)
            ->with(['subject', 'teacher'])
            ->get();

        $attendances = Attendance::where('student_id', Auth::id())
            ->when($request->month, function($query) use ($request) {
                $query->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year ?? now()->year);
            })
            ->when($request->schedule_id, function($query) use ($request) {
                $query->where('schedule_id', $request->schedule_id);
            })
            ->with(['schedule.subject', 'schedule.teacher'])
            ->latest('date')
            ->paginate(15);

        $summary = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'alpha' => $attendances->where('status', 'alpha')->count(),
        ];

        return view('siswa.attendance.index', compact('schedules', 'attendances', 'summary'));
    }

    public function export(Request $request)
    {
        $attendances = Attendance::where('student_id', Auth::id())
            ->when($request->month, function($query) use ($request) {
                $query->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year ?? now()->year);
            })
            ->when($request->schedule_id, function($query) use ($request) {
                $query->where('schedule_id', $request->schedule_id);
            })
            ->with(['schedule.subject', 'schedule.teacher'])
            ->get();

        return Excel::download(
            new AttendanceExport($attendances, 'student'),
            'rekap-presensi.xlsx'
        );
    }
}
