<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;

class HomeController
{
    public function __invoke(): ViewContract
    {
        return View::make('home');
    }
}
