<div class="fade-up w-full">
    <div class="relative flex flex-col gap-8 bg-slate-white dark:bg-gray-950 rounded-md border border-gray-400 transition-all duration-300 hover:shadow-{{ $product->status === 'affiliated' ? 'green' : 'red' }}-500 hover:shadow-md hover:border-2 hover:rotate-[0.05rad] hover:scale-105">
        <div class="w-48">
            <span class="absolute top-5 right-5 py-1 px-2 rounded-md bg-{{ $product->status === 'affiliated' ? 'red' : 'green' }}-500">
                @if($product->status === 'affiliated')
                    <flux:icon.check class="size-4"></flux:icon.check>
                @else
                    <flux:icon.x class="size-4"></flux:icon.x>
                @endif
            </span>
            <img src="{{ $product->image ?? 'https://placehold.co/600x400' }}" alt="{{ $product->name }}" class="object-cover h-full w-full rounded-l-md">
        </div>
        <div class="flex-1 p-4 space-y-2">
            <div class="flex justify-between items-start">
                <div>
                    <span class="rounded-lg text-light bg-gray-200 dark:bg-gray-500/30 py-1 px-2">{{ $product->category?->name }}</span>
                    <h1 class="font-bold text-2xl mt-2">{{ $product->name }}</h1>
                </div>
            </div>
            <div class="flex flex-row gap-2 items-center text-black/50 dark:text-gray-100/60">
                <flux:icon.building-2 class="text-light"></flux:icon.building-2>
                <p class="font-thin">{{ $product->company?->name }}</p>
            </div>
            <p class="text-gray-600 dark:text-gray-400 line-clamp-2">{{ $product->description }}</p>
            <div class="flex justify-between items-center text-black dark:text-white">
                <button class="flex flex-row gap-4 cursor-pointer bg-black/10 dark:bg-gray-900/60 p-2 rounded-md">Selengkapnya                <flux:icon.info></flux:icon.info></button>
            </div>
        </div>
    </div>
</div>
