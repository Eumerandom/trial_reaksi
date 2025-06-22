@props(['parents', 'company'])
@php
    $items = collect([$company])->concat($parents);
@endphp
<ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
    @foreach($items as $item)
        @php
            $isAffiliated = $item->status === 'affiliated';
            $iconBg = $isAffiliated ? 'bg-red-200 dark:bg-red-700' : 'bg-green-200 dark:bg-green-900';
            $iconRing = $isAffiliated ? 'dark:ring-red-600' : 'dark:ring-green-900';
            $iconText = $isAffiliated ? 'text-red-500 dark:text-red-300' : 'text-green-500 dark:text-green-400';
        @endphp
        <li class="ms-8 flex items-center{{ $loop->last ? '' : ' mb-10' }}">
            <span class="absolute flex items-center justify-center w-8 h-8 {{ $iconBg }} rounded-full -start-4 ring-4 ring-white {{ $iconRing }}">
                <flux:icon.building class="w-3.5 h-3.5 {{ $iconText }}"></flux:icon.building>
            </span>
            <div class="space-y-2">
                <h3 class="font-medium leading-tight">{{ $item->name }}</h3>
                <p class="text-sm">{{ $item->status === 'affiliated' ? 'Terafiliasi' : 'Tidak Terafiliasi' }}</p>
            </div>
        </li>
    @endforeach
</ol>