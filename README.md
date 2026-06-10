# NutriCycle

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
3. Isi kredensial database MySQL, Midtrans sandbox, dan Cloudinary di `.env`.
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

## Railway Deploy

1. Buat project Railway dan hubungkan repository.
2. Tambahkan MySQL-compatible database, atau gunakan PlanetScale dengan kredensial MySQL.
3. Set environment variable sesuai daftar di bawah.
4. Gunakan build command:
   ```bash
   composer install --no-dev --optimize-autoloader && npm install && npm run build
   ```
5. Gunakan start command:
   ```bash
   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}
   ```
6. Jalankan seeder sekali dari shell Railway jika dibutuhkan:
   ```bash
   php artisan db:seed --force
   ```

## Environment Variables

```env
APP_NAME=NutriCycle
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false

CLOUDINARY_URL=
CLOUDINARY_FOLDER=nutricycle/produk
```

## Notes

- Migrasi tidak memakai foreign key constraint agar kompatibel dengan PlanetScale.
- Adapter `cloudinary-labs/cloudinary-laravel` belum kompatibel dengan Laravel 13 saat scaffold ini dibuat, sehingga upload memakai SDK resmi `cloudinary/cloudinary_php` melalui service kecil `App\Support\CloudinaryStorage`.
