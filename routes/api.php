<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(
 *     title="Job Portal API",
 *     version="1.0.0",
 *     description="API для управління вакансіями"
 * )
 */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('vacancies', VacancyController::class);
});

Route::get('/vacancies', [VacancyController::class, 'index']);
