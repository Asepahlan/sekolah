<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendAttendanceReminder extends Command
{
    protected $signature = 'attendance:remind';
    protected $description = 'Send attendance reminders to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Logika untuk mengirim pengingat kehadiran
        $this->info('Sending attendance reminders...');
        // Tambahkan logika pengiriman email atau notifikasi di sini
    }
}
