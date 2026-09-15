# Laravel Penggajian - Versi Ringkas Ujikom

Aplikasi penggajian hasil migrasi dari PHP Native ke Laravel.

## Fitur
- Login admin
- Lupa password admin
- CRUD data karyawan
- Pilih periode saat menambah data (tanggal otomatis 25 sampai 25 bulan berikutnya)
- Perhitungan gaji
- CAPTCHA saat tambah data
- Slip gaji PDF
- Kirim ringkasan gaji melalui WhatsApp
- Validasi, CSRF, middleware auth, Eloquent, dan Blade

## Instalasi
Pastikan PHP 8.3+, Composer, MySQL, dan database `db_penggajian` sudah tersedia.

Tabel `admins` dan `karyawan` dapat memakai tabel dari project PHP Native sehingga data lama tetap aman.

Jalankan di folder project:

```bash
composer install
php artisan migrate --seed
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Login default
- Email: `admin@gmail.com`
- Password: `admin123`

## Struktur utama

```text
app/
├── Http/Controllers/
│   ├── AuthController.php
│   └── KaryawanController.php
├── Http/Requests/
│   ├── StoreKaryawanRequest.php
│   └── UpdateKaryawanRequest.php
└── Models/
    ├── Admin.php
    └── Karyawan.php

resources/views/
├── auth/
├── karyawan/
└── layouts/

public/
├── css/penggajian.css
└── js/

routes/web.php
database/migrations/
database/seeders/DatabaseSeeder.php
```

Logic perhitungan gaji, CAPTCHA, dan WhatsApp dibuat langsung di `KaryawanController.php` agar project lebih ringkas dan mudah dijelaskan saat Ujikom.
