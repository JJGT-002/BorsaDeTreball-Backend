<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CycleController;
use App\Http\Controllers\Api\JobOfferController;
use App\Http\Controllers\Api\OfferCycleController;
use App\Http\Controllers\Api\ProfessionalFamilyController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\StudentCycleController;
use App\Http\Controllers\Api\StudentEnrolledOfferController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('professionalFamilies', ProfessionalFamilyController::class);
Route::apiResource('cycles', CycleController::class);
Route::apiResource('users',UserController::class);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('jobOffers', JobOfferController::class);
Route::apiResource('offerCycles', OfferCycleController::class);
Route::apiResource('studentEnrolledOffers', StudentEnrolledOfferController::class);
Route::apiResource('studentCycles', StudentCycleController::class);
