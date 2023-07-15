<?php

use App\Http\Controllers\Privileged\UserPriviledgeController;
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

        Route::middleware('privilege')->group(function() {
            Route::get('/add-access', [UserPriviledgeController::class, 'index'])->name('privileged.users.index');

            Route::get('/add-access/checkRoles', [UserPriviledgeController::class, 'checkRoles'])->name('privileged.users.checkRoles');
            Route::post('/add-access/update', [UserPriviledgeController::class, 'update'])->name('privileged.users.update');

            Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index')->routeTitle('Users List Page');

            Route::get('/mst-status', [\App\Http\Controllers\Masters\MasterStatusController::class, 'index'])->name('privileged.master.status.index')->routeTitle('Master Status Page');
            Route::post('/mst-status/create', [\App\Http\Controllers\Masters\MasterStatusController::class, 'create'])->name('privileged.master.status.create');
        });

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->routeTitle('Dashboard Page');
        Route::get('/request-budget', [App\Http\Controllers\RequestBudgetController::class, 'index'])->name('request.budget.index')->routeTitle('Request Budget Page');
        Route::post('/request-budget/create', [App\Http\Controllers\RequestBudgetController::class, 'create'])->name('request.budget.create')->routeTitle('Request Budget Page');
        // Route::view('about', 'about')->name('about')->routeTitle('About Page');

        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show')->routeTitle('User Profile Page');
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->routeTitle('Update User Profile');
    });
    // Route::view('about', 'about')->name('about');

    // Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    // Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    // Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
