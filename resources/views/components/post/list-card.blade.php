<div class="flex items-center gap-4 p-4 rounded-md shadow-md">
    <a href="{{ route('berita.show', $post->slug) }}">
        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover rounded-md">
    </a>
    <div>
        <a href="{{ route('berita.show', $post->slug) }}">
            <h3 class="text-lg font-medium text-gray-900">{{ $post->title }}</h3>
        </a>
        <p class="text-sm text-gray-500">{{ $post->excerpt }}</p>
    </div>
</div>
