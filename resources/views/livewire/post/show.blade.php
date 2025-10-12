<div class="min-h-screen p-6 md:p-2 bg-gray-100" x-data="tocSpy()" x-init="init()">
    <div class="mx-auto container sm:px-4">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('berita.index')" separator="slash">Berita</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">{{ $post->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="container mx-auto">
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

            <div class="relative flex">
                @if(!empty($toc))
                    <aside
                        class="hidden lg:block w-72 fixed right-10 top-40 border-l border-neutral-300 pl-6
           overflow-y-auto max-h-[calc(100vh-10rem)] text-sm text-blue-800/70"
                    >
                        <h2 class="font-semibold mb-3 text-blue-900/80 uppercase tracking-wide text-xs">
                            Daftar Isi
                        </h2>

                        <ul class="space-y-1.5">
                            @foreach ($toc as $item)
                                <li
                                    style="margin-left: {{ ((int)$item['level'] - 1) * 12 }}px"
                                    class="transition-colors duration-200"
                                >
                                    <a
                                        href="#{{ $item['id'] }}"
                                        x-bind:class="active === '{{ $item['id'] }}'
                        ? 'text-muted font-medium border-l-2 border-neutral-900 pl-2 bg-blue-50/40'
                        : 'text-neutral-700 hover:text-blue-800 hover:bg-blue-50/30 hover:pl-2'"
                                        class="block py-0.5 px-1.5 "
                                    >
                                        {{ $item['text'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>

                @endif

                <div class="container mx-auto {{ !empty($toc) ? 'lg:pr-80' : '' }}">
                    <article class="prose prose-lg max-w-none" x-ref="content">
                        {!! $htmlContent !!}
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tocSpy', () => ({
            active: null,
            observer: null,
            init() {
                const headings = this.$refs.content?.querySelectorAll('h1[id],h2[id],h3[id],h4[id]');
                if (!headings || headings.length === 0) return;

                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) this.active = entry.target.id;
                    });
                }, {
                    rootMargin: '0px 0px -70% 0px',
                    threshold: 0
                });

                headings.forEach(h => this.observer.observe(h));
            },
        }));
    });
</script>
