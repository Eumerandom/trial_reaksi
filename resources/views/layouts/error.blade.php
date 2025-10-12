<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Error') - {{ config('app.name', 'Reksi') }}</title>
        <link rel="icon" type="image/x-icon" href="https://ugc.production.linktr.ee/0dfad2d7-f8ce-4ee7-b582-dad733d02cee_PASS-REAKSI-NEW-LOGO-08.jpeg?io=true&size=avatar-v3_0">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">

        <x-banner />

        <div class="min-h-screen bg-white">
            @livewire('navigation-menu')


            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
            <x-footer />
        </div>

        @stack('modals')
        @fluxScripts
        @livewireScripts
    </body>
</html>
