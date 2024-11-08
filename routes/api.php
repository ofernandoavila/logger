<?php

use App\Core\Core;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Models\Organization;
use Illuminate\Support\Facades\Route;

Route::get('/health', function (
    Core $core
) {
    return response([
        'app_name' => $core->get_app_name(),
        'app_version' => $core->get_app_version(),
        'app_status' => $core->get_app_status(),
        'app_debug' => $core->get_app_debug()
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
    
    Route::group(['prefix' => 'application'], function() {
        Route::get('/', [ ApplicationController::class, 'find' ]);

        Route::post('/create', [ ApplicationController::class, 'create' ]);
        Route::post('/update', [ ApplicationController::class, 'update' ]);
        Route::delete('/delete', [ ApplicationController::class, 'delete' ]);
        
        Route::group([ 'prefix' => 'group' ], function() {
            Route::get('/', [ ApplicationController::class, 'find_group' ]);

            Route::post('/create', [ ApplicationController::class, 'create_group' ]);
            Route::post('/update', [ ApplicationController::class, 'update_group' ]);
            Route::delete('/delete', [ ApplicationController::class, 'delete_group' ]);

            Route::post('/add', [ ApplicationController::class, 'add_application_group' ]);
            Route::post('/remove', [ ApplicationController::class, 'remove_application_group' ]);
        });
    });
});