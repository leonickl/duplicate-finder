<?php

use App\Controllers\MainController;
use PXP\Core\Lib\Route;

Route::get('/')->do(MainController::class, 'index');
