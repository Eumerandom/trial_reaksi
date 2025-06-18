@extends('layouts.error')

@section('title', 'Forbidden')

@section('content')
    <div class="min-h-[50vh] flex items-center justify-center text-white">
        <section class="flex flex-col md:flex-row items-center gap-6 md:gap-10 px-6">
            <h1 class="text-6xl md:text-8xl font-bold text-red-500 font-mono border-r-4 border-zinc-700 pr-6">
                403
            </h1>
            <div class="space-y-4 text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-semibold font-mono">Forbidden</h2>
                <p class="text-zinc-400 max-w-md">
                    You do not have permission to access this page.
                </p>
                <div class="items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 px-4 py-2 border border-zinc-700 rounded-md hover:bg-zinc-800 transition">
                        <flux:icon.circle-alert class="w-5 h-5 animate-pulse text-red-500" />
                        <span>Go to Homepage</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
