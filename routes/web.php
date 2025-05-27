<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NinjaController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProductivityInsightController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/content', [ContentController::class, 'index'])->name('content')->middleware('auth');

Route::get('/status', [StatusController::class, 'index'])->name('status')->middleware('auth');

Route::get('/category', [CategoryController::class, 'index'])->name('category')->middleware('auth');

// Feedback Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::post('/feedback/{feedbackId}/reply', [FeedbackController::class, 'reply'])->name('feedback.reply');
    Route::post('/feedback/mark-as-read/{feedbackId}', [FeedbackController::class, 'markAsRead'])->name('feedback.mark-as-read');
});

Route::get('/productivity-insight', [ProductivityInsightController::class, 'index'])->name('productivity-insight')->middleware('auth');

Route::get('/setting', [SettingController::class, 'index'])->name('setting')->middleware('auth');
Route::post('/setting', [SettingController::class, 'update'])->name('setting.update')->middleware('auth');

// Admin Settings Routes
Route::get('/admin-setting', [AdminSettingController::class, 'index'])->name('AdminSetting')->middleware('auth');
Route::post('/admin-setting', [AdminSettingController::class, 'update'])->name('admin.setting.update')->middleware('auth');

//THIS PART IS THE ROUTES FOR THE ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/user-manage', [UserManageController::class, 'index'])->name('user-manage');
    Route::get('/user/{id}', [UserManageController::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserManageController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserManageController::class, 'destroy'])->name('user.destroy');
    Route::get('/send-announcement', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('send-announcement');
    Route::post('/send-announcement', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/{id}', [App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcement.show');
    Route::get('/read-feedback', [FeedbackController::class, 'adminIndex'])->name('read-feedback');
    Route::get('/api/dashboard-stats', [UserManageController::class, 'getDashboardStats'])->name('dashboard.stats');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




//THIS PART IS FOR THE LOGIN, REGISTER, AND WELCOME PAGE
Route::middleware('guest')->controller(AuthController::class)->group(function (){
    Route::get('/register', 'showRegister')->name('show.register');
    Route::get('/login', 'showLogin')->name('show.login');
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::middleware('auth')->controller(NinjaController::class)->group(function (){
    Route::get('/ninjas',  'index')->name('ninjas.index');
    Route::get('/ninjas/create',  'create')->name('ninjas.create');
    Route::get('/ninjas/{ninja}',  'show')->name('ninjas.show');
    Route::post('/ninjas',  'store')->name('ninjas.store');
    Route::delete('/ninjas/{ninja}',  'destroy')->name('ninjas.destroy');
});

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete')->middleware('auth');

// Notification-related route
Route::post('/notifications/mark-as-read/{task}', [TaskController::class, 'markAsRead'])->name('notifications.markAsRead');

// Announcement Routes
Route::get('/announcement/{id}', [App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcement.show')->middleware('auth');

// Notification API Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/api/notification-status', function () {
        $user = Auth::user();
        $reference = \App\Models\Reference::where('user_id', $user->id)->first();
        $settings = $reference ? \App\Models\Setting::find($reference->settings_id) : null;
        return response()->json([
            'enabled' => $settings ? $settings->notification : true
        ]);
    });

    Route::get('/api/notifications', function () {
        $user = Auth::user();
        $reference = \App\Models\Reference::where('user_id', $user->id)->first();
        $settings = $reference ? \App\Models\Setting::find($reference->settings_id) : null;

        if (!$settings || !$settings->notification) {
            return response()->json(['notifications' => []]);
        }

        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'message' => $notification->message,
                    'status' => $notification->status,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            });

        return response()->json(['notifications' => $notifications]);
    });
});

