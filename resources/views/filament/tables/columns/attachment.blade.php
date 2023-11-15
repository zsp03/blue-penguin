<div class="px-3 py-4">
    <div class="flex items-center justify-center">
        <div class="flex">
            @if(empty($getState()))

            @else
                <x-filament::link icon="heroicon-o-document-arrow-down" color="gray" href="{{ Storage::disk()->url($getState()) }}">

                </x-filament::link>
            @endif

        </div>
    </div>
</div>

