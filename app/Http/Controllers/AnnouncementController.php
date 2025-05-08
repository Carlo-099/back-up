<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Get recent active users, ordered by last login time
        $activeUsers = User::where('is_admin', false)
            ->orderBy('last_login_at', 'desc')
            ->take(10)
            ->get();

        return view('Admin_view.SendAnnouncement', compact('activeUsers'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'announcement' => 'required|string|max:500',
        ]);

        // Check if user is admin
        if (!Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Only administrators can send announcements.');
        }

        // Create the announcement
        $announcement = new Announcement();
        $announcement->user_id = Auth::id();
        $announcement->message_anounce = $validated['announcement'];
        $announcement->save();

        return redirect()->back()->with('success', 'Announcement sent successfully!');
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Mark the announcement as read for the current user
        $announcement->markAsRead(Auth::id());

        return response()->json($announcement);
    }

    // Add this method to mark announcements as read
    public function markAsRead($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->markAsRead(Auth::id());
        return response()->json(['success' => true]);
    }
}
