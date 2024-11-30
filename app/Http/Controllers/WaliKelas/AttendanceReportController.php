<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function index()
    {
        // Memastikan pengguna terautentikasi sebelum mengambil data siswa
        if (auth()->guard('web')->check()) {
            $students = User::where('class_id', auth()->guard('web')->user()->homeroom_class_id)->get();
            return view('walikelas.attendance-report.index', compact('students'));
        }

        return redirect()->route('login'); // Redirect ke halaman login jika tidak terautentikasi
    }

    public function show(Request $request, User $student)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $attendances = Attendance::where('student_id', $student->id)
            ->whereMonth('date', $request->month)
            ->with('schedule.subject')
            ->get();

        return view('walikelas.attendance-report.show', compact('attendances', 'student'));
    }
}
