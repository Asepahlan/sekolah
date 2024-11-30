<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $pdf;

    public function __construct(User $student, $pdf)
    {
        $this->student = $student;
        $this->pdf = $pdf;
    }

    public function build()
    {
        $month = now()->format('F Y');

        return $this->subject("Laporan Bulanan Siswa - {$month}")
            ->view('emails.monthly-report')
            ->attachData(
                $this->pdf->output(),
                "laporan-{$this->student->name}-{$month}.pdf"
            );
    }
}
