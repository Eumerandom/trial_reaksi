@props(['parents', 'company'])
@php
    $items = collect([$company])->concat($parents);
@endphp
<div class="relative flex flex-col gap-3 py-2">
    @foreach($items as $i => $item)
        @php
            $statusDef = \App\Support\StatusLevel::definition($item->status);
            $statusLabel = $statusDef['label'];
            $statusTone = $statusDef['tone'];
            
            $border = match($statusTone) {
                'red' => 'border-red-200',
                'orange' => 'border-orange-200',
                'amber' => 'border-amber-200',
                'green' => 'border-green-200',
                default => 'border-gray-200',
            };
            $shadow = match($statusTone) {
                'red' => 'shadow-red-100/30',
                'orange' => 'shadow-orange-100/30',
                'amber' => 'shadow-amber-100/30',
                'green' => 'shadow-green-100/30',
                default => 'shadow-gray-100/30',
            };
            $badge = match($statusTone) {
                'red' => 'bg-gradient-to-r from-red-400/80 to-red-600/80 text-white shadow-sm',
                'orange' => 'bg-gradient-to-r from-orange-400/80 to-orange-600/80 text-white shadow-sm',
                'amber' => 'bg-gradient-to-r from-amber-400/80 to-amber-600/80 text-white shadow-sm',
                'green' => 'bg-gradient-to-r from-green-400/80 to-green-600/80 text-white shadow-sm',
                default => 'bg-gradient-to-r from-gray-400/80 to-gray-600/80 text-white shadow-sm',
            };
            $productCount = $item->products->count() ?? 0;
            $childrenCount = $item->children->count() ?? 0;
            $totalChild = $item->getTotalChildren();
            $parentName = $item->parent ? $item->parent->name : null;
        @endphp
        <div class="relative flex w-full z-10 min-h-[50px]">
            <div class="w-full flex items-center gap-2 bg-gradient-to-br from-white/95 via-zinc-100/80 to-zinc-200/60 rounded-lg border {{ $border }} shadow {{ $shadow }} p-2 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg group text-xs">
                <div class="flex-1 p-1">
                    <div class="flex items-center justify-between gap-2 mb-0.5">
                        <h3 class="font-bold text-[13px] text-gray-900 tracking-width">{{ $item->name }}</h3>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $badge }} shadow-sm">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 mt-0.5 text-[11px] text-gray-500">
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
