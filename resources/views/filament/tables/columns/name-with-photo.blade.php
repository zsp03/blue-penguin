<div class="grid gap-y-1 px-3 py-4">
    <div class="">
        <div class="flex gap-2 max-w-max">
            <x-filament::avatar class="max-w-none object-cover object-center rounded-full bg-white ring-white dark:ring-gray-900 ring-2"
                                src="{{ $getState()->image_url ?: $getDefaultAvatar() }}"
            />
            <div class="fi-ta-text-item inline-flex items-center gap-1.5 text-sm text-gray-950 dark:text-white  " style="">
                <div>
                    {{ $getState()->name }}
                </div>
            </div>
        </div>
    </div>
</div>
