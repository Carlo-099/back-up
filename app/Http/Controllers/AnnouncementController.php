<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message_anounce' => 'required|string|min:10'
        ]);

        $announcement = Announcement::create([
            'users_id' => Auth::id(),
            'message_anounce' => $request->message_anounce
        ]);

        return redirect()->back()->with('success', 'Announcement has been sent successfully!');
    }
}
