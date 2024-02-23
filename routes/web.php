<?php

use App\Http\Controllers\Api\CycleController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\StudentCycleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\OfferCycleController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('activate/user/{id}', [UserController::class, 'activarUsuario'])->name('activate.user');
Route::resource('companies', CompanyController::class);
Route::resource('users', \App\Http\Controllers\UserController::class);
Route::resource('jobOffers', JobOfferController::class);
Route::resource('offerCycles', OfferCycleController::class);

Route::get('jobOffers/indexByCompany/{id}', [JobOfferController::class, 'indexByCompany'])->name('jobOffers.indexByCompany');
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.callback');

Route::get('/responsibles', [StudentCycleController::class, 'getResponsibles'])->name('responsible.students');
Route::get('/responsible/students/{responsibleId}', [StudentCycleController::class, 'getStudentsByResponsibleCycleId'])->name('responsible.students');

Route::get('/cycles', [CycleController::class, 'getCyclesByResponsibleUserId'])->name('responsible.students');


require __DIR__.'/auth.php';
