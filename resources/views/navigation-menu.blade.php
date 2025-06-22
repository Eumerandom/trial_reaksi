<nav id="navbar" x-data="{ open: false }" class="bg-white dark:bg-black border-b border-gray-100 dark:border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="https://ugc.production.linktr.ee/0dfad2d7-f8ce-4ee7-b582-dad733d02cee_PASS-REAKSI-NEW-LOGO-08.jpeg?io=true&size=avatar-v3_0"
                             alt="REAKSI"
                        class="ml-2 object-cover rounded-full max-w-12 h-auto text-gray-800 dark:text-white font-bold text-lg">
                    </a>
                </div>

                <div class="hidden space-x-8 sm:ml-10 sm:flex items-center">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                                class="relative text-gray-800 dark:text-white border-b-2 border-transparent
                                       {{ request()->routeIs('dashboard') ? 'border-zinc-700! dark:border-zinc-300!' : 'hover:border-transparent' }}
                                       after:content-[''] after:absolute after:bottom-[-2px] after:left-0 after:h-[2px] after:w-0
                                       after:bg-zinc-700 dark:after:bg-zinc-300
                                       after:transition-all after:duration-300 hover:after:w-full">
                        {{ __('Beranda') }}
                    </x-nav-link>
                </div>


                <div class="hidden space-x-8 sm:ml-10 sm:flex items-center">
                    <x-nav-link href="{{ route('product.index') }}" :active="request()->routeIs('product.index')"
                                class="relative text-gray-800 dark:text-white border-b-2 border-transparent
                                       {{ request()->routeIs('product.index') ? 'border-zinc-700! dark:border-zinc-300!' : 'hover:border-transparent' }}
                                       after:content-[''] after:absolute after:bottom-[-2px] after:left-0 after:h-[2px] after:w-0
                                       after:bg-zinc-700 dark:after:bg-zinc-300
                                       after:transition-all after:duration-300 hover:after:w-full">
                        {{ __('Produk') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:ml-10 sm:flex items-center">
                    <x-nav-link href="{{route('berita.index')}}" :active="request()->routeIs('berita.index')"
                                class="relative text-gray-800 dark:text-white border-b-2 border-transparent
                                       {{ request()->routeIs('berita.index') ? 'border-zinc-700! dark:border-zinc-300!' : 'hover:border-transparent' }}
                                       after:content-[''] after:absolute after:bottom-[-2px] after:left-0 after:h-[2px] after:w-0
                                       after:bg-zinc-700 dark:after:bg-zinc-300
                                       after:transition-all after:duration-300 hover:after:w-full">
                        {{ __('Berita') }}
                    </x-nav-link>
                </div>


            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <button 
                    x-data 
                    x-on:click="document.documentElement.classList.toggle('dark')"
                    class="relative p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                    aria-label="Toggle dark mode"
                >
                    <span class="icon-[line-md--moon-filled-to-sunny-filled-loop-transition] w-5 h-5 hidden dark:block"></span>
                    
                    <span class="icon-[line-md--sunny-filled-loop-to-moon-filled-transition] w-5 h-5 block dark:hidden"></span>
                </button>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button 
                    x-data 
                    x-on:click="document.documentElement.classList.toggle('dark')"
                    class="relative p-1.5 mr-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200"
                    aria-label="Toggle dark mode"
                >
                    <span class="icon-[line-md--moon-filled-to-sunny-filled-loop-transition] w-4 h-4 hidden dark:block"></span>
                    <span class="icon-[line-md--sunny-filled-loop-to-moon-filled-transition] w-4 h-4 block dark:hidden"></span>
                </button>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-zinc-800 hover:text-white hover:bg-zinc-700 focus:outline-none focus:bg-zinc-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-gray-800 dark:text-white border-l-4 {{request()->routeIs('dashboard') ? 'border-zinc-700! dark:border-zinc-300!' : 'border-transparent'}}">
                {{ __('Beranda') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('product.index') }}" :active="request()->routeIs('product.index')" class="text-gray-800 dark:text-white border-l-4 {{request()->routeIs('product.index') ? 'border-zinc-700! dark:border-zinc-300!' : 'border-transparent'}}">
                {{ __('Produk') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('berita.index') }}" :active="request()->routeIs('berita.index')" class="text-gray-800 dark:text-white border-l-4 {{request()->routeIs('berita.index') ? 'border-zinc-700! dark:border-zinc-300!' : 'border-transparent'}}">
                {{ __('Berita') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
