<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $attendances;
    protected $type;

    public function __construct($attendances, $type = 'student')
    {
        $this->attendances = $attendances;
        $this->type = $type;
    }

    public function collection()
    {
        return $this->attendances;
    }

    public function headings(): array
    {
        if ($this->type === 'student') {
            return [
                'Tanggal',
                'Mata Pelajaran',
                'Guru',
                'Status',
                'Keterangan'
            ];
        }

        return [
            'Tanggal',
            'Nama Siswa',
            'Status',
            'Keterangan'
        ];
    }

    public function map($attendance): array
    {
        if ($this->type === 'student') {
            return [
                $attendance->date->format('d/m/Y'),
                $attendance->schedule->subject->name,
                $attendance->schedule->teacher->name,
                ucfirst($attendance->status),
                $attendance->note
            ];
        }

        return [
            $attendance->date->format('d/m/Y'),
            $attendance->student->name,
            ucfirst($attendance->status),
            $attendance->note
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
} 
