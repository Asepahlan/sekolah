<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $classId = auth()->user()->homeroom_class_id;

        // Statistik siswa
        $totalStudents = User::where('class_id', $classId)->count();

        // Kehadiran hari ini
        $today = now()->format('Y-m-d');
        $todayAttendance = Attendance::whereHas('student', function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->whereDate('date', $today)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Izin yang pending
        $pendingLeaves = Leave::whereHas('student', function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->where('status', 'pending')
            ->count();

        // Statistik kehadiran bulan ini
        $monthlyAttendance = Attendance::whereHas('student', function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->whereMonth('date', now()->month)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Daftar siswa dengan kehadiran terendah
        $lowAttendanceStudents = User::where('class_id', $classId)
            ->withCount(['attendances as total_absences' => function($q) {
                $q->whereMonth('date', now()->month)
                    ->where('status', 'alpha');
            }])
            ->having('total_absences', '>', 0)
            ->orderByDesc('total_absences')
            ->limit(5)
            ->get();

        return view('walikelas.dashboard', compact(
            'totalStudents',
            'todayAttendance',
            'pendingLeaves',
            'monthlyAttendance',
            'lowAttendanceStudents'
        ));
    }

    public function students()
    {
        $students = User::where('class_id', auth()->user()->homeroom_class_id)
            ->withCount(['attendances as total_present' => function($q) {
                $q->whereMonth('date', now()->month)
                    ->where('status', 'hadir');
            }])
            ->withCount(['attendances as total_absences' => function($q) {
                $q->whereMonth('date', now()->month)
                    ->where('status', 'alpha');
            }])
            ->withCount(['leaves as active_leaves' => function($q) {
                $q->where('status', 'approved')
                    ->where('end_date', '>=', now());
            }])
            ->paginate(15);

        return view('walikelas.students', compact('students'));
    }

    public function studentDetail(User $student)
    {
        $this->authorize('view', $student);

        $attendances = Attendance::where('student_id', $student->id)
            ->with(['schedule.subject', 'schedule.teacher'])
            ->latest('date')
            ->paginate(10);

        $leaves = Leave::where('student_id', $student->id)
            ->latest()
            ->get();

        $monthlyStats = Attendance::where('student_id', $student->id)
            ->whereYear('date', now()->year)
            ->select(
                DB::raw('MONTH(date) as month'),
                'status',
                DB::raw('count(*) as total')
            )
            ->groupBy('month', 'status')
            ->get()
            ->groupBy('month');

        return view('walikelas.student-detail', compact(
            'student',
            'attendances',
            'leaves',
            'monthlyStats'
        ));
    }
} 
