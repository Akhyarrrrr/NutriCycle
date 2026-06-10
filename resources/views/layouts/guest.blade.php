<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'NutriCycle') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        @isset($slot)
            <div class="flex min-h-screen flex-col items-center justify-center bg-slate-50 px-4 py-10">
                <a href="{{ route('landing') }}" class="mb-8">
                    <x-application-logo />
                </a>
                <div class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                    {{ $slot }}
                </div>
            </div>
        @else
            @yield('content')
        @endisset
        @stack('scripts')
    </body>
</html>
