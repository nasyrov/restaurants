<div {{ $attributes->merge(['class' => 'flex flex-col'])->only(['class', 'wire:loading.class']) }}>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        {{ $head }}
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                    {{ $slot }}
                    </tbody>
                </table>

                @isset($pagination)
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $pagination }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
