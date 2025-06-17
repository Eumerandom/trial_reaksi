<div class="min-h-screen bg-gray-100 dark:bg-black">
    <div class="mx-auto container sm:px-4">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('berita.index')" separator="slash">Berita</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">{{ $post->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mt-8 max-w-6xl m-auto ">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>
                <div class="flex items-center gap-4 text-gray-600 dark:text-gray-400">
                    <div class="flex items-center gap-2">
                        <flux:icon.user class="size-4"/>

                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon.calendar class="size-4"/>
                        <span>{{ $post->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Thumbnail Image --}}
            @if($post->thumbnail)
            <div class="mb-8">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-[400px] object-cover rounded-lg">
            </div>
            @endif

            {{-- Content --}}
            <article class="prose prose-lg dark:prose-invert max-w-none">
                {!! Str::markdown($post->content) !!}
            </article>
        </div>
    </div>
</div>
