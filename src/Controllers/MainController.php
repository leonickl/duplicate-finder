<?php

namespace App\Controllers;

use PXP\Core\Lib\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }
}
