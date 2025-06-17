<div class="min-h-screen bg-gray-100 dark:bg-black">
    <div class="mx-auto container sm:px-4">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">Produk</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div id="filterHeader" class="flex flex-row gap-2 items-center pt-5 sticky top-5 z-50 transition-all duration-300 w-full">
            {{-- Search Bar --}}
            <flux:field class="relative flex-grow bg-white dark:bg-black rounded-xl shadow-sm">
                <flux:icon.search class="absolute right-2 z-50 top-2"></flux:icon.search>
                <flux:input wire:model.live="search" placeholder="Masukan nama produk "/>
            </flux:field>

            {{-- Button Filter--}}
            <div class="relative flex-shrink-0">
                <button
                    wire:click="toggle"
                    class="flex items-center border gap-2 px-3 py-2 text-black dark:text-white text-sm font-medium w-full bg-white dark:bg-neutral-900 dark:border-zinc-800 rounded-md hover:bg-slate-100"
                >
                    <flux:icon.funnel class="text-black dark:text-white"></flux:icon.funnel>
                    Filter
                </button>

                {{-- Dropdown Filter --}}
                @if ($open)
                    <div class="absolute z-10 w-64 sm:w-80 right-0 top-12 bg-white dark:bg-black border dark:border-zinc-800 rounded-lg p-4 shadow-lg">
                        <div class="space-y-4">
                            <flux:field label="Status Afiliasi">
                                <flux:select wire:model.live="filterStatus">
                                    <option value="">Semua</option>
                                    <option value="affiliated">Terafiliasi</option>
                                    <option value="unaffiliated">Tidak Terafiliasi</option>
                                </flux:select>
                            </flux:field>

                            <flux:field label="Kategori">
                                <flux:select wire:model.live="filterCategory">
                                     <option value="">Semua Kategori</option>
                                     @foreach($categories as $kategori)
                                         <option value="{{$kategori->name}}">{{$kategori->name}}</option>
                                     @endforeach
                                 </flux:select>

                            </flux:field>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sort Options --}}
            <div class="flex-shrink-0 ml-auto">
                <flux:dropdown class="bg-white dark:bg-black">
                    <flux:button class="bg-white dark:bg-black" icon:trailing="adjustments-horizontal"></flux:button> {{-- Icon diganti --}}
                    <flux:menu>
                        <div class="p-2">
                            <h4 class="text-black dark:text-white mb-2 font-medium">Urutkan</h4>
                            <div class="flex gap-2">
                                <button wire:click="setSort('asc')" class="flex items-center gap-1 p-2 rounded {{ $sort === 'asc' ? 'bg-black/10 dark:bg-gray-900' : '' }} hover:bg-black/5 dark:hover:bg-gray-800">
                                    <flux:icon.arrow-down-a-z class="size-4 mr-1"/>
                                    <span class="text-sm">A-Z</span>
                                </button>
                                <button wire:click="setSort('desc')" class="flex items-center gap-1 p-2 rounded {{ $sort === 'desc' ? 'bg-black/10 dark:bg-gray-900' : '' }} hover:bg-black/5 dark:hover:bg-gray-800">
                                     <flux:icon.arrow-up-z-a class="size-4 mr-1"/>
                                    <span class="text-sm">Z-A</span>
                                </button>
                            </div>
                        </div>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </div>

        <div class="mt-6 mb-8">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Menampilkan <span class="font-medium text-gray-900 dark:text-white">{{ $products->count() }}</span>
                dari <span class="font-medium text-gray-900 dark:text-white">{{ $products->total() }}</span> produk
            </p>
        </div>

        {{-- Pastikan variabel $layout masih ada di komponen Livewire meskipun tidak bisa dipilih dari UI --}}
        <div class="{{ $layout === 'grid' ? 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6' : 'space-y-6' }}">
            @foreach($products as $product)
                {{-- Logika untuk menampilkan grid/list tetap ada, bisa diatur defaultnya di controller --}}
                @if($layout === 'grid')
                    <x-product.grid-card :product="$product" />
                @else
                    <x-product.list-card :product="$product" />
                @endif
            @endforeach

            @if($products->hasPages())
                <div class="col-span-full mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    const filterHeader = document.getElementById("filterHeader");
    window.addEventListener("scroll", function() {
        if (window.scrollY > 100) {
            filterHeader.classList.add("px-5");
        } else {
            filterHeader.classList.remove("px-5");
        }
    });
</script>
