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
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50">
            <nav x-data="{ open: false, userMenu: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo />
                    </a>
                    <div class="hidden items-center gap-7 md:flex">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">Dashboard</a>
                        <a href="{{ route('produk.index') }}" class="text-sm font-semibold {{ request()->routeIs('produk.*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">Produk</a>
                        <a href="{{ route('pemanggilan.index') }}" class="text-sm font-semibold {{ request()->routeIs('pemanggilan.*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">Pemanggilan</a>
                        <a href="{{ route('transaksi.index') }}" class="text-sm font-semibold {{ request()->routeIs('transaksi.*') ? 'text-green-700' : 'text-slate-600 hover:text-green-700' }}">Transaksi</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('keranjang.index') }}" class="rounded-lg p-2 text-slate-700 hover:bg-green-50 hover:text-green-700">
                            <livewire:cart-counter />
                        </a>
                        <div class="relative hidden md:block">
                            <button type="button" x-on:click="userMenu = ! userMenu" class="flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                {{ auth()->user()->name }}
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                            </button>
                            <div x-cloak x-show="userMenu" x-on:click.outside="userMenu = false" class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white py-2 shadow-lg">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-green-50 hover:text-green-700">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-slate-600 hover:bg-green-50 hover:text-green-700">Keluar</button>
                                </form>
                            </div>
                        </div>
                        <button type="button" x-on:click="open = ! open" class="rounded-lg p-2 text-slate-700 hover:bg-slate-100 md:hidden" aria-label="Buka menu">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </button>
                    </div>
                </div>
                <div x-cloak x-show="open" class="border-t border-slate-200 bg-white px-4 py-3 md:hidden">
                    <div class="grid gap-2">
                        <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Dashboard</a>
                        <a href="{{ route('produk.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Produk</a>
                        <a href="{{ route('pemanggilan.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Pemanggilan</a>
                        <a href="{{ route('transaksi.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Transaksi</a>
                        <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-green-50">Profil</a>
                    </div>
                </div>
            </nav>

            <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @include('partials.flash')
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
