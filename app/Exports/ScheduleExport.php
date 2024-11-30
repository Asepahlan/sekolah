<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ScheduleExport implements FromCollection, WithHeadings, WithMapping
{
    protected $schedules;

    public function __construct($schedules)
    {
        $this->schedules = $schedules;
    }

    public function collection()
    {
        return $this->schedules;
    }

    public function headings(): array
    {
        return [
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
            'Kelas',
            'Mata Pelajaran',
            'Guru'
        ];
    }

    public function map($schedule): array
    {
        return [
            $schedule->day,
            $schedule->start_time,
            $schedule->end_time,
            $schedule->class->name,
            $schedule->subject->name,
            $schedule->teacher->name
        ];
    }
}
