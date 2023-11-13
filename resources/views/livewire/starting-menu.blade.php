<div class="dark:bg-gray-800 flex flex-col items-center justify-center h-screen">
    <div class="flex flex-col items-center sm:my-2 md:my-4 lg:my-8">
        <span
            class="font-bold text-lg text-center text-gray-400 dark:text-gray-200 break-words panel-switch-card-title"
        >
                Panel Switch
        </span>
    </div>
    <div class="flex flex-col flex-grow sm:flex-row items-center justify-center gap-4 md:gap-6 w-full">
        @foreach ($panels as $panel)
            <a href="{{'/' . $panel->getPath()}}"
               class="flex flex-col items-center justify-center hover:cursor-pointer group panel-switch-card" >
                <div
                    @class([
                                "p-2 bg-white rounded-lg shadow-md dark:bg-gray-600 panel-switch-card-section group-hover:ring-2 group-hover:ring-primary-600"
                            ])>
                    @php
                        $iconName = $icons[$panel->getId()] ?? 'heroicon-s-square-2-stack' ;
                    @endphp
                    @svg($iconName, 'text-gray-600 dark:text-white panel-switch-card-icon', ['style' => 'width: ' . (32 * 4) . 'px; height: ' . (32 * 4). 'px;'])
                </div>
                <span
                    class="mt-2 text-sm font-medium text-center text-gray-400 dark:text-gray-200 break-words panel-switch-card-title group-hover:text-primary-600 group-hover:dark:text-primary-400"
                >
                {{ $labels[$panel->getId()] ?? str($panel->getId())->ucfirst()}}
            </span>
            </a>

        @endforeach
    </div>
</div>
