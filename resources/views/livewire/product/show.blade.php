<div class="min-h-screen bg-gray-50 dark:bg-black py-8">
    <div class="container mx-auto space-y-8">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('product.index')" separator="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">{{ $product->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="flex flex-col md:flex-row gap-6">
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
                        class="object-cover h-2/3 w-full"
                    />
                    <div class="p-6 space-y-4 h-1/3">
                        <span class="inline-block text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            {{ $product->category->name }}
                        </span>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $product->description }}</p>

                    @if($product->source)
                            <a href="{{ $product->source }}" target="_blank" class="text-blue-500 dark:text-blue-400 text-sm hover:underline">
                                Lihat Website Produk
                            </a>
                        @endif
                        <div class="flex gap-3 items-center mt-6">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Bagikan:</span>

                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank"
                               class="flex items-center gap-1 px-3 py-2 text-sm rounded-md bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-600/30 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook-icon lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                Facebook
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode(request()->fullUrl()) }}"
                               target="_blank"
                               class="flex items-center gap-1 px-3 py-2 text-sm rounded-md bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-600/30 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                </svg>
                                WhatsApp
                            </a>

                            <!-- Instagram -->
                            <a href="https://www.instagram.com/?url={{ urlencode(request()->fullUrl()) }}"
                                target="_blank"
                                class="flex items-center gap-1 px-3 py-2 text-sm rounded-md bg-pink-100 dark:bg-pink-500/20 text-pink-600 dark:text-pink-400 hover:bg-pink-200 dark:hover:bg-pink-600/30 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                                </svg>
                                Instagram
                             </a>
 

                            <!-- Twitter / X -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}"
                               target="_blank"
                               class="flex items-center gap-1 px-3 py-2 text-sm rounded-md bg-sky-100 dark:bg-sky-500/20 text-sky-600 dark:text-sky-400 hover:bg-sky-200 dark:hover:bg-sky-600/30 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/>
                                </svg>
                                Twitter
                            </a>
                        </div>
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
</div>
