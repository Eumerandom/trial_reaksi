<div class="min-h-screen bg-gray-100 dark:bg-zinc-900 py-8">
    <div class="container mx-auto space-y-8">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('product.index')" separator="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">{{ $product->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="max-w-6xl m-auto flex flex-col md:flex-row gap-6">
            {{--Produk Card--}}
            @if($product)
                <div class="w-full md:w-1/2 bg-white h-full dark:bg-zinc-800 shadow-md rounded-xl overflow-hidden relative">
                    <div @class([
                        'absolute top-4 left-4 text-xs font-semibold px-3 py-1 rounded-full',
                        'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400' => $product->status === 'affiliated',
                        'bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400' => $product->status === 'unaffiliated',
                    ])>
                        {{ $product->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi' }}
                    </div>

                    <img
                        src="{{ '/storage/' . $product->image }}"
                        alt="{{ $product->name }}"
                        class="object-cover h-64 w-full"
                    />
                    <div class="p-6 space-y-2 h-1/3">
                       <div>
                            <div>
                                <span class="inline-block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    {{ $product->category->name }}
                                </span>
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->name }}</h2>
                            </div>
                            <!-- Share Button -->
                            <div class="flex items-center mt-6">
                                <button wire:click="toggleShareModal" class="p-3 rounded-full bg-gray-100 dark:bg-zinc-700 hover:bg-gray-200 dark:hover:bg-zinc-600 transition-all duration-200">
                                    <flux:icon.share class="size-5 text-gray-600 dark:text-gray-400"></flux:icon.share>
                                </button>
                            </div>
                       </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $product->description }}</p>

                        @if($product->source)
                            <a href="{{ $product->source }}" target="_blank" class="text-blue-500 dark:text-blue-400 text-sm hover:underline">
                                Lihat Website Produk
                            </a>
                        @endif
                        

                    </div>
                </div>
            @endif

            {{--Company Card--}}
            @if($company)
                <div class="w-full md:w-1/2 bg-white dark:bg-zinc-800 shadow-md rounded-xl p-8 space-y-6 relative">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                            <flux:icon.building class="text-gray-400 dark:text-gray-500 size-8"></flux:icon.building>
                        </div>
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $company->name }}</h2>
                        </div>
                    </div>

                    <div @class([
                        'p-5 rounded-md relative',
                        'border border-red-500 bg-red-100/40 dark:bg-red-500/10' => $product->status === 'affiliated',
                        'border border-green-500 bg-green-100/40 dark:bg-green-500/10' => $product->status === 'unaffiliated',
                    ])>
                        <div class="absolute top-4 right-4 text-xs flex items-center gap-1
                            {{ $product->status === 'affiliated' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                            <flux:icon.clock class="size-4"></flux:icon.clock>
                            <span>{{ \Carbon\Carbon::make($product->updated_at)->format('Y-m-d') }}</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <flux:icon.info @class([
                                'text-red-500 dark:text-red-400' => $product->status === 'affiliated',
                                'text-green-500 dark:text-green-400' => $product->status === 'unaffiliated',
                            ])></flux:icon.info>
                            <h3 class="text-xl font-semibold">
                                {{ $product->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi' }}
                            </h3>
                        </div>
                        <div class="ml-8">
                            <p class="text-zinc-400 text-sm font-thin">
                                {{$product->status === "affiliated"
                                    ? "Produk ini terafiliasi dengan Pembunuh Anak Kecil. Pertimbangkan informasi ini sebelum membeli."
                                    : "Produk ini tidak terafiliasi dengan pihak tertentu. Anda bebas memilih untuk membeli."}}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Share Modal -->
    <div x-show="$wire.showShareModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center"
         style="background-color: rgba(0,0,0,0.5);">
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6 w-80 transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bagikan</h3>
                <button wire:click="toggleShareModal" class="text-gray-400 hover:text-gray-500">
                    <flux:icon.x class="size-5"></flux:icon.x>
                </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                   target="_blank"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-600/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook size-6 mb-2">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                    </svg>
                    <span class="text-sm">Facebook</span>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ urlencode(request()->fullUrl()) }}"
                   target="_blank"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-600/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 mb-2">
                        <path d="M3 21l1.65-3.8a9 9 0 1 1 3.4 2.9L3 21"/>
                        <path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0v1a5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/>
                    </svg>
                    <span class="text-sm">WhatsApp</span>
                </a>

                <!-- Instagram -->
                <a href="https://www.instagram.com/?url={{ urlencode(request()->fullUrl()) }}"
                   target="_blank"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-pink-50 dark:bg-pink-500/10 text-pink-600 dark:text-pink-400 hover:bg-pink-100 dark:hover:bg-pink-600/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 mb-2">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                    </svg>
                    <span class="text-sm">Instagram</span>
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}"
                   target="_blank"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400 hover:bg-sky-100 dark:hover:bg-sky-600/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 mb-2">
                        <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
                    </svg>
                    <span class="text-sm">Twitter</span>
                </a>
            </div>
        </div>
    </div>
</div>
