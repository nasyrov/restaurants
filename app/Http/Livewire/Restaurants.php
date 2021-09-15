<?php

namespace App\Http\Livewire;

use App\Models\Restaurant;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithPagination;

class Restaurants extends Component
{
    use WithPagination;

    public function render(): ViewContract
    {
        return View::make('livewire.restaurants', [
            'restaurants' => Restaurant::query()
                ->paginate(),
        ]);
    }
}
