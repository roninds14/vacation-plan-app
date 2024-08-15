<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolidayController;

$PATH_WITH_ID = '/holiday/{id}';

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/holiday', [HolidayController::class, 'index']);

Route::get($PATH_WITH_ID, [HolidayController::class, 'show']);

Route::post('/holiday', [HolidayController::class, 'store']);

Route::put($PATH_WITH_ID, [HolidayController::class, 'update']);

Route::delete($PATH_WITH_ID, [HolidayController::class, 'destroy']);

Route::post('/holiday/pdf', [HolidayController::class, 'exportPdf']);
