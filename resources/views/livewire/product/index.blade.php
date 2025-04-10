<div wire:poll.200ms class="">


    <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
    <!-- <div wire:poll.2000ms class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> -->

    <div class="justify-center max-w-6xl px-4 py-10 mx-auto">
        <div class="flex gap-5 items-center relative text-gray-800">
            <!-- <div class="bg-white rounded-lg shadow-md"> -->
            <div class="flex">
                <p class="font-bold px-1">Status :</p>
                <select wire:model.live="filterStatus" name="" id=""
                    class="py-0 text-gray-500 inline-block border-transparent hover:border-b-gray-400 outline-0 focus:ring-0 focus:border-transparent bg-transparent ">
                    <option class="hover:bg-white /*hover:bg-gray-400*/ focus:bg-gray-400 outline-0" value="">
                        All
                    </option>
                    @foreach ($companies as $company)
                        <option class="bg-white hover:bg-gray-400 focus:bg-gray-400 outline-0 !important"
                            value="{{ $company->status }}">
                            {{ $company->status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex">
                <p class="font-bold px-1">Category :</p>
                <select wire:model.live="filterCategory" name="" id=""
                    class="py-0 text-gray-500 border-transparent hover:border-b-gray-400 outline-0 focus:ring-0 focus:border-transparent bg-transparent">
                    <option value="">All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:w-72 md:w-56 w- absolute right-0 rounded-full border-1">
                <input wire:model="search" class="w-full rounded-full /*border-none outline-0*/ focus:ring-0"
                    type="text" placeholder="Search">
                <span class="absolute inset-y-0 right-5 flex items-center pl-2">
                    <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewBox="0 0 24 24" class="text-blue-500 w-6 h-6">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </span>
            </div>

        </div>
    </div>

    <div class="justify-center max-w-6xl px-4 py-4 mx-auto lg:py-0">

        <div wire:poll.200ms class="grid grid-cols-1 gap-6 lg:grid-cols-3 md:grid-cols-2">

            @foreach($products as $key => $product)
                <div class="bg-white rounded-lg shadow-md" wire:key="{{ $product->id }}">
                    <a href="#">
                        <img src="{{'/storage/' . $product->image}}" alt="{{ $product->name }}"
                            class="object-cover w-full h-64 rounded-t-lg">
                    </a>
                    <div class="p-5">
                        <div class="flex relative w-full">
                            <button type="button"
                                class="font-medium rounded-lg text-sm px-2.5 py-1 text-center me-2 mb-2 focus:ring-4 focus:outline-none
                                            {{ optional($product->status)->name === 'Terafiliasi' ? 'border-red-700 bg-red-700 text-white' : 'border-green-700 bg-green-700 text-white' }}">
                                {{ $product->status->name }}
                            </button>
                            @if ($product->local_product)
                            <button type="button"
                                class="font-black rounded-lg text-sm px-2.5 py-1 text-center me-2 mb-2 bg-transparent text-yellow-600 border border-yellow-700">
                                Local
                            </button>
                            @endif
                            <p class="absolute right-0 mt-1 text-sm text-gray-500">
                                {{ $product->category->name }}
                            </p>
                        </div>
                        <br>
                        <p href="" class="text-3xl font-bold tracking-tight text-gray-900">
                            {{ $product->name }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->description }}</p>
                        <br>
                        <button type="button"
                            class="w-full text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <a href="{{ $product->source }}">Sumber</a>
                        </button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>