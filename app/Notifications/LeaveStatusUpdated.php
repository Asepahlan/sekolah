<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $status = ucfirst($this->leave->status);
        $type = ucfirst($this->leave->type);

        return (new MailMessage)
            ->subject("Pengajuan {$type} - {$status}")
            ->line("Pengajuan {$type} Anda telah {$this->leave->status}.")
            ->line("Tanggal: {$this->leave->start_date->format('d/m/Y')} - {$this->leave->end_date->format('d/m/Y')}")
            ->when($this->leave->notes, function ($message) {
                return $message->line("Catatan: {$this->leave->notes}");
            })
            ->action('Lihat Detail', route('siswa.leaves.show', $this->leave));
    }

    public function toArray($notifiable)
    {
        return [
            'leave_id' => $this->leave->id,
            'type' => $this->leave->type,
            'status' => $this->leave->status,
            'message' => "Pengajuan {$this->leave->type} Anda telah {$this->leave->status}."
        ];
    }
}
