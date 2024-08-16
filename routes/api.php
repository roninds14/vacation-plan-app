<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\Authentication;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/holiday', [HolidayController::class, 'index']);

// Route::get($PATH_WITH_ID, [HolidayController::class, 'show']);

// Route::post('/holiday', [HolidayController::class, 'store']);

// Route::put($PATH_WITH_ID, [HolidayController::class, 'update']);

// Route::delete($PATH_WITH_ID, [HolidayController::class, 'destroy']);

// Route::post('/holiday/pdf', [HolidayController::class, 'exportPdf']);

Route::post("/login", [Authentication::class, 'login']);
Route::post("/register", [Authentication::class, 'register']);

Route::group(
	[
		"middleware" => ['auth:api']
	],
	function () {
		$pathWithId = '/holiday/{id}';

		Route::get('/holiday', [HolidayController::class, 'index']);

		Route::get($pathWithId, [HolidayController::class, 'show']);

		Route::post('/holiday', [HolidayController::class, 'store']);

		Route::put($pathWithId, [HolidayController::class, 'update']);

		Route::delete($pathWithId, [HolidayController::class, 'destroy']);

		Route::post('/holiday/pdf', [HolidayController::class, 'exportPdf']);
	}
);
