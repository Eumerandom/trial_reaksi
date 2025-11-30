<flux:modal name="filter-modal" class="w-sm md:w-d lg:w-lg max-w-lg">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Filter Produk</flux:heading>
            <flux:text class="mt-2">Pilih filter untuk memudahkan</flux:text>
        </div>        

        <flux:field>
            <flux:label>Kategori</flux:label>
            <div x-data="{ 
                open: false, 
                search: '', 
                selected: @entangle('filters.category'),
                selectedText: 'Semua Kategori',
                categories: @js($categories),
                
                get filteredCategories() {
                    if (!this.search) return this.categories;
                    return this.categories.filter(cat => 
                        cat.name.toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                
                selectCategory(id, name) {
                    this.selected = id;
                    this.selectedText = name || 'Semua Kategori';
                    this.open = false;
                    this.search = '';
                },
                  init() {
                    this.$watch('selected', (value) => {
                        this.selectedText = value === '' ? 'Semua Kategori' : 
                            (this.categories.find(c => c.id == value)?.name || 'Semua Kategori');
                    });
                }
            }" 
            class="relative">
                <button 
                    @click="open = !open"
                    type="button"
                    class="w-full px-3 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-zinc-900 flex items-center justify-between">
                    <span x-text="selectedText"></span>
                    <flux:icon.chevron-down class="size-4 text-gray-500" />
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    <div class="p-2 border-b border-gray-200">
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Cari kategori..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white text-zinc-900 placeholder-gray-500">
                    </div>
                    
                    <div class="py-1">
                        <button 
                            @click="selectCategory('', 'Semua Kategori')"
                            type="button"
                            class="w-full px-3 py-2 text-left hover:bg-gray-100 text-sm text-zinc-900">
                            Semua Kategori
                        </button>
                        
                        <template x-for="category in filteredCategories" :key="category.id">
                            <button 
                                @click="selectCategory(category.id, category.name)"
                                type="button"
                                class="w-full px-3 py-2 text-left hover:bg-gray-100 text-sm text-zinc-900"
                                x-text="category.name">
                            </button>
                        </template>
                        
                        <div x-show="filteredCategories.length === 0 && search" class="px-3 py-2 text-sm text-gray-500">
                            Tidak ada kategori ditemukan
                        </div>
                    </div>
                </div>
            </div>
        </flux:field> 
            
        <flux:field>
            <flux:label>Perusahaan</flux:label>
            <div x-data="{ 
                open: false, 
                search: '', 
                selected: @entangle('filters.company'),
                selectedText: 'Semua Perusahaan',
                companies: @js($companies),
                
                get filteredCompanies() {
                    if (!this.search) return this.companies;
                    return this.companies.filter(company => 
                        company.name.toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                
                selectCompany(id, name) {
                    this.selected = id;
                    this.selectedText = name || 'Semua Perusahaan';
                    this.open = false;
                    this.search = '';
                },
                  init() {
                    this.$watch('selected', (value) => {
                        this.selectedText = value === '' ? 'Semua Perusahaan' : 
                            (this.companies.find(c => c.id == value)?.name || 'Semua Perusahaan');
                    });
                }
            }" 
            class="relative">
                <button 
                    @click="open = !open"
                    type="button"
                    class="w-full px-3 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-zinc-900 flex items-center justify-between">
                    <span x-text="selectedText"></span>
                    <flux:icon.chevron-down class="size-4 text-gray-500" />
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    <div class="p-2 border-b border-gray-200">
                        <input 
                            x-model="search"
                            type="text" 
                            placeholder="Cari perusahaan..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white text-zinc-900 placeholder-gray-500">
                    </div>
                    
                    <div class="py-1">
                        <button 
                            @click="selectCompany('', 'Semua Perusahaan')"
                            type="button"
                            class="w-full px-3 py-2 text-left hover:bg-gray-100 text-sm text-zinc-900">
                            Semua Perusahaan
                        </button>
                        
                        <template x-for="company in filteredCompanies" :key="company.id">
                            <button 
                                @click="selectCompany(company.id, company.name)"
                                type="button"
                                class="w-full px-3 py-2 text-left hover:bg-gray-100 text-sm text-zinc-900"
                                x-text="company.name">
                            </button>
                        </template>
                        
                        <div x-show="filteredCompanies.length === 0 && search" class="px-3 py-2 text-sm text-gray-500">
                            Tidak ada perusahaan ditemukan
                        </div>
                    </div>
                </div>
            </div>
        </flux:field>    

        <flux:field>
            <flux:label>Status Boikot</flux:label>
            <div x-data="{ 
                open: false, 
                selected: @entangle('filters.status'),
                selectedText: 'Semua Status',
                options: [
                    { id: '', name: 'Semua Status' },
                    @foreach($statusOptions as $opt)
                    { id: '{{ $opt['id'] }}', name: '{{ $opt['name'] }} ({{ $opt['cta'] }})' },
                    @endforeach
                ],
                
                selectOption(id, name) {
                    this.selected = id;
                    this.selectedText = name || 'Semua Status';
                    this.open = false;
                },
                  init() {
                    this.$watch('selected', (value) => {
                        this.selectedText = this.options.find(o => o.id === value)?.name || 'Semua Status';
                    });
                }
            }" 
            class="relative">
                <button 
                    @click="open = !open"
                    type="button"
                    class="w-full px-3 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-zinc-900 flex items-center justify-between">
                    <span x-text="selectedText"></span>
                    <flux:icon.chevron-down class="size-4 text-gray-500" />
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    
                    <div class="py-1">
                        <template x-for="option in options" :key="option.id">
                            <button 
                                @click="selectOption(option.id, option.name)"
                                type="button"
                                class="w-full px-3 py-2 text-left hover:bg-gray-100 text-sm text-zinc-900"
                                x-text="option.name">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </flux:field>     

        <flux:field>
            <flux:label>Jenis Produk</flux:label>
            <div x-data="{ 
                open: false, 
                selected: @entangle('filters.localProduct'),
                selectedText: 'Semua Jenis',
                options: [
                    { id: '', name: 'Semua Jenis' },
                    { id: 'true', name: 'Produk Lokal' },
                    { id: 'false', name: 'Produk Import' }
                ],
                
                selectOption(id, name) {
                    this.selected = id;
                    this.selectedText = name || 'Semua Jenis';
                    this.open = false;
                },
                  init() {
                    this.$watch('selected', (value) => {
                        this.selectedText = this.options.find(o => o.id === value)?.name || 'Semua Jenis';
                    });
                }
            }" 
            class="relative">
                <button 
                    @click="open = !open"
                    type="button"
                    class="w-full px-3 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-zinc-900 flex items-center justify-between">
                    <span x-text="selectedText"></span>
                    <flux:icon.chevron-down class="size-4 text-gray-500" />
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    
                    <div class="py-1">
                        <template x-for="option in options" :key="option.id">
                            <button 
                                @click="selectOption(option.id, option.name)"
                                type="button"
                                class="w-full px-3 py-2 text-left hover:bg-gray-100 text-sm text-zinc-900"
                                x-text="option.name">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </flux:field>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <flux:button 
                variant="ghost" 
                type="button"
                wire:click="clearFilters"
                class="text-gray-600 hover:text-gray-800">
                <div class="flex items-center justify-center gap-2">
                    <flux:icon.arrow-path class="size-4 flex-shrink-0" />
                    <span>Reset Filter</span>
                </div>
            </flux:button>
              <flux:button
                variant="primary"
                type="button"
                wire:click="applyFilters"
                class="bg-gradient-to-r from-zinc-600 to-zinc-700 hover:from-zinc-700 hover:to-zinc-800 text-white px-6 py-2.5 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-200">
                    <flux:icon.check class="size-4 flex-shrink-0" />
            </flux:button>
        </div>
    </div>
</flux:modal>
