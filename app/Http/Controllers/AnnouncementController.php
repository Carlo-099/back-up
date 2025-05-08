<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $validated = $request->validate([
            'announcement' => 'required|string|max:500',
        ]);

        // Here you would typically save the announcement to the database
        // and notify users. For now, we'll just redirect back with a success message

        return redirect()->back()->with('success', 'Announcement sent successfully!');
    }
}
