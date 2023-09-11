<div class="p-4 flex flex-col gap-1.5">
     @foreach($getState() as $supervisor)
        <img src="{{ $getImageUrl($supervisor->image) }}" class="" alt="{{ $supervisor->name }}">
     @endforeach
</div>
