<x-guest-layout>
    <div class="grid min-h-screen bg-white lg:grid-cols-[1fr_0.95fr]">
        <section class="hidden bg-gradient-to-br from-green-700 via-green-600 to-green-950 px-12 py-10 text-white lg:flex lg:flex-col lg:justify-between">
            <a href="{{ route('landing') }}" class="text-white"><x-application-logo class="text-white" /></a>
            <div class="max-w-xl" data-aos="fade-up">
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-green-100">Akun Warga</p>
                <h1 class="mt-5 text-5xl font-black leading-tight">Mulai kumpulkan poin dari sampah organik.</h1>
                <p class="mt-5 text-lg leading-8 text-green-50">Daftar untuk menjadwalkan pickup, melihat histori transaksi, dan memakai poin sebagai diskon belanja.</p>
            </div>
            <div class="rounded-lg bg-white/10 p-5 text-sm leading-6 text-green-50 backdrop-blur">Satu akun untuk request pickup, belanja produk, dan memantau manfaat sampah organik rumah tangga.</div>
        </section>

        <section class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-10 sm:px-6">
            <div class="w-full max-w-lg" x-data="{
                showPassword: false,
                password: '',
                strength() {
                    if (this.password.length === 0) return { label: 'Belum diisi', width: 'w-0', color: 'bg-slate-200', text: 'text-slate-500' };
                    if (this.password.length < 6) return { label: 'Weak', width: 'w-1/3', color: 'bg-red-500', text: 'text-red-600' };
                    if (this.password.length <= 10 || !/[^A-Za-z0-9]/.test(this.password)) return { label: 'Medium', width: 'w-2/3', color: 'bg-yellow-500', text: 'text-yellow-700' };
                    return { label: 'Strong', width: 'w-full', color: 'bg-green-600', text: 'text-green-700' };
                }
            }">
                <div class="mb-8 text-center lg:text-left">
                    <a href="{{ route('landing') }}" class="inline-flex lg:hidden"><x-application-logo /></a>
                    <h2 class="mt-6 text-3xl font-black text-slate-900">Buat akun NutriCycle</h2>
                    <p class="mt-2 text-sm text-slate-500">Isi data utama agar pickup dan pengiriman lebih cepat.</p>
                </div>

                <div class="card p-6">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="form-label">Nama</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input mt-2 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('name') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="form-label">Nomor HP</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel" class="form-input mt-2 @error('phone') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('phone') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-input mt-2 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('email') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3" required class="form-input mt-2 @error('alamat') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="form-label">Password</label>
                            <div class="relative mt-2">
                                <input id="password" x-model="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" class="form-input pr-11 @error('password') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                                <button type="button" x-on:click="showPassword = ! showPassword" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-slate-500 hover:text-green-700" aria-label="Tampilkan atau sembunyikan password">
                                    <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z" stroke="currentColor" stroke-width="1.8"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke="currentColor" stroke-width="1.8"/></svg>
                                    <svg x-cloak x-show="showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m3 3 18 18M10.58 10.58A2 2 0 0 0 12 14a2 2 0 0 0 1.42-.58M7.2 7.2C4.1 9.1 2.25 12 2.25 12S6 18.75 12 18.75c1.58 0 3-.47 4.22-1.14M9.88 5.5A8.1 8.1 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a17.4 17.4 0 0 1-2.34 3.04" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                </button>
                            </div>
                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full transition-all duration-200" :class="strength().width + ' ' + strength().color"></div>
                            </div>
                            <p class="mt-1 text-xs font-semibold" :class="strength().text" x-text="strength().label"></p>
                            @error('password') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="password_confirmation" :type="showPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" class="form-input mt-2 @error('password_confirmation') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror">
                            @error('password_confirmation') <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-primary w-full">Daftar</button>
                    </form>

                    <p class="mt-5 text-center text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-green-700 hover:text-green-800">Masuk</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
