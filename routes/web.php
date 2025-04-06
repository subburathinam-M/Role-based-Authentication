<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\MicrosoftAuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auth login/logout
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Microsoft OAuth routes using controller
Route::get('/auth/microsoft', [MicrosoftAuthController::class, 'redirectToMicrosoft']);
Route::get('/auth/microsoft/callback', [MicrosoftAuthController::class, 'handleMicrosoftCallback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/super-admin', function () {
        return view('superAdmin.dashboard');
    })->middleware('role:superAdmin')->name('superAdmin.dashboard');

    Route::get('/dept-head', function () {
        return view('deptHead.dashboard');
    })->middleware('role:deptHead')->name('deptHead.dashboard');

    Route::get('/user', function () {
        return view('user.dashboard');
    })->middleware('role:user')->name('user.dashboard');
});


