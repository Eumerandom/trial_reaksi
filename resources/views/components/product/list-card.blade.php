<div class="fade-up w-full">
    <div @class([
            'flex flex-col sm:flex-row bg-white dark:bg-black rounded-md border border-gray-400 transition-all duration-300 hover:shadow-md hover:scale-105',
            'hover:shadow-green-500' => $product->status === 'affiliated',
            'hover:shadow-red-500' => $product->status !== 'affiliated',
        ])>

        {{-- Gambar --}}
        <div class="w-full aspect-video sm:w-48 sm:aspect-auto sm:shrink-0 relative">
            <img src="{{ '/storage/' .  $product->image }}" alt="{{ $product->name }}"
                 class="object-cover w-full h-full rounded-t-md sm:rounded-l-md sm:rounded-tr-none"> {{-- Adjust rounding --}}
            <span class="absolute top-2 right-2 py-1 px-2 rounded-md bg-{{ $product->status === 'affiliated' ? 'green' : 'red' }}-500">
                @if($product->status === 'affiliated')
                    <flux:icon.check class="size-4 text-white"></flux:icon.check>
                @else
                    <flux:icon.x class="size-4 text-white"></flux:icon.x>
                @endif
            </span>
        </div>

        {{-- Konten --}}
        <div class="p-4 flex flex-col gap-2 grow">
            <span class="text-xs bg-gray-200 dark:bg-gray-500/30 rounded px-2 py-1 w-fit">{{ $product->category?->name }}</span>
            <h1 class="font-bold text-lg sm:text-xl">{{ $product->name }}</h1>
            <div class="flex items-center gap-2 text-gray-500 text-sm">
                <flux:icon.building-2 />
                {{ $product->company?->name }}
            </div>
            <div>
                <p class="text-gray-600 dark:text-gray-400 line-clamp-2">{{ $product->description }}</p>
            </div>
            <div class="mt-auto pt-2 flex justify-between items-center">
                <button class="bg-black/10 dark:bg-gray-800/70 px-3 py-1 rounded-md text-sm">Selengkapnya</button>
                <flux:icon.info class="text-gray-400" />
            </div>
        </div>

    </div>
</div>
