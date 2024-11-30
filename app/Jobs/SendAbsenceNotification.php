<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAbsenceNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attendance;

    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function handle(WhatsAppService $whatsapp)
    {
        $student = $this->attendance->student;
        $schedule = $this->attendance->schedule;

        if ($this->attendance->status === 'alpha' && $student->parent_phone) {
            $message = "Yth. Orang Tua/Wali dari {$student->name},\n\n"
                    . "Kami informasikan bahwa putra/putri Bapak/Ibu tidak hadir "
                    . "pada mata pelajaran {$schedule->subject->name} "
                    . "hari {$this->attendance->date->format('d/m/Y')} "
                    . "tanpa keterangan (alpha).\n\n"
                    . "Mohon perhatian Bapak/Ibu untuk hal ini.\n\n"
                    . "Terima kasih.\n"
                    . "SMA Example";

            $whatsapp->sendMessage($student->parent_phone, $message);
        }
    }
}
