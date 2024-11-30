<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user')
            ->latest()
            ->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        $announcement = new Announcement($validated);
        $announcement->user_id = Auth::id();

        if ($request->status === 'published') {
            $announcement->published_at = now();
        }

        $announcement->save();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->status === 'published' && $announcement->status === 'draft') {
            $validated['published_at'] = now();
        }

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diupdate');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}
