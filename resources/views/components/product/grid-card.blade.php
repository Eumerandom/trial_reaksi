
<div class="fade-up w-full transform-gpu sm:px-3 md:px-3" wire:click="viewDetail('{{$product->slug}}')">
    <div @class([
            'relative flex flex-col gap-1 bg-white dark:bg-black dark:shadow-md dark:shadow-zinc-900 rounded-lg transition-all duration-300 shadow-lg hover:shadow-md origin-top hover:scale-[1.03]',
            /*$product->status !== 'affiliated' ? 'hover:shadow-green-500' : 'hover:shadow-red-500',
            $product->status !== 'affiliated' ? 'dark:hover:shadow-green-500' : 'dark:hover:shadow-red-500'*/
        ])>
        <div class="w-46 lg:w-full h-auto aspect-square">
            <span class="absolute top-4 right-4 py-0.5 px-2 rounded-md bg-{{ $product->status === 'affiliated' ? 'red' : 'green' }}-500">
                @if($product->status === 'affiliated')
                    <!-- <flux:icon.check class="size-3"></flux:icon.check> -->
                    <p class="text-xs text-white">Terafiliasi</p>
                @else
                    <!-- <flux:icon.x class="size-3"></flux:icon.x> -->
                    <p class="text-xs text-white">Tidak Terafiliasi</p>
                @endif
            </span>
            <img src="{{ '/storage/' . $product->image ?? 'https://placehold.co/600x400' }}" alt="{{ $product->name }}" class="object-cover h-full w-full rounded-md">
        </div>
        <div class="p-4 space-y-0.5">
            <div class="mb-4 flex justify-between items-start">
                <div class="min-h-16 space-y-1">
                    <span class="rounded-lg text-xs bg-gray-200 dark:bg-gray-500/30 py-0.5 px-1.5">{{ $product->category?->name }}</span>
                    <h1 class="font-bold text-lg line-clamp-1">{{ $product->name }}</h1>
                    <div class="flex flex-row gap-1 items-center text-black/50 dark:text-gray-100/60">
                        <flux:icon.building-2 class="text-light size-3"></flux:icon.building-2>
                        <p class="font-thin text-xs">{{ $product->company?->name }}</p>
                    </div>
                </div>
            </div>


            <div class="flex /*justify-end*/ items-center w-full text-black dark:text-white">
                <button class="flex flex-row justify-center items-center w-full gap-2 text-xs cursor-pointer bg-black/10 dark:bg-gray-900/60 p-2 rounded-md">Selengkapnya <flux:icon.info class="size-3"></flux:icon.info></button>
            </div>
        </div>
    </div>
</div>
