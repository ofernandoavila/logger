<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Models\Organization;
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

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/auth/get_info', [ AuthController::class, 'me' ]);

    Route::group(['prefix' => 'organization'], function() {
        Route::get('/', [ OrganizationController::class, 'find' ]);
        
        Route::post('/create', [ OrganizationController::class, 'create' ]);
        Route::post('/update', [ OrganizationController::class, 'update' ]);
        Route::delete('/delete', [ OrganizationController::class, 'delete' ]);
        
        Route::group([ 'prefix' => 'user' ], function() {
            Route::post('/add', [ OrganizationController::class, 'add_user' ]);
            Route::post('/remove', [ OrganizationController::class, 'remove_user' ]);
            Route::post('/alter-role', [ OrganizationController::class, 'alter_user_role' ]);
        });
    });
});