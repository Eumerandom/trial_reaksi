<div class="min-h-screen py-12 bg-gray-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                <div class="flex items-center gap-4 text-gray-600">
                    <div class="flex items-center gap-2">
                        <flux:icon.user class="size-4"/>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon.calendar class="size-4"/>
                        <span>{{ $post->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            @if($post->thumbnail)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-[400px] object-cover rounded-lg">
                </div>
            @endif

            <div class="mx-auto">
                <article class="prose prose-lg max-w-none">
                    {!! $htmlContent !!}
                </article>
            </div>
        </div>
    </div>
</div>
