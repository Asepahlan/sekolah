<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::orderBy('level')->orderBy('name')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classes',
            'level' => 'required|string|in:X,XI,XII',
            'capacity' => 'required|integer|min:0'
        ]);

        ClassRoom::create($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit(ClassRoom $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classes,name,' . $class->id,
            'level' => 'required|string|in:X,XI,XII',
            'capacity' => 'required|integer|min:0'
        ]);

        $class->update($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Kelas berhasil dihapus');
    }
}
