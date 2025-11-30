@php
    $statusTone = $product->status_tone ?? 'gray';
    $statusLabel = $product->status_label ?? 'Belum Dikategorikan';
    $badgeClasses = match($statusTone) {
        'red' => 'bg-red-500 text-white',
        'orange' => 'bg-orange-500 text-white',
        'amber' => 'bg-amber-500 text-white',
        'green' => 'bg-green-500 text-white',
        default => 'bg-gray-500 text-white',
    };
@endphp
<a
    href="{{ route('product.show', ['slug' => $product->slug]) }}"
    class="fade-up group block w-full transform-gpu sm:px-3 md:px-3"
    aria-label="Lihat detail {{ $product->name }}">
    <div @class([
        'relative overflow-hidden rounded-xl bg-white/90 ring-1 ring-black/5 shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1',
    ])>
        <div class="relative w-full aspect-square">
            <span class="absolute z-10 top-3 left-3 px-2 py-1 rounded-md text-[10px] font-medium tracking-wide {{ $badgeClasses }}">
                {{ $statusLabel }}
            </span>

            @if(isset($product->local_product))
                <span class="absolute z-10 top-3 right-3 px-2 py-1 rounded-md text-[10px] font-medium tracking-wide bg-black/60 text-white backdrop-blur">
                    {{ $product->local_product ? 'Produk Lokal' : 'Produk Import' }}
                </span>
            @endif

            <img
                src="{{ $product->image ?? 'https://placehold.co/600x600' }}"
                alt="{{ $product->name }}"
                loading="lazy"
                decoding="async"
                class="h-full w-full object-cover transition-transform duration-300" />

            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
        </div>

        <div class="p-4">
            <div class="mb-3 flex items-center gap-2">
                @if($product->category?->name)
                    <span class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-2 py-0.5 text-[11px]">
                        {{ $product->category?->name }}
                    </span>
                @endif
            </div>

            <h3 class="font-semibold text-base md:text-lg text-gray-900 line-clamp-2">
                {{ $product->name }}
            </h3>

            <div class="mt-1 flex items-center gap-1.5 text-gray-500">
                <flux:icon.building-2 class="size-3.5"></flux:icon.building-2>
                <p class="text-xs line-clamp-1">{{ $product->company?->name }}</p>
            </div>

            <div class="mt-4">
                <div class="flex items-center w-full text-gray-900">
                    <span class="flex w-full items-center justify-center gap-2 rounded-md bg-black/5 px-3 py-2 text-xs font-medium transition-colors group-hover:bg-black/10" aria-hidden="true">
                        Selengkapnya
                        <flux:icon.chevron-right class="size-3"></flux:icon.chevron-right>
                    </span>
                </div>
            </div>
        </div>
    </div>
</a>
