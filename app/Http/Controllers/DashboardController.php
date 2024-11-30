<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];

        if ($user->role->name === 'admin') {
            $stats = $this->getAdminStats();
        } elseif ($user->role->name === 'guru') {
            $stats = $this->getTeacherStats($user->id);
        } elseif ($user->role->name === 'siswa') {
            $stats = $this->getStudentStats($user->id);
        }

        return view('dashboard', compact('stats'));
    }

    private function getAdminStats()
    {
        $currentMonth = now()->month;

        return [
            'total_students' => User::whereHas('role', fn($q) => $q->where('name', 'siswa'))->count(),
            'total_teachers' => User::whereHas('role', fn($q) => $q->where('name', 'guru'))->count(),
            'attendance_summary' => Attendance::whereMonth('date', $currentMonth)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
            'daily_attendance' => Attendance::whereMonth('date', $currentMonth)
                ->select('date', DB::raw('count(*) as total'))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->map(fn($item) => [
                    'date' => $item->date->format('d/m'),
                    'total' => $item->total
                ])
        ];
    }

    private function getTeacherStats($teacherId)
    {
        $currentMonth = now()->month;

        return [
            'total_classes' => Schedule::where('teacher_id', $teacherId)
                ->distinct('class_id')
                ->count(),
            'total_subjects' => Schedule::where('teacher_id', $teacherId)
                ->distinct('subject_id')
                ->count(),
            'attendance_summary' => Attendance::whereHas('schedule', fn($q) => $q->where('teacher_id', $teacherId))
                ->whereMonth('date', $currentMonth)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
            'class_attendance' => Schedule::where('teacher_id', $teacherId)
                ->with(['class', 'attendances' => fn($q) => $q->whereMonth('date', $currentMonth)])
                ->get()
                ->map(fn($schedule) => [
                    'class' => $schedule->class->name,
                    'total' => $schedule->attendances->count(),
                    'hadir' => $schedule->attendances->where('status', 'hadir')->count()
                ])
        ];
    }

    private function getStudentStats($studentId)
    {
        $currentMonth = now()->month;

        return [
            'attendance_summary' => Attendance::where('student_id', $studentId)
                ->whereMonth('date', $currentMonth)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
            'subject_attendance' => Attendance::where('student_id', $studentId)
                ->whereMonth('date', $currentMonth)
                ->with('schedule.subject')
                ->get()
                ->groupBy('schedule.subject.name')
                ->map(fn($items) => [
                    'total' => $items->count(),
                    'hadir' => $items->where('status', 'hadir')->count()
                ])
        ];
    }
}
