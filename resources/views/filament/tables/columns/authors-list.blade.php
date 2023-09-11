<div class="p-4 flex flex-col gap-1.5">
    <div class="flex mb-5 -space-x-4">
        @foreach($getState() as $author)
            <img x-data x-tooltip.raw="{{ $author->name }}" class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800" src="{{ $getImageUrl($author->image) }}" alt="">
        @endforeach
    </div>
</div>
