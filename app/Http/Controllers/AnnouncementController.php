<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::published()
            ->with('user')
            ->latest('published_at')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        if ($announcement->status !== 'published') {
            abort(404);
        }

        return view('announcements.show', compact('announcement'));
    }
}
