<x-guest-layout>
    <div class="grid min-h-screen bg-white lg:grid-cols-[1fr_0.95fr]">
        <section class="hidden bg-gradient-to-br from-green-700 via-green-600 to-green-950 px-12 py-10 text-white lg:flex lg:flex-col lg:justify-between">
            <a href="{{ route('landing') }}" class="text-white"><x-application-logo class="text-white" /></a>
            <div class="max-w-xl" data-aos="fade-up">
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-green-100">NutriCycle</p>
                <h1 class="mt-5 text-5xl font-black leading-tight">Ubah sampah organik jadi nilai baru.</h1>
                <p class="mt-5 text-lg leading-8 text-green-50">Masuk untuk memanggil petugas, mengelola poin, dan membeli pakan daur ulang yang siap pakai.</p>
            </div>
            <div class="grid grid-cols-3 gap-3 text-sm text-green-50">
                <div class="rounded-lg bg-white/10 p-4 backdrop-blur"><span class="block text-2xl font-black">30%</span>maks diskon poin</div>
                <div class="rounded-lg bg-white/10 p-4 backdrop-blur"><span class="block text-2xl font-black">1:10</span>poin ke rupiah</div>
                <div class="rounded-lg bg-white/10 p-4 backdrop-blur"><span class="block text-2xl font-black">3</span>alur mudah</div>
            </div>
        </section>

        <section class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-10 sm:px-6">
            <div class="w-full max-w-md" x-data="{ showPassword: false }">
                <div class="mb-8 text-center lg:text-left">
                    <a href="{{ route('landing') }}" class="inline-flex lg:hidden"><x-application-logo /></a>
                    <h2 class="mt-6 text-3xl font-black text-slate-900">Masuk ke akun</h2>
                    <p class="mt-2 text-sm text-slate-500">Akses dashboard NutriCycle Anda.</p>
                </div>

                <div class="card p-6">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input mt-2 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('email') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="form-label">Password</label>
                            <div class="relative mt-2">
                                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" class="form-input pr-11 @error('password') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                                <button type="button" x-on:click="showPassword = ! showPassword" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-500 hover:text-green-700" aria-label="Tampilkan atau sembunyikan password">
                                    <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" stroke="currentColor" stroke-width="1.8"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke="currentColor" stroke-width="1.8"/></svg>
                                    <svg x-cloak x-show="showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m3 3 18 18M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58M7.2 7.2C4.1 9.1 2.25 12 2.25 12S6 18.75 12 18.75c1.58 0 3-.47 4.22-1.14M9.88 5.5A8.1 8.1 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a17.4 17.4 0 0 1-2.34 3.04" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-green-600 shadow-sm focus:ring-green-600" name="remember">
                                <span class="ms-2 text-sm text-slate-600">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-green-700 hover:text-green-800" href="{{ route('password.request') }}">Lupa password?</a>
                            @endif
                        </div>

                        <button type="submit" class="btn-primary w-full">
                            Masuk
                        </button>
                    </form>

                    <p class="mt-5 text-center text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold text-green-700 hover:text-green-800">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
