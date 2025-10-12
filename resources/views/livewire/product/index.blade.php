<div class="min-h-screen bg-gray-100"
    x-data="{
        allProducts: @js($products),
        filteredProducts: @js($products),
        search: '',
        
        filters: {
            category: '',
            company: '',
            status: '',
            localProduct: ''
        },



        filterProducts() {
            let filtered = this.allProducts;

            if (this.search.trim() !== '') {
                const searchQuery = this.search.toLowerCase();
                filtered = filtered.filter(product => 
                    product.name.toLowerCase().includes(searchQuery) ||
                    (product.company && product.company.name.toLowerCase().includes(searchQuery)) ||
                    (product.category && product.category.name.toLowerCase().includes(searchQuery))
                );
            }

            if (this.filters.category !== '') {
                filtered = filtered.filter(product => 
                    product.category && String(product.category.id) === String(this.filters.category)
                );
            }

            if (this.filters.company !== '') {
                filtered = filtered.filter(product => 
                    product.company && String(product.company.id) === String(this.filters.company)
                );
            }

            if (this.filters.status !== '') {
                filtered = filtered.filter(product => 
                    product.status === this.filters.status
                );
            }

            if (this.filters.localProduct !== '') {
                const isLocal = this.filters.localProduct === 'true';
                filtered = filtered.filter(product => 
                    Boolean(product.local_product) === isLocal
                );
            }

            this.filteredProducts = filtered;
        },

        clearFilters() {
            this.filters = {
                category: '',
                company: '',
                status: '',
                localProduct: ''
            };
            this.search = '';
            this.filteredProducts = this.allProducts;
        },

        getActiveFiltersCount() {
            return Object.values(this.filters).filter(value => value !== '').length;
        }
    }"
    x-init="
        window.addEventListener('filtersApplied', e => { $data.filters = Array.isArray(e.detail) ? e.detail[0] : e.detail; $data.filterProducts(); });
        window.addEventListener('filtersCleared', e => { $data.filters = Array.isArray(e.detail) ? e.detail[0] : e.detail; $data.search = ''; $data.filteredProducts = $data.allProducts; });
        window.alpineProduct = $data;
    ">
    {{-- @dd($products) --}}
    <div class="mx-auto container sm:px-4">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">Produk</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div id="filterHeader" 
             class="flex flex-row gap-2 items-center pt-5 sticky top-5 z-50 transition-all duration-300 w-full"
             x-data="{ scrolled: false }"
             x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 100 })"
             :class="{ 'px-5': scrolled }">
            {{-- Search Bar --}}
            <div class="relative grow bg-white rounded-xl shadow-sm"> 
                <flux:icon.search class="absolute right-2 z-50 top-2"></flux:icon.search>
                <flux:input 
                    placeholder="Cari di REAKSI" 
                    x-model="search" 
                    x-on:input="filterProducts()"
                    />
            </div>

            {{-- Filter Button --}}
            <flux:modal.trigger name="filter-modal">
                <flux:button 
                    variant="outline" 
                    class="relative flex items-center gap-2 bg-white rounded-xl shadow-sm">
                    <flux:icon.funnel class="size-4" />
                    Filter
                    <span x-show="getActiveFiltersCount() > 0" 
                          class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                          x-text="getActiveFiltersCount()"></span>
                </flux:button>
            </flux:modal.trigger>
        </div>

        <livewire:product.filter-modal wire:key="filter-modal" />
            
        <div class="mt-6 mb-8">
            <p class="text-sm text-gray-600">
                Menampilkan <span class="font-medium text-gray-900" x-text="filteredProducts.length"></span>
                dari <span class="font-medium text-gray-900" x-text="allProducts.length"></span> produk
                <span x-show="search.trim() !== ''" class="text-blue-600">
                    untuk "<span x-text="search"></span>"
                </span>
            </p>
        </div>

        {{-- Empty State --}}
        <div x-show="filteredProducts.length === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-3-8a8 8 0 108 8 8 8 0 00-8-8z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">
                Coba ubah kata kunci pencarian Anda.
            </p>
        </div>

        {{-- Products --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div x-show="filteredProducts.some(fp => fp.id === {{ $product->id }})">
                    <x-product.grid-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</div>
