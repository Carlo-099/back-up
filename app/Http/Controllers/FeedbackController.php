<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function index()
    {
        $previousFeedback = Feedback::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('User_view.Feedback', compact('previousFeedback'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $feedback = new Feedback();
        $feedback->user_id = Auth::id();
        $feedback->title = $validated['title'];
        $feedback->message = $validated['message'];
        $feedback->date_sent = now();
        $feedback->save();

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

    public function adminIndex()
    {
        $feedbacks = Feedback::with(['user.reference.settings'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Admin_view.ReadFeedback', compact('feedbacks'));
    }

    public function reply(Request $request, $feedbackId)
    {
        Log::info('Processing feedback reply', [
            'feedback_id' => $feedbackId,
            'admin_id' => Auth::id(),
            'response' => $request->admin_response,
            'all_request_data' => $request->all()
        ]);

        try {
            DB::beginTransaction();

            // Update both admin_response and reset is_read
            $updated = Feedback::where('feedback_id', $feedbackId)
                ->update([
                    'admin_response' => $request->admin_response,
                    'is_read' => false // Reset is_read when new response is added
                ]);

            Log::info('Update attempt result', [
                'updated' => $updated,
                'feedback_id' => $feedbackId,
                'response' => $request->admin_response,
                'is_read_reset' => true
            ]);

            if ($updated) {
                DB::commit();
                return redirect()->back()->with('success', 'Response sent successfully!');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to update response. Please try again.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating feedback response', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'feedback_id' => $feedbackId
            ]);
            return redirect()->back()->with('error', 'Failed to send response. Please try again.');
        }
    }

    // Example method to create feedback
    public function createFeedback()
    {
        $feedback = Feedback::create([
            'user_id' => 1, // Replace with an actual user ID from your users table
            'message' => 'This is a test feedback message.',
            'admin_response' => null, // Admin response is optional
            'date_sent' => now() // Current timestamp
        ]);

        return response()->json($feedback);
    }

    public function markAsRead($feedbackId)
    {
        try {
            Log::info('Attempting to mark feedback as read', [
                'feedback_id' => $feedbackId,
                'user_id' => Auth::id()
            ]);

            $feedback = Feedback::where('feedback_id', $feedbackId)
                ->where('user_id', Auth::id())
                ->first();

            if ($feedback) {
                Log::info('Found feedback, current read status', [
                    'feedback_id' => $feedbackId,
                    'current_is_read' => $feedback->is_read
                ]);

                $feedback->is_read = true;
                $saved = $feedback->save();

                Log::info('Updated feedback read status', [
                    'feedback_id' => $feedbackId,
                    'save_success' => $saved,
                    'new_is_read' => $feedback->is_read
                ]);

                return response()->json(['success' => true]);
            }

            Log::warning('Feedback not found for marking as read', [
                'feedback_id' => $feedbackId,
                'user_id' => Auth::id()
            ]);

            return response()->json(['success' => false, 'message' => 'Feedback not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error marking feedback as read', [
                'error' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'feedback_id' => $feedbackId
            ]);
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }
}
