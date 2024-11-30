<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use App\Notifications\LeaveStatusUpdated;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::whereHas('student', function ($query) {
                $query->where('class_id', auth()->user()->homeroom_class_id);
            })
            ->with(['student', 'approver'])
            ->latest()
            ->paginate(10);

        return view('walikelas.leaves.index', compact('leaves'));
    }

    public function show(Leave $leave)
    {
        $this->authorize('review', $leave);
        return view('walikelas.leaves.show', compact('leave'));
    }

    public function update(Request $request, Leave $leave)
    {
        $this->authorize('review', $leave);

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        $validated['approved_by'] = auth()->id();

        $leave->update($validated);

        // Kirim notifikasi ke siswa
        $leave->student->notify(new LeaveStatusUpdated($leave));

        return redirect()
            ->route('walikelas.leaves.index')
            ->with('success', 'Status izin berhasil diupdate');
    }
} 
