<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\VisitorController;

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

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // AuthController routes
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // VisitorController routes
    Route::get('/log-book', [VisitorController::class, 'index'])->name('logbook');
    Route::post('/add-visitor', [VisitorController::class, 'store'])->name('visitor.store');
    Route::put('/update-visitor', [VisitorController::class, 'update'])->name('visitor.update');
    Route::delete('/delete-visitor/{id}', [VisitorController::class, 'destroy'])->name('visitor.destroy');

    // StaffController routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/add-staff', [StaffController::class, 'store'])->name('staff.store');
    Route::post('/update-staff', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/delete-staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
});
