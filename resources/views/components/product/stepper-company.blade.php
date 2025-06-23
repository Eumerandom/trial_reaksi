@props(['parents', 'company'])
@php
    $items = collect([$company])->concat($parents);
@endphp
<div class="relative flex flex-col gap-3 py-2">
    @foreach($items as $i => $item)
        @php
            $isAffiliated = $item->status === 'affiliated';
            $border = $isAffiliated ? 'border-red-200 dark:border-red-500' : 'border-green-200 dark:border-green-500';
            $shadow = $isAffiliated ? 'shadow-red-100/30 dark:shadow-red-900/10' : 'shadow-green-100/30 dark:shadow-green-900/10';
            $badge = $isAffiliated ? 'bg-gradient-to-r from-red-400/80 to-red-600/80 text-white shadow-sm' : 'bg-gradient-to-r from-green-400/80 to-green-600/80 text-white shadow-sm';
            $pinColor = $isAffiliated ? 'bg-red-400 border-red-200 dark:bg-red-600 dark:border-red-500' : 'bg-green-400 border-green-200 dark:bg-green-600 dark:border-green-500';
            $productCount = $item->products->count() ?? 0;
            $childrenCount = $item->children->count() ?? 0;
            $totalChild = $item->getTotalChildren();
            $parentName = $item->parent ? $item->parent->name : null;
        @endphp
        <div class="relative flex items-start w-full z-10 min-h-[50px]">
            <div class="absolute left-3 top-1/2 -translate-y-1/2 flex flex-col items-center z-20">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-60 {{ $pinColor }}"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 border {{ $pinColor }}"></span>
                </span>
            </div>
            <div class="absolute left-3 top-1/2 -translate-y-1/2 h-0.5 w-5 bg-gradient-to-r from-gray-300/60 via-gray-400/80 to-transparent dark:from-gray-600 dark:via-gray-700 z-10"></div>
            <div class="ml-8 w-full max-w-md flex items-center gap-2 bg-gradient-to-br from-white/95 via-zinc-100/80 to-zinc-200/60 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 rounded-lg border {{ $border }} shadow {{ $shadow }} p-2 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg group text-xs">
                <div class="flex items-center justify-center w-7 h-7 rounded bg-zinc-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 overflow-hidden">
                    <span class="icon-[icon-park-twotone--building-two] h-4 w-4"></span>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-0.5">
                        <h3 class="font-mono font-bold text-[13px] text-gray-900 dark:text-white tracking-width">{{ $item->name }}</h3>
                        <span class="text-[10px] font-semibold font-mono px-2 py-0.5 rounded-full {{ $badge }} shadow-sm">
                            {{ $item->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi' }}
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 mt-0.5 text-[11px] text-gray-500 dark:text-gray-400 font-mono">
                        <span class="flex items-center gap-1"><flux:icon.chart-bar class="w-3 h-3"></flux:icon.chart-bar> {{ $productCount }} produk</span>
                        @if($childrenCount > 0)
                            <span class="flex items-center gap-1"><flux:icon.briefcase class="w-3 h-3"></flux:icon.briefcase> {{ $childrenCount }} anak perusahaan</span>
                        @endif
                        @if($totalChild > 0)
                            <span class="flex items-center gap-1"><flux:icon.briefcase class="w-3 h-3"></flux:icon.briefcase> {{ $totalChild }} total anak perusahaan</span>
                        @endif
                        @if($parentName)
                            <span class="flex items-center gap-1"><flux:icon.building-2 class="w-3 h-3"></flux:icon.building-2> Induk: {{ $parentName }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
