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
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        @php
            $roleLabel = match (auth()->user()->role ?? 0) {
                2 => 'Admin',
                1 => 'Petugas',
                default => 'Warga',
            };
        @endphp

        <div class="min-h-screen bg-slate-50">
            <nav x-data="{ open: false, userMenu: false }" class="sticky top-0 z-40 border-b border-white/70 bg-white/80 shadow-sm backdrop-blur-sm">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo />
                    </a>

                    <div class="hidden items-center gap-2 md:flex">
                        <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-green-50 hover:text-green-700' }}">Dashboard</a>
                        <a href="{{ route('produk.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('produk.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-green-50 hover:text-green-700' }}">Produk</a>
                        <a href="{{ route('pemanggilan.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('pemanggilan.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-green-50 hover:text-green-700' }}">Pemanggilan</a>
                        <a href="{{ route('transaksi.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('transaksi.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:bg-green-50 hover:text-green-700' }}">Transaksi</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('keranjang.index') }}" class="relative rounded-lg p-2 text-slate-700 hover:bg-green-50 hover:text-green-700" aria-label="Keranjang">
                            <livewire:cart-counter />
                        </a>

                        <div class="relative hidden md:block">
                            <button type="button" x-on:click="userMenu = ! userMenu" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white/80 px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:border-green-200 hover:bg-green-50 hover:shadow-md">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 text-xs font-black text-green-700">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="text-left">
                                    <span class="block leading-4">{{ auth()->user()->name }}</span>
                                    <span class="mt-0.5 inline-flex rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-green-700">{{ $roleLabel }}</span>
                                </span>
                                <svg class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                            </button>
                            <div
                                x-cloak
                                x-show="userMenu"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-2"
                                x-on:click.outside="userMenu = false"
                                class="absolute right-0 mt-2 w-64 rounded-xl border border-slate-200 bg-white p-2 shadow-xl"
                            >
                                <div class="px-3 py-2">
                                    <div class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-green-50 hover:text-green-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm font-semibold text-red-600 hover:bg-red-50">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3-3h-9m9 0-3-3m3 3-3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>

                        <button type="button" x-on:click="open = ! open" class="rounded-lg p-2 text-slate-700 hover:bg-green-50 hover:text-green-700 md:hidden" aria-label="Buka menu">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </button>
                    </div>
                </div>

                <div
                    x-cloak
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="border-t border-slate-200 bg-white/95 px-4 py-3 backdrop-blur-sm md:hidden"
                >
                    <div class="grid gap-2">
                        <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Dashboard</a>
                        <a href="{{ route('produk.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Produk</a>
                        <a href="{{ route('pemanggilan.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Pemanggilan</a>
                        <a href="{{ route('transaksi.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Transaksi</a>
                        <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="page-transition mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @include('partials.flash')
                {{ $slot ?? '' }}
                @yield('content')
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
