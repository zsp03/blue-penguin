<div class="p-4 flex flex-col gap-1.5">
    @if($getState() !== null)
        @foreach($getState() as $author)
            <div class="text-sm">
                {{ \App\Models\User::find($author)->name }}
            </div>
        @endforeach
    @else
    <div>

    </div>
    @endif
</div>
