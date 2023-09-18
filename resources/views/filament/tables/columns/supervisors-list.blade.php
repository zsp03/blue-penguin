<div class="fi-ta-image px-3 py-4">
    <div class="flex items-center gap-x-2.5">
        <div class="flex gap-1">
            @foreach($getState() as $supervisor)
                <div x-data x-tooltip.raw="{{ $supervisor->name }}" class="relative transition duration-300 ease-in-out hover:scale-150 hover:z-50">
                    <img class=" w-10 h-10 max-w-none object-cover object-center rounded-full" src="@if($supervisor->image !== null) {{ $supervisor->image_url }} @else {{ $getDefaultAvatar() }} @endif" alt="">
                    <div class="bottom-0 top-7 left-7 flex items-center justify-center absolute w-4 h-4 @if($supervisor->pivot->role == 'supervisor 1') bg-info-500 dark:bg-blue-400 @else bg-green-500 dark:bg-green-400 @endif ring-1 ring-white/10 dark:ring-gray-800/10 rounded-full text-xs font-medium text-white dark:text-white">
                        @if($supervisor->pivot->role == 'supervisor 1')
                            1
                        @else
                            2
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
