<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response([
        'app_status' => 'Running',
        'app_name' => 'PHP Logger',
        'app_version' => '1.0.0'
    ]);
});

Route::post('/auth/create-account', [ AuthController::class, 'create_account' ]);
Route::post('/auth/login', [ AuthController::class, 'login' ]);
Route::post('/auth/login', [ AuthController::class, 'login' ]);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/auth/get_info', [ AuthController::class, 'me' ]);
});