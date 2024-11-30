<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('student_id', auth()->user()->id)->get(); // Menggunakan auth()->user()->id
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        Task::create([
            'student_id' => auth()->user()->id, // Menggunakan auth()->user()->id
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
