<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Admin NutriCycle' }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        @php
            $links = [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'M3.75 12h16.5M12 3.75v16.5M4.5 19.5h15a.75.75 0 0 0 .75-.75v-15A.75.75 0 0 0 19.5 3h-15a.75.75 0 0 0-.75.75v15c0 .414.336.75.75.75Z'],
                ['label' => 'Produk', 'route' => 'admin.produk.index', 'active' => 'admin.produk.*', 'icon' => 'M20.25 7.5 12 2.25 3.75 7.5m16.5 0L12 12.75m8.25-5.25v9L12 21.75m0-9L3.75 7.5m8.25 5.25v9m0-9-8.25-5.25v9L12 21.75'],
                ['label' => 'Pemanggilan', 'route' => 'admin.pemanggilan.index', 'active' => 'admin.pemanggilan.*', 'icon' => 'M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM3.75 6h11.5l3 4.5h2v5.25H18M3.75 6v9.75h3'],
                ['label' => 'Transaksi', 'route' => 'admin.transaksi.index', 'active' => 'admin.transaksi.*', 'icon' => 'M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h10.5'],
                ['label' => 'Users', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0'],
            ];
        @endphp

        <div x-data="{ sidebar: false }" class="min-h-screen bg-slate-50 lg:flex">
            <div x-cloak x-show="sidebar" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50 lg:hidden" x-on:click="sidebar = false"></div>

            <aside
                class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-green-950 text-white shadow-2xl transition-transform duration-200 lg:translate-x-0"
                :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <div class="flex h-20 items-center justify-between px-5">
                    <a href="{{ route('admin.dashboard') }}" class="text-white"><x-application-logo class="text-white" /></a>
                    <button type="button" class="rounded-lg p-2 text-white/70 hover:bg-white/10 hover:text-white lg:hidden" x-on:click="sidebar = false" aria-label="Tutup menu">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </div>

                <nav class="grid gap-1 px-3">
                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}" class="group flex items-center gap-3 rounded-xl border-l-4 px-4 py-3 text-sm font-semibold {{ request()->routeIs($link['active']) ? 'border-green-300 bg-white/12 text-white' : 'border-transparent text-green-50/75 hover:border-green-400 hover:bg-white/10 hover:text-white' }}">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="{{ $link['icon'] }}" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="mt-auto border-t border-white/10 p-4">
                    <div class="rounded-xl bg-white/10 p-3">
                        <div class="text-sm font-bold">{{ auth()->user()->name }}</div>
                        <div class="mt-1 text-xs text-green-50/70">{{ auth()->user()->email }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-sm font-bold text-red-200 hover:bg-red-500/10 hover:text-red-100">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3-3h-9m9 0-3-3m3 3-3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <main class="w-full lg:pl-72">
                <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/80 px-4 py-3 shadow-sm backdrop-blur-sm lg:hidden">
                    <button type="button" x-on:click="sidebar = true" class="rounded-lg p-2 text-slate-700 hover:bg-green-50 hover:text-green-700" aria-label="Buka menu">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </header>
                <div class="page-transition mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    @include('partials.flash')
                    @yield('content')
                </div>
            </main>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            window.addEventListener('load', function () {
                if (window.AOS) {
                    AOS.init({ duration: 600, once: true });
                }
            });
        </script>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
