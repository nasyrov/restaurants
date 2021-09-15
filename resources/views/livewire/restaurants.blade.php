<div>
    <x-table wire:loading.class="opacity-75 cursor-wait">
        <x-slot name="head">
            <x-table.th>
                {{ __('Restaurant') }}
            </x-table.th>

            <x-table.th class="w-px">
                {{ __('Status') }}
            </x-table.th>
        </x-slot>

        @forelse($restaurants as $restaurant)
            <x-table.tr wire:key="restaurant-{{ $restaurant->id }}">
                <x-table.td>
                    <span class="text-sm font-medium text-gray-900">
                        {{ $restaurant->name }}
                    </span>
                </x-table.td>

                <x-table.td>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $restaurant->status_color }}-100 text-{{ $restaurant->status_color }}-800">
                        {{ __($restaurant->status) }}
                    </span>
                </x-table.td>
            </x-table.tr>
        @empty
            <x-table.tr>
                <x-table.td colspan="2">
                    {{ __('Can’t find any matching results.') }}
                </x-table.td>
            </x-table.tr>
        @endforelse

        <x-slot name="pagination">
            {{ $restaurants->links() }}
        </x-slot>
    </x-table>
</div>
