<?php

namespace App\Imports;

use App\Models\Schedule;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScheduleImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $class = ClassRoom::where('name', $row['kelas'])->first();
        $subject = Subject::where('name', $row['mata_pelajaran'])->first();
        $teacher = User::where('name', $row['guru'])->first();

        return new Schedule([
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'day' => $row['hari'],
            'start_time' => $row['jam_mulai'],
            'end_time' => $row['jam_selesai'],
        ]);
    }

    public function rules(): array
    {
        return [
            'kelas' => 'required|exists:classes,name',
            'mata_pelajaran' => 'required|exists:subjects,name',
            'guru' => 'required|exists:users,name',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ];
    }
}
