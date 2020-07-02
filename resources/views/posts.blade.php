
<div class="grid grid-cols-2 gap-12">
    @foreach ($posts as $post)
        <div class="">
            <h1 class="text-gray-900 mb-2 text-2xl truncate">{{ $post->title }}</h1>
            <div class="border rounded h-32">
                <img src="{{ $post->cover_url }}" alt="" class="w-full h-full">
            </div>
            <p class="p-4">{{ $post->body }}</p>
        </div>
    @endforeach
</div>
