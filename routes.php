<?php

use App\Controllers\MainController;
use PXP\Core\Lib\Route;

Route::get('/all')->do(MainController::class, 'all');
Route::get('/panes')->do(MainController::class, 'panes');

Route::post('/scan')->do(MainController::class, 'scan');
Route::post('/remove/{id}')->do(MainController::class, 'removeFile');

Route::get('/image')->do(MainController::class, 'image');
