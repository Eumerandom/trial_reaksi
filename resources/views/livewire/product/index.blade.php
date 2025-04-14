<div class="min-h-screen bg-gray-50 dark:bg-gray-950">
    <div class="mx-auto container">
        <div id="filterHeader" class="flex flex-col pt-10 sm:flex-row gap-4 items-stretch sm:items-center sticky top-5 z-50 transition-all duration-300">
            {{-- Search Bar --}}
            <flux:field class="relative sm:w-6/12 w-full bg-white dark:bg-gray-900 rounded-xl shadow-sm">
                <flux:icon.search class="absolute right-2 z-50 top-2"></flux:icon.search>
                <flux:input wire:model.live="search" placeholder="Masukan nama produk "/>
            </flux:field>

            <div class="relative sm:w-4/12 w-full">
            {{-- Button Filter--}}
                <button
                    wire:click="toggle"
                    class="flex items-center gap-2 px-3 py-2 text-black dark:text-white text-sm font-medium w-full bg-white dark:bg-gray-800 text-white rounded hover:bg-slate-200 dark:hover:bg-gray-800"
                >
                    <flux:icon.funnel class="text-black dark:text-white"></flux:icon.funnel>
                    Filter
                </button>

                {{-- Dropdown Filter--}}
                @if ($open)
                    <div class="absolute z-10 w-full bg-gray-900 border border-gray-700 rounded p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-white">Status Afiliasi</label>
                                <select wire:model.live="filterStatus" class="mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded">
                                    <option value="">Semua</option>
                                    <option value="affiliated">Terafiliasi</option>
                                    <option value="unaffiliated">Tidak Terafiliasi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-white">Kategori</label>
                                <select wire:model.live="filterCategory" class="mt-1 w-full bg-gray-800 text-white border border-gray-700 rounded">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $kategori)
                                        <option value="{{$kategori->name}}">{{$kategori->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="w-2/12">
                <flux:dropdown class="bg-white dark:bg-gray-800">
                    <flux:button class="bg-white dark:bg-gray-800" icon:trailing="sliders-horizontal"></flux:button>
                    <flux:menu>
                        <div class="p-2">
                            <h4 class="text-black dark:text-white mb-2">Layout</h4>
                            <div class="flex gap-2">
                                <button wire:click="setLayout('grid')" class="p-2 rounded {{ $layout === 'grid' ? 'bg-black/10 dark:bg-gray-700' : '' }}">
                                    <flux:icon.layout-grid class="size-5"></flux:icon.layout-grid>
                                </button>
                                <button wire:click="setLayout('list')" class="p-2 rounded {{ $layout === 'list' ? 'bg-black/10 dark:bg-gray-700' : '' }}">
                                    <flux:icon.list class="size-5"></flux:icon.list>
                                </button>
                            </div>
                        </div>
                    </flux:menu>
                </flux:dropdown>
            </div>

        </div>
        <div class="mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Menampilkan <span class="font-medium text-gray-900 dark:text-white">{{ $products->count() }}</span>
                dari <span class="font-medium text-gray-900 dark:text-white">{{ $products->total() }}</span> produk
            </p>
        </div>

        <div class="{{ $layout === 'grid' ? 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6' : 'space-y-6' }}">

            @foreach($products as $product)
                @if($layout === 'grid')
                    <x-product.grid-card :product="$product" />
                @else
                    <x-product.list-card :product="$product" />
                @endif
            @endforeach

            <div class="col-span-full mt-8">
                {{ $products->links() }}
            </div>
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
