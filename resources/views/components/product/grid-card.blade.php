<div class="fade-up w-full transform-gpu sm:px-3 md:px-3">
    <div @class([
            'relative flex flex-col gap-1 bg-slate-white dark:bg-black rounded-md border border-zinc-900 transition-all duration-300 hover:shadow-md origin-top hover:scale-[1.03]',
            'hover:shadow-green-500' => $product->status !== 'affiliated',
            'hover:shadow-red-500' => $product->status == 'affiliated',
            'dark:hover:shadow-green-500' => $product->status !== 'affiliated',
            'dark:hover:shadow-red-500' => $product->status == 'affiliated',
        ])>
        <div class="w-46 lg:w-full h-auto aspect-square">
            <span class="absolute top-3 right-3 py-1 px-2 rounded-md bg-{{ $product->status === 'affiliated' ? 'red' : 'green' }}-500">
                @if($product->status === 'affiliated')
                    <flux:icon.check class="size-3"></flux:icon.check>
                @else
                    <flux:icon.x class="size-3"></flux:icon.x>
                @endif
            </span>
            <img src="{{ '/storage/' . $product->image ?? 'https://placehold.co/600x400' }}" alt="{{ $product->name }}" class="object-cover h-full w-full rounded-md">
        </div>
        <div class="p-2 space-y-0.5">
            <div class="flex justify-between items-start">
                <div class="min-h-16 space-y-1">
                    <span class="rounded-lg text-xs bg-gray-200 dark:bg-gray-500/30 py-0.5 px-1.5">{{ $product->category?->name }}</span>
                    <div class="flex flex-row gap-1 items-center text-black/50 dark:text-gray-100/60">
                        <flux:icon.building-2 class="text-light size-3"></flux:icon.building-2>
                        <p class="font-thin text-xs">{{ $product->company?->name }}</p>
                    </div>
                    <h1 class="font-bold text-lg line-clamp-1">{{ $product->name }}</h1>
                </div>
            </div>


            <div class="flex justify-between items-center text-black dark:text-white">
                <button class="flex flex-row items-center gap-2 text-xs cursor-pointer bg-black/10 dark:bg-gray-900/60 py-1 px-2 rounded-md">Selengkapnya <flux:icon.info class="size-3"></flux:icon.info></button>
            </div>
        </div>
    </div>
</div>
