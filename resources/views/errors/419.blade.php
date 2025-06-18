@extends('layouts.error')

@section('title', 'Session Expired')

@section('content')
    <div class="min-h-[50vh] flex items-center justify-center text-white">
        <section class="flex flex-col md:flex-row items-center gap-6 md:gap-10 px-6">
            <h1 class="text-6xl md:text-8xl font-bold text-red-500 font-mono border-r-4 border-zinc-700 pr-6">
                419
            </h1>
            <div class="space-y-4 text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-semibold font-mono">Session Expired</h2>
                <p class="text-zinc-400 max-w-md">
                    The page has expired due to inactivity.
                </p>
            </div>
        </section>
    </div>
@endsection
