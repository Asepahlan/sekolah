<?php

namespace App\Services;

use App\Models\User;
use App\Models\Attendance;
use App\Models\StudentNote;
use Illuminate\Support\Facades\DB;
use PDF;

class StudentReportService
{
    public function generateMonthlyReport(User $student, $month, $year)
    {
        // Statistik Kehadiran
        $attendanceStats = Attendance::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Catatan Perilaku
        $notes = StudentNote::where('student_id', $student->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with('teacher')
            ->get();

        // Total Poin
        $totalPoints = $notes->sum('point');

        // Generate PDF
        $pdf = PDF::loadView('reports.monthly', compact(
            'student',
            'attendanceStats',
            'notes',
            'totalPoints',
            'month',
            'year'
        ));

        return $pdf;
    }

    public function sendMonthlyReportToParent(User $student)
    {
        $report = $this->generateMonthlyReport(
            $student,
            now()->month,
            now()->year
        );

        // Kirim WhatsApp
        $whatsapp = new WhatsAppService();
        $message = $this->generateWhatsAppMessage($student);

        if ($student->parent_phone) {
            $whatsapp->sendMessage($student->parent_phone, $message);
        }

        // Kirim Email
        if ($student->parent_email) {
            \Mail::to($student->parent_email)
                ->send(new \App\Mail\MonthlyReport($student, $report));
        }
    }

    private function generateWhatsAppMessage(User $student)
    {
        $month = now()->format('F Y');
        $attendanceStats = Attendance::where('student_id', $student->id)
            ->whereMonth('date', now()->month)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return "Yth. Orang Tua/Wali dari {$student->name},\n\n"
            . "Berikut ringkasan kehadiran bulan {$month}:\n"
            . "- Hadir: " . ($attendanceStats['hadir'] ?? 0) . " kali\n"
            . "- Sakit: " . ($attendanceStats['sakit'] ?? 0) . " kali\n"
            . "- Izin: " . ($attendanceStats['izin'] ?? 0) . " kali\n"
            . "- Alpha: " . ($attendanceStats['alpha'] ?? 0) . " kali\n\n"
            . "Laporan lengkap telah dikirim ke email Anda.\n\n"
            . "Terima kasih.\n"
            . "SMA Example";
    }
} 
