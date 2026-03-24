<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
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
    Route::delete('/delete-visitor/{id}', [ServiceController::class, 'delete_visitor_entrance'])->name('visitor.destroy');
    Route::get('/get-visitor-members/{id}', [VisitorController::class, 'getVisitorMembers']);

    // StaffController routes
    Route::get('/staff', [StaffController::class, 'index'])->name('staff');
    Route::post('/add-staff', [StaffController::class, 'store'])->name('staff.store');
    Route::post('/update-staff', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/delete-staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    // ServiceController routes
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::post('/add-service', [ServiceController::class, 'add_service'])->name('service.store');
    Route::put('/update-service/{id}', [ServiceController::class,'update_service'])->name('service.update');
    Route::delete('/delete-service/{id}', [ServiceController::class, 'delete_service'])->name('service.destroy');
    // entrances
    Route::get('/availed-services', [ServiceController::class, 'availed_services'])->name('availed.services');
    Route::get('/entrances', [ServiceController::class, 'entrances'])->name('entrances');
    Route::post('/add-entrance', [ServiceController::class, 'create_entrance_bill'])->name('entrance.store');
    Route::put('/entrance/update', [ServiceController::class, 'update_entrance_bill'])->name('entrance.update');
    Route::delete('/delete-entrance/{id}', [ServiceController::class, 'destroyEntrance'])->name('entrance.destroy');
    // accommodations
    Route::get('/accommodations', [ServiceController::class, 'accommodations'])->name('accommodations');
    Route::post('/accommodation', [ServiceController::class, 'storeAccommodationFunctionHall'])->name('accommodation.store');
    Route::put('/accommodation/update', [ServiceController::class, 'updateAccommodation'])->name('accommodation.update');
    Route::delete('/delete-accommodation/{id}', [ServiceController::class, 'destroyAccommodation'])->name('accommodation.destroy');
    // function halls
    Route::get('/function-halls', [ServiceController::class, 'functionhalls'])->name('functionhalls');
    Route::put('/function-halls/update', [ServiceController::class, 'updateFunctionHall'])->name('functionhall.update');
    Route::delete('/delete-function-hall/{id}', [ServiceController::class, 'destroyFunctionHall'])->name('functionhall.destroy');
    // cottages
    Route::get('/cottages', [ServiceController::class, 'cottages'])->name('cottages');
    Route::post('/cottage', [ServiceController::class, 'storeCottage'])->name('cottage.store');
    Route::put('/cottage/update', [ServiceController::class, 'updateCottage'])->name('cottage.update');
    Route::delete('/delete-cottage/{id}', [ServiceController::class, 'destroyCottage'])->name('cottage.destroy');
    // meals
    Route::get('/meals', [ServiceController::class, 'meals'])->name('meals');
    Route::post('/meal', [ServiceController::class, 'storeMeal'])->name('meal.store');
    Route::put('/meal/update', [ServiceController::class, 'updateMeal'])->name('meal.update');
    Route::delete('/delete-meal/{id}', [ServiceController::class, 'destroyMeal'])->name('meal.destroy');
    // Beverages
    Route::get('/beverages', [ServiceController::class, 'beverages'])->name('beverages');
    Route::post('/beverage', [ServiceController::class, 'storeBeverage'])->name('beverage.store');
    Route::put('/beverage/update', [ServiceController::class, 'updateBeverage'])->name('beverage.update');
    Route::delete('/delete-beverage/{id}', [ServiceController::class, 'destroyBeverage'])->name('beverage.destroy');

    // BillController routes
    Route::get('/bills', [BillController::class, 'index'])->name('bill');

    // ReportController routes
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/daily-report', [ReportController::class, 'dailyReport'])->name('daily.report');
    Route::get('/weekly-report', [ReportController::class, 'weeklyReport'])->name('weekly.report');
    Route::get('/monthly-report', [ReportController::class, 'monthlyReport'])->name('monthly.report');
    Route::get('/yearly-report', [ReportController::class, 'yearlyReport'])->name('yearly.report');
});
