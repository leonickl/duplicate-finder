<?php

use App\Controllers\MainController;
use PXP\Core\Lib\Route;

Route::get('/')->do(MainController::class, 'main');

Route::get('/all')->do(MainController::class, 'all');
Route::get('/panes')->do(MainController::class, 'panes');

Route::post('/scan')->do(MainController::class, 'scan');
Route::post('/remove-file/{id}')->do(MainController::class, 'removeFile');
Route::post('/remove-folder/{path}')->do(MainController::class, 'removeFolder');

Route::get('/image')->do(MainController::class, 'image');
