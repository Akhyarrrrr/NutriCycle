<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'NutriCycle') }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        @isset($slot)
            @if (request()->routeIs('login') || request()->routeIs('register'))
                {{ $slot }}
            @else
                <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-green-50 via-white to-slate-100 px-4 py-10">
                    <a href="{{ route('landing') }}" class="mb-8">
                        <x-application-logo />
                    </a>
                    <div class="card w-full max-w-md p-6 shadow-sm">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        @else
            @yield('content')
        @endisset

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            window.addEventListener('load', function () {
                if (window.AOS) {
                    AOS.init({ duration: 600, once: true });
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
