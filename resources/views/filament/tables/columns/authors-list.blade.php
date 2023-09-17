<div class="fi-ta-image px-3 py-4">
    <div class="flex items-center gap-x-2.5">
        <div class="flex -space-x-2">
        @foreach($getState() as $author)
            <img x-data x-tooltip.raw="{{ $author->name }}"
                 src="@if($author->image !== null) {{ $getImageUrl($author->image) }} @else {{ $getDefaultAvatar() }} @endif"
                 style="height: 2rem; width: 2rem;"
                 class="max-w-none object-cover object-center rounded-full bg-white ring-white dark:ring-gray-900 ring-2"
            >
        @endforeach
        </div>
    </div>
</div>
