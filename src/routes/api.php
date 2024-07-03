<?php

use Illuminate\Support\Facades\Route;
use Riobet\AccessKey\App\Http\Controllers\AccessKeyController;

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

Route::prefix('api/accesskey')
    ->middleware(['accesskey_exception'])
    ->group(function () {
        Route::post('list', [AccessKeyController::class, 'list']);
        Route::post('create', [AccessKeyController::class, 'create']);
        Route::post('update', [AccessKeyController::class, 'update']);
    });
