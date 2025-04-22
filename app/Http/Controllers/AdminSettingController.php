<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reference = Reference::where('user_id', $user->id)->first();
        $settings = null;

        if ($reference) {
            $settings = Setting::find($reference->settings_id);
        } else {
            // Create default settings if none exist
            $settings = new Setting();
            $settings->theme = 'light';
            $settings->notification = true;
            $settings->save();

            // Create reference
            $reference = new Reference();
            $reference->user_id = $user->id;
            $reference->settings_id = $settings->id;
            $reference->save();
        }

        return view('Admin_view.AdminSetting', compact('settings'));
    }

    public function update(Request $request)
    {
        // Add debugging
        Log::info('AdminSettingController@update called', $request->all());

        $user = Auth::user();
        $reference = Reference::where('user_id', $user->id)->first();

        if (!$reference) {
            return redirect()->back()->with('error', 'Settings not found');
        }

        $settings = Setting::find($reference->settings_id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'change_email' => 'nullable|email|unique:users,email,' . $user->id,
            'change_password' => 'nullable|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'theme' => 'nullable|in:light,dark',
            'notification' => 'nullable|in:0,1'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user data if email or password is provided
        if ($request->filled('change_email')) {
            User::where('id', $user->id)->update(['email' => $request->change_email]);
        }

        if ($request->filled('change_password')) {
            // Get the user model directly to avoid double hashing
            $userModel = User::find($user->id);
            $userModel->password = $request->change_password; // The model will hash this automatically
            $userModel->save();

            // Log the password change
            Log::info('Password changed for admin: ' . $user->id);
        }

        // Update settings
        if ($request->has('change_email')) {
            $settings->change_email = $request->change_email;
        }

        if ($request->has('change_password')) {
            $settings->change_password = $request->change_password;
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_pictures'), $filename);
            $settings->profile_picture = $filename;
        }

        if ($request->has('theme')) {
            $settings->theme = $request->theme;
        }

        if ($request->has('notification')) {
            $settings->notification = $request->notification == '1';
        }

        $settings->save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
