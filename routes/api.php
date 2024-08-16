<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolidayController;

Route::post("/login", [AuthController::class, 'login']);
Route::post("/register", [AuthController::class, 'register']);

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
