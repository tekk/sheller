<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExecutionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetupController;

Route::get('/', function () {
    // Show public aliases on welcome page
    $aliases = \App\Models\Alias::where('visibility', 'public')->latest()->get();
    return view('welcome', compact('aliases'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
});

Route::get('/auth/redirect', [AuthController::class, 'login'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'callback']);
Route::post('/auth/confirm', [AuthController::class, 'confirm']);

// Installation Routes
Route::prefix('install')->group(function () {
    Route::get('/', [App\Http\Controllers\InstallerController::class, 'welcome'])->name('install.welcome');
    Route::get('/database', [App\Http\Controllers\InstallerController::class, 'databaseForm'])->name('install.database');
    Route::get('/supabase', [App\Http\Controllers\InstallerController::class, 'supabaseForm'])->name('install.supabase');
    Route::post('/process', [App\Http\Controllers\InstallerController::class, 'process'])->name('install.process');
    Route::get('/finish', [App\Http\Controllers\InstallerController::class, 'finish'])->name('install.finish');
});

// Setup route for shared hosting
Route::get('/system/setup', SetupController::class);

// Execution route - Must be last to avoid conflicts
Route::get('/{slug}', [ExecutionController::class, 'invoke'])->name('exec');
