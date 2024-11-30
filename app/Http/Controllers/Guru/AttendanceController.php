<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendAbsenceNotification;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::where('teacher_id', Auth::user()->id)
            ->with('class', 'subject')
            ->get();

        $selectedSchedule = null;
        $students = collect();
        $attendances = collect();

        if ($request->schedule_id && $request->date) {
            $selectedSchedule = Schedule::find($request->schedule_id);
            $students = User::where('class_id', $selectedSchedule->class_id)
                ->whereHas('role', fn($q) => $q->where('name', 'siswa'))
                ->get();

            $attendances = Attendance::where('schedule_id', $request->schedule_id)
                ->where('date', $request->date)
                ->get()
                ->keyBy('student_id');
        }

        return view('guru.attendance.index', compact(
            'schedules',
            'selectedSchedule',
            'students',
            'attendances'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpha',
            'attendances.*.note' => 'nullable|string'
        ]);

        foreach ($request->attendances as $data) {
            $attendance = Attendance::updateOrCreate(
                [
                    'schedule_id' => $request->schedule_id,
                    'date' => $request->date,
                    'student_id' => $data['student_id']
                ],
                [
                    'status' => $data['status'],
                    'note' => $data['note'] ?? null
                ]
            );

            // Dispatch notification job for absence
            if ($data['status'] === 'alpha') {
                SendAbsenceNotification::dispatch($attendance);
            }
        }

        return redirect()
            ->route('guru.attendance.index')
            ->with('success', 'Presensi berhasil disimpan');
    }

    public function report(Request $request)
    {
        $schedules = Schedule::where('teacher_id', Auth::user()->id)
            ->with('class', 'subject')
            ->get();

        $attendances = collect();

        if ($request->schedule_id && $request->month) {
            $attendances = Attendance::where('schedule_id', $request->schedule_id)
                ->whereYear('date', now()->year)
                ->whereMonth('date', $request->month)
                ->with(['student', 'schedule'])
                ->get()
                ->groupBy('student_id');
        }

        return view('guru.attendance.report', compact('schedules', 'attendances'));
    }

    public function export(Request $request)
    {
        $attendances = Attendance::where('schedule_id', $request->schedule_id)
            ->when($request->date, function($query) use ($request) {
                $query->whereDate('date', $request->date);
            })
            ->with(['student', 'schedule.subject'])
            ->get();

        return Excel::download(
            new AttendanceExport($attendances, 'teacher'),
            'laporan-presensi.xlsx'
        );
    }
}
