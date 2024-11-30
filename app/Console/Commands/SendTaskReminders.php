<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks due soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::where('due_date', '<=', now()->addDays(3))
            ->where('status', 'pending')
            ->with('student')
            ->get();

        foreach ($tasks as $task) {
            Mail::to($task->student->email)->send(new \App\Mail\TaskReminder($task));
        }

        $this->info('Task reminders sent successfully!');
    }
}
