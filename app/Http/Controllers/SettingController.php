<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
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

        return view('User_view.setting', compact('settings'));
    }

    public function update(Request $request)
    {
        // Add debugging
        \Illuminate\Support\Facades\Log::info('SettingController@update called', $request->all());

        $user = Auth::user();
        $reference = Reference::where('user_id', $user->id)->first();

        if (!$reference) {
            return redirect()->back()->with('error', 'Settings not found');
        }

        $settings = Setting::find($reference->settings_id);
        if (!$settings) {
            return redirect()->back()->with('error', 'Settings not found');
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'change_email' => 'nullable|email|unique:users,email,' . $user->id,
            'current_password' => 'required_with:change_password',
            'change_password' => 'nullable|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'theme' => 'nullable|in:light,dark',
            'notification' => 'required|in:0,1',
            'age' => 'nullable|integer|min:13',
            'gender' => 'nullable|in:male,female',
            'educational_level' => 'nullable|in:elementary,high school,senior high,college',
        ]);

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::error('Validation failed', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update settings
        try {
            // Update notification setting
            $settings->notification = $request->notification === '1';
            \Illuminate\Support\Facades\Log::info('Updating notification setting', [
                'old_value' => $settings->getOriginal('notification'),
                'new_value' => $settings->notification,
                'request_value' => $request->notification
            ]);

            // Update other settings if provided
            if ($request->has('theme')) {
                $settings->theme = $request->theme;
            }

            if ($request->filled('change_email')) {
                $settings->change_email = $request->change_email;
                User::where('id', $user->id)->update(['email' => $request->change_email]);
            }

            if ($request->filled('change_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()
                        ->withErrors(['current_password' => 'The current password is incorrect.'])
                        ->withInput();
                }
                $userModel = User::find($user->id);
                $userModel->password = $request->change_password;
                $userModel->save();
                $settings->change_password = $request->change_password;
            }

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profile_pictures'), $filename);
                $settings->profile_picture = 'uploads/profile_pictures/' . $filename;
            }

            // Update user profile fields
            $user->age = $request->input('age', $user->age);
            $user->gender = $request->input('gender', $user->gender);
            $user->educational_level = $request->input('educational_level', $user->educational_level);
            $user->save();

            // Save all settings
            $settings->save();

            \Illuminate\Support\Facades\Log::info('Settings updated successfully', [
                'user_id' => $user->id,
                'settings_id' => $settings->id,
                'notification' => $settings->notification
            ]);

            return redirect()->back()->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating settings', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            return redirect()->back()->with('error', 'Error updating settings. Please try again.');
        }
    }
}
