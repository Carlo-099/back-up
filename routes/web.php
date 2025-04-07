<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NinjaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/content', [ContentController::class, 'index'])->name('content')->middleware('auth');

Route::get('/status', function () {
    return view('User_view.Status');
})->name('status')->middleware('auth');

Route::get('/category', function () {
    return view('User_view.Category');
})->name('category')->middleware('auth');

Route::get('/feedback', function () {
    return view('User_view.Feedback');
})->name('feedback')->middleware('auth');

Route::get('/productivity-insight', function () {
    return view('User_view.Productivity_insight');
})->name('productivity-insight')->middleware('auth');

Route::get('/setting', function(){
    return view('User_view/setting');
})->name('setting') ->middleware('auth');



//THIS PART IS THE ROUTES FOR THE ADMIN
Route::get('/user-manage', function () {
    return view('Admin_view.UserManage');
})->name('user-manage')->middleware('auth');

Route::get('/send-announcement', function () {
    return view('Admin_view.SendAnnouncement');
})->name('send-announcement')->middleware('auth');

Route::get('/read-feedback', function () {
    return view('Admin_view.ReadFeedback');
})->name('read-feedback')->middleware('auth');

Route::get('/AdminSetting', function(){
    return view('Admin_view.AdminSetting');
})->name('AdminSetting') ->middleware('auth');

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

