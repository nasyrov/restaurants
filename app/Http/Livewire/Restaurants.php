<?php

namespace App\Http\Livewire;

use App\Models\QueryBuilders\ScheduleQueryBuilder;
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
                ->whereHas(
                    'schedules',
                    fn(ScheduleQueryBuilder $query) => $query
                        ->currentWeekday()
                        ->withinWorkingHours()
                )
                ->paginate(),
        ]);
    }
}
