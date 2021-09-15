<?php

namespace App\Http\Livewire;

use App\Models\QueryBuilders\RestaurantQueryBuilder;
use App\Models\Restaurant;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithPagination;

class Restaurants extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search'];

    public function render(): ViewContract
    {
        return View::make('livewire.restaurants', [
            'restaurants' => Restaurant::query()
                ->withCurrentWeekdaySchedule()
                ->when(
                    $this->search,
                    fn(RestaurantQueryBuilder $query, string $search) => $query->search($search),
                    fn(RestaurantQueryBuilder $query) => $query->currentlyOpened()
                )
                ->paginate(),
        ]);
    }
}
