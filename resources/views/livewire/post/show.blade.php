<div class="min-h-screen bg-gray-100 dark:bg-black">
    <div class="mx-auto container sm:px-4">
    <div class="">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('berita.index')" separator="slash">Berita</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">{{ $post->title }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="container mx-auto">
            {{-- Header Container --}}
            <div class="container mx-auto">
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

                {{-- Image --}}
                @if($post->thumbnail)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-[400px] object-cover rounded-lg">
                </div>
                @endif
            </div>

            <div class="relative">
                <div class="container mx-auto {{ ($toc && trim($toc) !== '') ? 'lg:pr-80' : '' }}">
                    <article class="p-6 md:p-8">
                        <div class="markdown-content prose prose-lg dark:prose-invert max-w-none 
                        [&>h1]:text-3xl [&>h1]:font-bold [&>h1]:text-gray-900 [&>h1]:dark:text-white [&>h1]:mb-6 [&>h1]:mt-8
                        [&>h2]:text-2xl [&>h2]:font-semibold [&>h2]:text-gray-900 [&>h2]:dark:text-white [&>h2]:mb-4 [&>h2]:mt-6 [&>h2]:border-b [&>h2]:border-gray-200 [&>h2]:dark:border-gray-700 [&>h2]:pb-2
                        [&>h3]:text-xl [&>h3]:font-medium [&>h3]:text-gray-900 [&>h3]:dark:text-white [&>h3]:mb-3 [&>h3]:mt-5
                        [&>h4]:text-lg [&>h4]:font-medium [&>h4]:text-gray-900 [&>h4]:dark:text-white [&>h4]:mb-2 [&>h4]:mt-4
                        [&>p]:text-gray-700 [&>p]:dark:text-gray-300 [&>p]:leading-relaxed [&>p]:mb-4 [&>p]:text-base
                        [&>ul]:list-disc [&>ul]:ml-6 [&>ul]:mb-4 [&>ul]:space-y-1
                        [&>ol]:list-decimal [&>ol]:ml-6 [&>ol]:mb-4 [&>ol]:space-y-1
                        [&>li]:text-gray-700 [&>li]:dark:text-gray-300
                        [&>blockquote]:border-l-4 [&>blockquote]:border-blue-500 [&>blockquote]:bg-blue-50 [&>blockquote]:dark:bg-blue-900/20 [&>blockquote]:py-3 [&>blockquote]:px-4 [&>blockquote]:mb-4 [&>blockquote]:italic [&>blockquote]:text-gray-700 [&>blockquote]:dark:text-gray-300
                        [&>pre]:bg-gray-900 [&>pre]:dark:bg-gray-950 [&>pre]:text-gray-100 [&>pre]:p-4 [&>pre]:rounded-lg [&>pre]:overflow-x-auto [&>pre]:mb-4 [&>pre]:text-sm
                        [&>code]:bg-gray-100 [&>code]:dark:bg-gray-800 [&>code]:px-2 [&>code]:py-1 [&>code]:rounded [&>code]:text-sm [&>code]:text-red-600 [&>code]:dark:text-red-400 [&>code]:font-mono
                        [&>a]:text-blue-600 [&>a]:dark:text-blue-400 [&>a]:no-underline [&>a]:hover:underline
                        [&>strong]:text-gray-900 [&>strong]:dark:text-white [&>strong]:font-semibold
                        [&>em]:italic [&>em]:text-gray-700 [&>em]:dark:text-gray-300
                        [&>table]:border-collapse [&>table]:w-full [&>table]:mb-4
                        [&>table>thead>tr>th]:border [&>table>thead>tr>th]:border-gray-300 [&>table>thead>tr>th]:dark:border-gray-600 [&>table>thead>tr>th]:bg-gray-50 [&>table>thead>tr>th]:dark:bg-gray-800 [&>table>thead>tr>th]:p-3 [&>table>thead>tr>th]:text-left [&>table>thead>tr>th]:font-semibold
                        [&>table>tbody>tr>td]:border [&>table>tbody>tr>td]:border-gray-300 [&>table>tbody>tr>td]:dark:border-gray-600 [&>table>tbody>tr>td]:p-3
                        [&>img]:rounded-lg [&>img]:shadow-md [&>img]:mb-4 [&>img]:max-w-full [&>img]:h-auto
                        [&>hr]:border-gray-300 [&>hr]:dark:border-gray-700 [&>hr]:my-8">
                            {!! $htmlContent !!}
                        </div>
                    </article>
                </div>
                {{-- TOC --}}
                @if($toc && trim($toc) !== '')
                <div class="hidden lg:block fixed top-20 right-8 w-64 h-fit">
                    <div class="sticky top-8">
                        <div class="bg-white/95 dark:bg-zinc-900/95 backdrop-blur-sm rounded-xl p-5 shadow-lg border border-gray-200/60 dark:border-zinc-700/60">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2 pb-2 border-b border-gray-200 dark:border-zinc-700">
                                <flux:icon.document-text class="size-4"/>
                                Table of Contents
                            </h3>
                            <nav class="toc-menu text-xs space-y-1 max-h-[70vh] overflow-y-auto
                            [&_ul]:list-none [&_ul]:space-y-1 [&_ul]:m-0 [&_ul]:p-0
                            [&_ul_ul]:pl-3 [&_ul_ul]:mt-1 [&_ul_ul]:border-l [&_ul_ul]:border-gray-200 [&_ul_ul]:dark:border-zinc-700
                            [&_li]:my-0
                            [&_a]:text-gray-600 [&_a]:dark:text-gray-400 [&_a]:no-underline [&_a]:block [&_a]:py-1.5 [&_a]:px-2 [&_a]:rounded-md [&_a]:transition-all [&_a]:duration-200 [&_a]:text-xs [&_a]:leading-relaxed
                            [&_a:hover]:text-blue-600 [&_a:hover]:dark:text-blue-400 [&_a:hover]:bg-blue-50 [&_a:hover]:dark:bg-blue-900/30 [&_a:hover]:translate-x-1
                            [&_a.active]:text-blue-600 [&_a.active]:dark:text-blue-400 [&_a.active]:font-medium [&_a.active]:bg-blue-50 [&_a.active]:dark:bg-blue-900/30 [&_a.active]:border-l-2 [&_a.active]:border-blue-500 [&_a.active]:pl-1
                            scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-zinc-600 scrollbar-track-transparent">
                                {!! $toc !!}
                            </nav>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</div>


