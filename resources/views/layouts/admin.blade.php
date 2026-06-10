<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Admin NutriCycle' }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50 lg:flex">
            <aside class="border-b border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex h-16 items-center justify-between px-5 lg:h-20">
                    <a href="{{ route('admin.dashboard') }}"><x-application-logo /></a>
                </div>
                <nav class="grid gap-1 px-3 pb-4 lg:pb-0">
                    @php
                        $links = [
                            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
                            ['label' => 'Produk', 'route' => 'admin.produk.index', 'active' => 'admin.produk.*'],
                            ['label' => 'Pemanggilan', 'route' => 'admin.pemanggilan.index', 'active' => 'admin.pemanggilan.*'],
                            ['label' => 'Transaksi', 'route' => 'admin.transaksi.index', 'active' => 'admin.transaksi.*'],
                            ['label' => 'Users', 'route' => 'admin.users.index', 'active' => 'admin.users.*'],
                        ];
                    @endphp
                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}" class="rounded-lg px-4 py-3 text-sm font-semibold {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">{{ $link['label'] }}</a>
                    @endforeach
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full rounded-lg px-4 py-3 text-left text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900">Keluar</button>
                    </form>
                </nav>
            </aside>
            <main class="w-full lg:pl-72">
                <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    @include('partials.flash')
                    @yield('content')
                </div>
            </main>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
