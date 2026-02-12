<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\TaskController;
use Illuminate\Support\Facades\Route;

// Welcome Seite
Route::get('/', function () {
    return view('welcome');
});

// Guest Login - direkt zum Dashboard
Route::get('/guest-login', function () {
    return redirect('/dashboard');
})->name('guest.login');

// Dashboard und andere Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('projects', ProjectController::class);
Route::resource('tasks', TaskController::class);