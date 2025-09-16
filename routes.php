<?php

use App\Controllers\MainController;
use PXP\Core\Lib\Route;

Route::get('/pairs')->do(MainController::class, 'pairs');
Route::get('/image')->do(MainController::class, 'image');
