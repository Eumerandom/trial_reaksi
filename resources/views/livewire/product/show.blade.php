<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto space-y-8">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('product.index')" separator="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">{{ $product->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="max-w-6xl m-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($product)
                <div class="group relative overflow-hidden rounded-2xl bg-white ring-1 ring-black/5 shadow-sm">
                    <div class="relative w-full aspect-square">
                        <span @class([
                            'absolute z-10 top-4 left-4 px-3 py-1 rounded-full text-xs font-semibold',
                            'bg-red-100 text-red-600' => $product->status === 'affiliated',
                            'bg-green-100 text-green-600' => $product->status === 'unaffiliated',
                        ])>
                            {{ $product->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi' }}
                        </span>

                        @if(isset($product->local_product))
                            <span class="absolute z-10 top-4 right-4 px-3 py-1 rounded-full text-xs font-medium bg-black/60 text-white backdrop-blur">
                                {{ $product->local_product ? 'Produk Lokal' : 'Produk Import' }}
                            </span>
                        @endif

                        <img
                            src="{{ $product->image ? '/storage/' . $product->image : 'https://placehold.co/800x600' }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                            decoding="async"
                            class="h-full w-full object-cover transition-transform duration-300" />

                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            @if($product->category?->name)
                                <span class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-2 py-0.5 text-[11px]">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            @if(isset($product->local_product))
                                <span class="inline-flex items-center rounded-md bg-black/5 text-gray-700 px-2 py-0.5 text-[11px]">
                                    {{ $product->local_product ? 'Lokal' : 'Import' }}
                                </span>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
                            <div class="flex items-center gap-2 text-gray-500">
                                <flux:icon.building class="size-4"></flux:icon.building>
                                <span class="text-sm">{{ $product->company?->name }}</span>
                            </div>
                        </div>

                        <p class="text-gray-700 text-sm leading-relaxed">
                            {{ $product->description }}
                        </p>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            @if($product->source)
                                <a href="{{ $product->source }}" target="_blank" rel="noopener noreferrer" title="Buka sumber berita di tab baru" aria-label="Buka sumber berita di tab baru"
                                   class="inline-flex items-center gap-2 rounded-md bg-gray-900 text-white px-3 py-2 text-xs font-medium transition hover:opacity-90">
                                    Lihat Sumber Berita
                                    <flux:icon.chevron-right class="size-3"></flux:icon.chevron-right>
                                </a>
                            @endif

                            <button
                                wire:click="toggleShareModal"
                                class="inline-flex items-center gap-2 rounded-md bg-black/5 text-gray-900 px-3 py-2 text-xs font-medium transition hover:bg-black/10">
                                <flux:icon.share class="size-3"></flux:icon.share>
                                Bagikan
                            </button>

                            <span class="ml-auto inline-flex items-center gap-1 text-[11px] text-gray-500">
                                <flux:icon.clock class="size-3"></flux:icon.clock>
                                <span>Update: {{ \Carbon\Carbon::make($product->updated_at)->format('Y-m-d') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            @if($company)
                <div class="w-full rounded-2xl bg-white ring-1 ring-black/5 shadow-sm p-6 md:p-8 space-y-6 md:sticky md:top-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <flux:icon.building class="text-gray-400 size-7 md:size-8"></flux:icon.building>
                        </div>
                        <div>
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-900">{{ $company->name }}</h2>
                        </div>
                    </div>

                    <div @class([
                        'p-5 rounded-lg relative',
                        'border border-red-500/60 bg-red-50' => $product->status === 'affiliated',
                        'border border-green-500/60 bg-green-50' => $product->status === 'unaffiliated',
                    ])>
                        <div class="absolute top-4 right-4 text-xs flex items-center gap-1
                            {{ $product->status === 'affiliated' ? 'text-red-600' : 'text-green-600' }}">
                            <flux:icon.clock class="size-4"></flux:icon.clock>
                            <span>{{ \Carbon\Carbon::make($product->updated_at)->format('Y-m-d') }}</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <flux:icon.info @class([
                                'text-red-500' => $product->status === 'affiliated',
                                'text-green-500' => $product->status === 'unaffiliated',
                            ])></flux:icon.info>
                            <h3 class="text-lg md:text-xl font-semibold">
                                {{ $product->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi' }}
                            </h3>
                        </div>
                        <div class="ml-8 mt-1">
                            <p class="text-zinc-600 text-sm">
                                {{$product->status === "affiliated"
                                    ? "Produk ini terafiliasi dengan Pembunuh Anak Kecil. Pertimbangkan informasi ini sebelum membeli."
                                    : "Produk ini tidak terafiliasi dengan pihak tertentu. Anda bebas memilih untuk membeli."}}
                            </p>
                        </div>
                    </div>

                    <x-product.stepper-company :parents="$parents" :company="$company" />
                </div>
            @endif
        </div>
    </div>

    <div x-show="$wire.showShareModal" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
         role="dialog" aria-modal="true" aria-labelledby="share-modal-title" @keydown.escape.window="$wire.toggleShareModal()">
        <div class="bg-white rounded-xl shadow-lg p-6 w-80 transform transition-all ring-1 ring-black/5"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="flex justify-between items-center mb-4">
                <h3 id="share-modal-title" class="text-lg font-semibold text-gray-900">Bagikan</h3>
                <button wire:click="toggleShareModal" class="text-gray-400 hover:text-gray-500">
                    <flux:icon.x class="size-5"></flux:icon.x>
                </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook size-6 mb-2">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                    </svg>
                    <span class="text-sm">Facebook</span>
                </a>

                <a href="https://wa.me/?text={{ urlencode(request()->fullUrl()) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 mb-2">
                        <path d="M3 21l1.65-3.8a9 9 0 1 1 3.4 2.9L3 21"/>
                        <path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0v1a5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/>
                    </svg>
                    <span class="text-sm">WhatsApp</span>
                </a>

                <a href="https://www.instagram.com/?url={{ urlencode(request()->fullUrl()) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-pink-50 text-pink-600 hover:bg-pink-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 mb-2">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                    </svg>
                    <span class="text-sm">Instagram</span>
                </a>

                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex flex-col items-center justify-center p-4 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 mb-2">
                        <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
                    </svg>
                    <span class="text-sm">Twitter</span>
                </a>
            </div>
        </div>
    </div>
</div>
