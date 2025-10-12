<div class="min-h-screen bg-gray-100">
    <div class="mx-auto container sm:px-4">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">Berita</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div id="filterHeader" class="flex flex-row gap-2 items-center pt-5 sticky top-5 z-50 transition-all duration-300 w-full">
            {{-- Search Bar --}}
            <flux:field class="relative grow bg-white rounded-xl shadow-sm">
                <flux:icon.search class="absolute right-2 z-50 top-2"></flux:icon.search>
                <flux:input wire:model.live="search" placeholder="Masukan judul berita"/>
            </flux:field>

            {{-- Button Filter--}}
            <div class="relative shrink-0">
                <button
                    wire:click="toggle"
                    class="flex items-center border gap-2 px-3 py-2 text-black text-sm font-medium w-full bg-white rounded-md hover:bg-slate-100"
                >
                    <flux:icon.funnel class="text-black"></flux:icon.funnel>
                    Filter
                </button>

                {{-- Dropdown Filter --}}
                @if ($open)
                    <div class="absolute z-10 w-64 sm:w-80 right-0 top-12 bg-white border rounded-lg p-4 shadow-lg">
                        <div class="space-y-4">
                            <flux:field label="Status">
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
            <div class="shrink-0 ml-auto">
                <flux:dropdown class="bg-white">
                    <flux:button class="bg-white" icon:trailing="adjustments-horizontal"></flux:button>
                    <flux:menu>
                        <div class="p-2">
                            <h4 class="text-black mb-2 font-medium">Urutkan</h4>
                            <div class="flex gap-2">
                                <button wire:click="setSort('asc')" class="flex items-center gap-1 p-2 rounded {{ $sort === 'asc' ? 'bg-black/10' : '' }} hover:bg-black/5">
                                    <flux:icon.arrow-down-a-z class="size-4 mr-1"/>
                                    <span class="text-sm">A-Z</span>
                                </button>
                                <button wire:click="setSort('desc')" class="flex items-center gap-1 p-2 rounded {{ $sort === 'desc' ? 'bg-black/10' : '' }} hover:bg-black/5">
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
            <p class="text-sm text-gray-600">
                Menampilkan <span class="font-medium text-gray-900">{{ $posts->count() }}</span>
                dari <span class="font-medium text-gray-900">{{ $posts->total() }}</span> berita
            </p>
        </div>

        <div class="{{ $layout === 'grid' ? 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6' : 'space-y-6' }}">
            @foreach($posts as $post)
                <x-post.grid-card :post="$post" />
            @endforeach

            @if($posts->hasPages())
                <div class="col-span-full mt-8">
                    {{ $posts->links() }}
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
