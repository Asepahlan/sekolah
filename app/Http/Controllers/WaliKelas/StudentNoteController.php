<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\StudentNote;
use App\Models\User;
use Illuminate\Http\Request;

class StudentNoteController extends Controller
{
    public function store(Request $request, User $student)
    {
        $this->authorize('createNote', $student);

        $validated = $request->validate([
            'type' => 'required|in:prestasi,pelanggaran,lainnya',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'point' => 'required|integer'
        ]);

        $validated['student_id'] = $student->id;
        $validated['teacher_id'] = auth()->id();

        StudentNote::create($validated);

        return redirect()
            ->route('walikelas.students.detail', $student)
            ->with('success', 'Catatan berhasil ditambahkan');
    }

    public function destroy(StudentNote $note)
    {
        $this->authorize('delete', $note);

        $student = $note->student;
        $note->delete();

        return redirect()
            ->route('walikelas.students.detail', $student)
            ->with('success', 'Catatan berhasil dihapus');
    }
} 
