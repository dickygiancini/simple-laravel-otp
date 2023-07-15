<?php

use App\Http\Controllers\UserVerificationController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'login');

Route::get('/test-get', function() {
    return response()->json(['message' => 'Route GET looks fine']);
});

Route::post('/test-post', function() {
    return response()->json(['message' => 'Route POST looks fine']);
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/verification', [UserVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/resend', [UserVerificationController::class, 'resend'])->name('verification.resend');
    Route::post('/verify', [UserVerificationController::class, 'verify'])->name('verification.verify');

    Route::middleware('verified')->group(function () {

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::view('about', 'about')->name('about');

        Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    });
    // Route::view('about', 'about')->name('about');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    // Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
