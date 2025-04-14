<div class="fade-up w-full">
    <div class="flex flex-row bg-white dark:bg-gray-950 rounded-md border border-gray-400 overflow-hidden transition-all duration-300 hover:shadow-md">

        {{-- Gambar --}}
        <div class="w-48 h-full relative">
            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                 class="object-cover w-full h-full">
            <span class="absolute top-2 right-2 py-1 px-2 rounded-md bg-{{ $product->status === 'affiliated' ? 'green' : 'red' }}-500">
                @if($product->status === 'affiliated')
                    <flux:icon.check class="size-4 text-white"></flux:icon.check>
                @else
                    <flux:icon.x class="size-4 text-white"></flux:icon.x>
                @endif
            </span>
        </div>

        {{-- Konten --}}
        <div class="p-4 flex flex-col gap-2">
            <span class="text-xs bg-gray-200 dark:bg-gray-500/30 rounded px-2 py-1 w-fit">{{ $product->category?->name }}</span>
            <h1 class="font-bold text-lg">{{ $product->name }}</h1>
            <div class="flex items-center gap-2 text-gray-500 text-sm">
                <flux:icon.building-2 />
                {{ $product->company?->name }}
            </div>
            <div class="mt-2 flex justify-between items-center">
                <button class="bg-black/10 dark:bg-gray-800/70 px-3 py-1 rounded-md text-sm">Selengkapnya</button>
                <flux:icon.info class="text-gray-400" />
            </div>
        </div>

    </div>
</div>
