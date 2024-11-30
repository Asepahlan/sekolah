<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::where('student_id', auth()->id())
            ->with('approver')
            ->latest()
            ->paginate(10);

        return view('siswa.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('siswa.leaves.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:sakit,izin',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('leaves');
            $validated['attachment'] = $path;
        }

        $validated['student_id'] = auth()->id();

        Leave::create($validated);

        return redirect()
            ->route('siswa.leaves.index')
            ->with('success', 'Pengajuan izin berhasil dikirim');
    }

    public function show(Leave $leave)
    {
        $this->authorize('view', $leave);
        return view('siswa.leaves.show', compact('leave'));
    }

    public function destroy(Leave $leave)
    {
        $this->authorize('delete', $leave);

        if ($leave->attachment) {
            Storage::delete($leave->attachment);
        }

        $leave->delete();

        return redirect()
            ->route('siswa.leaves.index')
            ->with('success', 'Pengajuan izin berhasil dihapus');
    }
} 
