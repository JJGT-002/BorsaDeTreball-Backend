<?php

use App\Http\Controllers\Api\CycleController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\OfferCycleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\StudentController;
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
Route::resource('jobOffers', JobOfferController::class);
Route::resource('offerCycles', OfferCycleController::class);
Route::resource('responsibles', ResponsibleController::class);
Route::resource('users', \App\Http\Controllers\UserController::class);
Route::resource('cycles', \App\Http\Controllers\CycleController::class);
Route::resource('students', StudentController::class);

Route::get('jobOffers/indexByCompany/{id}', [JobOfferController::class, 'indexByCompany'])->name('jobOffers.indexByCompany');
Route::get('responsibles/indexCyclesByResponsible/{id}', [ResponsibleController::class, 'getCyclesByResponsibleUserId'])->name('responsibles.indexCyclesByResponsible');
Route::get('responsibles/indexCyclesWithoutResponsible/{id}', [ResponsibleController::class, 'getCyclesWithoutResponsible'])->name('responsibles.indexCyclesWithoutResponsible');
Route::get('responsibles/assignResponsibleWithCycle/{responsibleId}/{cycleId}', [ResponsibleController::class, 'assignResponsibleWithCycle'])->name('responsibles.assignResponsibleWithCycle');
Route::get('responsibles/delete/{responsibleId}/{cycleId}', [ResponsibleController::class, 'delete'])->name('responsibles.delete');
Route::get('cycles/responsible/{responsibleId}', [ResponsibleController::class, 'showCyclesOfAResponsible'])->name('responsible.cycles');
Route::get('students/indexJobOffersByCycle/{cycleId}', [StudentController::class, 'indexJobOffersByCycle'])->name('cycles.indexJobOffersByCycle');
Route::get('students/indexStudentsByCycleId/{cycleId}', [StudentController::class, 'indexStudentsByCycleId'])->name('students.indexStudentsByCycleId');
Route::delete('students/{student}/{cycleId}', [StudentController::class, 'destroy'])->name('students.destroy');
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.callback');

require __DIR__.'/auth.php';
