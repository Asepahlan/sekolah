<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::where('student_id', $request->user()->id)
            ->with(['schedule.subject', 'schedule.teacher'])
            ->when($request->month, function($query) use ($request) {
                $query->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year ?? now()->year);
            })
            ->latest('date')
            ->paginate(15);

        return response()->json($attendances);
    }

    public function summary(Request $request)
    {
        $summary = Attendance::where('student_id', $request->user()->id)
            ->whereMonth('date', now()->month)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        return response()->json($summary);
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        // Validasi jarak lokasi (dalam meter)
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $schedule->latitude,
            $schedule->longitude
        );

        if ($distance > 100) { // Jika lebih dari 100 meter
            return response()->json([
                'message' => 'Anda terlalu jauh dari lokasi sekolah'
            ], 422);
        }

        $attendance = Attendance::create([
            'schedule_id' => $request->schedule_id,
            'student_id' => $request->student_id,
            'status' => $request->status,
            'date' => now()->toDateString(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json([
            'message' => 'Presensi berhasil disimpan',
            'attendance' => $attendance
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $r = 6371000; // Radius bumi dalam meter
        $p1 = $lat1 * pi() / 180;
        $p2 = $lat2 * pi() / 180;
        $dp = ($lat2 - $lat1) * pi() / 180;
        $dl = ($lon2 - $lon1) * pi() / 180;

        $a = sin($dp/2) * sin($dp/2) +
            cos($p1) * cos($p2) *
            sin($dl/2) * sin($dl/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $r * $c;
    }
} 
