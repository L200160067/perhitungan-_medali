# Perhitungan Medali

Aplikasi manajemen pertandingan dan perhitungan medali Taekwondo, dibangun dengan Laravel 12.

## Fitur

- **Manajemen Event** — Membuat dan mengelola event pertandingan
- **Dojang & Kontingen** — Mengelola dojang dan kontingen peserta
- **Peserta** — Data peserta dengan foto profil
- **Kategori Pertandingan** — Pengaturan kategori (prestasi/seni)
- **Pendaftaran** — Proses pendaftaran peserta ke kategori
- **Perhitungan Medali** — Pencatatan medali emas, perak, perunggu
- **RBAC** — Role-Based Access Control (Admin & Official) via Spatie Permission
- **Import Excel** — Import data via file Excel (Maatwebsite)

## Tech Stack

- PHP 8.2+ / Laravel 12
- SQLite (development) / MySQL/PostgreSQL (production)
- Vite + Tailwind CSS
- Laravel Breeze (Authentication)
- Spatie Permission (Authorization)
- Pest (Testing)

## Instalasi

```bash
# Clone repository
git clone <repository-url>
cd perhitungan-_medali

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Storage link (untuk upload foto)
php artisan storage:link

# Build assets
npm run dev     # development
npm run build   # production
```

## Menjalankan Aplikasi

```bash
# Development server
php artisan serve
npm run dev

# Jalankan queue worker (jika menggunakan database queue)
php artisan queue:work
```

## Testing

```bash
php artisan test
```

## Deploy ke Production

```bash
# Environment
APP_ENV=production
APP_DEBUG=false

# Build assets
npm run build

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage
php artisan storage:link

# Migrate
php artisan migrate --force
```

## Default Accounts (Seeder)

| Role    | Email             | Password |
|---------|-------------------|----------|
| Admin   | admin@example.com | password |

## Lisensi

Proyek ini menggunakan lisensi [MIT](LICENSE).
