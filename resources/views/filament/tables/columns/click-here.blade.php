<div class="px-3 py-4">
    <div class="flex items-center justify-center">
        <div class="flex">
            @if(!empty($getState()))
                <x-filament::link icon="heroicon-o-link" color="gray" href="{{ $getState() }}"/>
            @endif
        </div>
    </div>
</div>

