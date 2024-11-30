<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\StudentReportService;
use Illuminate\Console\Command;

class SendMonthlyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly reports to parents';

    /**
     * Execute the console command.
     */
    public function handle(StudentReportService $reportService)
    {
        $students = User::whereHas('role', fn($q) => $q->where('name', 'siswa'))
            ->whereNotNull('parent_email')
            ->get();

        $bar = $this->output->createProgressBar(count($students));
        $this->info('Sending monthly reports...');

        foreach ($students as $student) {
            $reportService->sendMonthlyReportToParent($student);
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nMonthly reports sent successfully!");
    }
}
