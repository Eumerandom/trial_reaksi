<div class="rounded-lg overflow-hidden bg-white shadow-lg">
    <a href="{{ route('berita.show', $post->slug) }}">
        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
        <div class="p-4">
            <h3 class="text-lg font-medium text-gray-900">{{ $post->title }}</h3>
            <p class="text-sm text-gray-500">{{ $post->excerpt }}</p>
        </div>
    </a>
</div>
