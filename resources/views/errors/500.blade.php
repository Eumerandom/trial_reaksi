@extends('layouts.error')

@section('title', 'Server Error')

@section('content')
    <div class="min-h-[50vh] flex items-center justify-center">
        <section class="flex flex-col md:flex-row items-center gap-6 md:gap-10 px-6">
            <div class="relative flex items-center">
                <h1 class="text-6xl md:text-8xl font-bold text-red-500 font-mono border-r-4 border-zinc-300 pr-6">
                    500
                </h1>
                <span class="absolute top-2 left-0 flex h-4 w-4">
                     <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                     <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                </span>
            </div>
            <div class="space-y-4 text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-semibold font-mono text-zinc-800">Server Error</h2>
                <p class="text-zinc-600 max-w-md">
                    You do not have permission to access this page.
                </p>
                <div>
                    <button onclick="window.location.reload()" class="flex items-center gap-2 px-4 py-2 border border-zinc-300 rounded-md hover:bg-zinc-100 transition text-zinc-700">
                        <flux:icon.refresh-ccw class="w-5 h-5 animate-spin" />
                        <span>Reload Page</span>
                    </button>
                </div>
            </div>
        </section>
    </div>
@endsection
