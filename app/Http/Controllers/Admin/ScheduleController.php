<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ScheduleExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\NotificationService;
use App\Imports\ScheduleImport;

class ScheduleController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $classes = ClassRoom::all();
        $schedules = Schedule::with(['class', 'subject', 'teacher'])
            ->when($request->class_id, function ($query) use ($request) {
                $query->where('class_id', $request->class_id);
            })
            ->when($request->day, function ($query) use ($request) {
                $query->where('day', $request->day);
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->paginate(10);

        return view('admin.schedules.index', compact('schedules', 'classes'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'guru');
        })->get();

        return view('admin.schedules.create', compact('classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Validasi bentrokan jadwal
        $conflict = Schedule::where('class_id', $request->class_id)
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['conflict' => 'Jadwal bentrok dengan jadwal lain.'])->withInput();
        }

        Schedule::create($validated);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Schedule $schedule)
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'guru');
        })->get();

        return view('admin.schedules.edit', compact('schedule', 'classes', 'subjects', 'teachers'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Validasi bentrokan jadwal
        $conflict = Schedule::where('class_id', $request->class_id)
            ->where('day', $request->day)
            ->where('id', '!=', $schedule->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['conflict' => 'Jadwal bentrok dengan jadwal lain.'])->withInput();
        }

        $oldTeacherId = $schedule->teacher_id;
        $oldClassId = $schedule->class_id;

        $schedule->update($validated);

        // Kirim notifikasi jika ada perubahan guru atau kelas
        if ($oldTeacherId != $request->teacher_id) {
            $teacher = User::find($request->teacher_id);
            $this->notificationService->sendScheduleChangeNotification(
                collect([$teacher]),
                'Perubahan Jadwal Mengajar',
                "Anda telah ditugaskan mengajar {$schedule->subject->name} di kelas {$schedule->class->name}"
            );
        }

        if ($oldClassId != $request->class_id) {
            $students = User::whereHas('role', function ($query) {
                $query->where('name', 'siswa');
            })->where('class_id', $request->class_id)->get();

            $this->notificationService->sendScheduleChangeNotification(
                $students,
                'Perubahan Jadwal Kelas',
                "Ada perubahan jadwal untuk mata pelajaran {$schedule->subject->name}"
            );
        }

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
        $schedules = Schedule::with(['class', 'subject', 'teacher'])
            ->when($request->class_id, function ($query) use ($request) {
                $query->where('class_id', $request->class_id);
            })
            ->when($request->day, function ($query) use ($request) {
                $query->where('day', $request->day);
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $pdf = PDF::loadView('exports.schedule-pdf', [
            'schedules' => $schedules,
            'title' => 'Jadwal Pelajaran'
        ]);

        return $pdf->download('jadwal-pelajaran.pdf');
    }

    public function exportExcel(Request $request)
    {
        $schedules = Schedule::with(['class', 'subject', 'teacher'])
            ->when($request->class_id, function ($query) use ($request) {
                $query->where('class_id', $request->class_id);
            })
            ->when($request->day, function ($query) use ($request) {
                $query->where('day', $request->day);
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return Excel::download(new ScheduleExport($schedules), 'jadwal-pelajaran.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new ScheduleImport, $request->file('file'));

            return redirect()
                ->route('admin.schedules.index')
                ->with('success', 'Jadwal berhasil diimport');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.schedules.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
