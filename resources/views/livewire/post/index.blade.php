<div class="min-h-screen bg-gray-100">
    <div class="mx-auto container sm:px-4">
        <flux:breadcrumbs class="pt-5">
            <flux:breadcrumbs.item :href="route('dashboard')" separator="slash">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item separator="slash">Berita</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div id="filterHeader" 
             class="flex flex-row gap-2 items-center pt-5 sticky top-5 z-50 transition-all duration-300 w-full"
             x-data="{ scrolled: false }"
             x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 100 })"
             :class="{ 'px-5': scrolled }">
            {{-- Search Bar --}}
            <div class="relative grow bg-white rounded-xl shadow-sm">
                <flux:icon.search class="absolute right-2 z-50 top-2"></flux:icon.search>
                <flux:input wire:model.live="search" placeholder="Masukan judul berita"/>
            </div>

            {{-- Button Filter--}}
            <div class="relative shrink-0">
                <flux:button
                    wire:click="toggle"
                    variant="outline"
                    class="relative flex items-center gap-2 bg-white rounded-xl shadow-sm"
                >
                    <flux:icon.funnel class="size-4"></flux:icon.funnel>
                    Filter
                </flux:button>

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
        </div>

        <div class="mt-6 mb-8">
            <p class="text-sm text-gray-600">
                Menampilkan <span class="font-medium text-gray-900">{{ $posts->count() }}</span>
                dari <span class="font-medium text-gray-900">{{ $posts->total() }}</span> berita
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
