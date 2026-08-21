# NutriCycle - Ubah sampah beranak jadi Pakan ternak

NutriCycle adalah aplikasi Laravel untuk layanan pickup sampah organik dan penjualan pakan ternak hasil daur ulang.

## Local Setup

1. Install dependency PHP dan Node.
   ```bash
   composer install
   npm install
   ```
2. Buat file env dan key aplikasi.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Isi kredensial database, Midtrans sandbox, dan Cloudinary di `.env`.
4. Jalankan migrasi dan seeder.
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Jalankan development server.
   ```bash
   php artisan serve
   npm run dev
   ```

## Seeder Accounts

- Admin: `admin@nutricycle.com` / `password`
- Petugas: `petugas@nutricycle.com` / `password`
- User: `rani@example.com` / `password`
- User: `bima@example.com` / `password`

## Deploy Vercel + Aiven Free

1. Buat service **Aiven for PostgreSQL Free**, lalu simpan host, port, database, username, dan password-nya.
2. Inisialisasi database baru satu kali dari image aplikasi:
   ```bash
   php artisan migrate:fresh --seed --force
   ```
3. Di Vercel, isi environment **Preview** dan **Production**: `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY`, `APP_URL`, `DB_CONNECTION=pgsql`, seluruh `DB_*`, dan `DB_SSLMODE=require`.
4. Deploy Preview, lalu cek `/up`, `/`, dan `/login` sebelum mempromosikannya ke Production.

Container menyimpan cache Laravel di `/tmp`, sehingga tidak bergantung pada `bootstrap/cache` yang dapat tertimpa pada runtime Vercel. Migration dan seeding sengaja tidak dijalankan saat cold start; jalankan secara terkontrol setiap ada perubahan schema.

## Environment Variables

```env
APP_NAME=NutriCycle
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=
ASSET_URL=

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false

CLOUDINARY_URL=
CLOUDINARY_FOLDER=nutricycle/produk
DB_SSLMODE=require
```

## Notes

- Migrasi tidak memakai foreign key constraint agar kompatibel dengan PlanetScale.
- Adapter `cloudinary-labs/cloudinary-laravel` belum kompatibel dengan Laravel 13 saat scaffold ini dibuat, sehingga upload memakai SDK resmi `cloudinary/cloudinary_php` melalui service kecil `App\Support\CloudinaryStorage`.
