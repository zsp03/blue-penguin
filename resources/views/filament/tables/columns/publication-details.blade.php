<div class="fi-ta-text grid gap-y-2 px-3 py-4">
    <div class="whitespace-normal">
        <div class="flex max-w-max">
            <div class="fi-ta-text-item inline-flex items-center gap-1.5">
                <div class="flex gap-1.5">
                    @if(!empty($getRecord()->type))
                        <x-filament::badge
                            color="{{ $getRecord()->type->getColor() }}"
                        >
                            {{ $getRecord()->type->getLabel() }}
                        </x-filament::badge>
                    @endif
                    @if(!empty($getRecord()->scale))
                        <x-filament::badge
                            color="{{ $getRecord()->scale->getColor() }}"
                            icon="{{ $getRecord()->scale->getIcon() }}"
                        >
                            {{ $getRecord()->scale->getLabel() }}
                        </x-filament::badge>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <p class="text-sm text-gray-500 dark:text-gray-400 whitespace-normal">
        <span class="text-gray-950 dark:text-white text-sm">
            {{ $getState() }}
        </span>
        <span class="text-sm text-gray-500 dark:text-gray-400 whitespace-normal">
           | {{ $getRecord()->year }}
        </span>
    </p>

</div>
