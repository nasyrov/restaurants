<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class Restaurants extends Component
{
    public function render(): ViewContract
    {
        return View::make('livewire.restaurants');
    }
}
