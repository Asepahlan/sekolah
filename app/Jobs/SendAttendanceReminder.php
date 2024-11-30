<?php

namespace App\Jobs;

use App\Models\Schedule;
use App\Services\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAttendanceReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(FirebaseService $firebase)
    {
        $today = now()->format('l');
        $currentTime = now()->addMinutes(15)->format('H:i');

        $schedules = Schedule::where('day', $today)
            ->where('start_time', $currentTime)
            ->with(['class.students', 'subject'])
            ->get();

        foreach ($schedules as $schedule) {
            $tokens = $schedule->class->students()
                ->whereNotNull('device_token')
                ->pluck('device_token')
                ->toArray();

            if (!empty($tokens)) {
                $firebase->sendMulticast(
                    $tokens,
                    'Pengingat Jadwal',
                    "Pelajaran {$schedule->subject->name} akan dimulai dalam 15 menit",
                    [
                        'schedule_id' => $schedule->id,
                        'type' => 'schedule_reminder'
                    ]
                );
            }
        }
    }
} 
