<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendAttendanceReminder;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * These commands will be run in a single process,
     * an exception must be thrown if any command throws an exception.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Kirim pengingat presensi setiap 15 menit
        $schedule->job(new SendAttendanceReminder)
            ->everyFifteenMinutes()
            ->between('06:00', '17:00')
            ->weekdays();

        // Kirim laporan bulanan setiap akhir bulan
        $schedule->command('reports:send-monthly')
            ->monthlyOn(28, '08:00');

        // Kirim pengingat tugas setiap hari pada pukul 8 pagi
        $schedule->command('tasks:send-reminders')->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
