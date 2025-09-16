# 📦 InvenBar - Sistem Inventaris Barang

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/Bootstrap-5.3-purple?style=for-the-badge&logo=bootstrap" alt="Bootstrap 5">
    <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql" alt="MySQL">
</p>

## 📋 Tentang InvenBar

**InvenBar** adalah sistem manajemen inventaris barang berbasis web yang dibangun menggunakan Laravel 11. Sistem ini dirancang untuk membantu organisasi dalam mengelola data inventaris barang dengan mudah dan efisien.

### ✨ Fitur Utama

-   🔐 **Sistem Autentikasi & Otorisasi**

    -   Login/Register dengan Laravel Breeze
    -   Role-based access control (Admin & Petugas)
    -   Permission management dengan Spatie Laravel Permission

-   📊 **Dashboard Informatif**

    -   Statistik total barang, kategori, dan lokasi
    -   Ringkasan kondisi barang
    -   Tampilan kartu responsif

-   🏷️ **Manajemen Kategori**

    -   CRUD kategori barang
    -   Validasi duplikasi nama kategori
    -   Pengecekan kategori yang masih digunakan

-   📍 **Manajemen Lokasi**

    -   CRUD lokasi penyimpanan
    -   Validasi lokasi unik
    -   Protection untuk lokasi yang masih memiliki barang

-   📦 **Manajemen Barang**

    -   CRUD lengkap untuk data barang
    -   Upload dan manajemen gambar barang
    -   Filter dan pencarian data
    -   Pagination untuk performa optimal

-   👥 **Manajemen User**

    -   CRUD user (khusus admin)
    -   Assign role ke user
    -   Protection untuk mencegah user menghapus dirinya sendiri

-   📄 **Laporan PDF**
    -   Generate laporan inventaris dalam format PDF
    -   Styling profesional dengan DomPDF
    -   Ringkasan statistik lengkap

### 🛠️ Teknologi Yang Digunakan

-   **Backend**: Laravel 11.x
-   **Frontend**: Bootstrap 5.3, Blade Templates
-   **Database**: MySQL 8.0
-   **Authentication**: Laravel Breeze
-   **Permissions**: Spatie Laravel Permission
-   **PDF Generation**: DomPDF (barryvdh/laravel-dompdf)
-   **File Storage**: Laravel Storage with custom disk

## 🚀 Instalasi

### Persyaratan Sistem

-   PHP 8.2 atau lebih tinggi
-   Composer
-   Node.js & NPM
-   MySQL 8.0
-   Web server (Apache/Nginx/Laragon)

### Langkah Instalasi

1. **Clone Repository**

    ```bash
    git clone https://github.com/username/invenbar.git
    cd invenbar
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install && npm run build
    ```

3. **Konfigurasi Environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi Database**
   Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=invenbar
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Migrasi Database & Seeding**

    ```bash
    php artisan migrate:fresh --seed
    ```

6. **Storage Link**

    ```bash
    php artisan storage:link
    ```

7. **Publish DomPDF Config**

    ```bash
    php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
    ```

8. **Jalankan Server**
    ```bash
    php artisan serve
    ```

## 🔑 Default Login

Setelah seeding, gunakan akun berikut untuk login:

**Admin:**

-   Email: `admin@mail.com`
-   Password: `password`

**Petugas:**

-   Email: `petugas@mail.com`
-   Password: `password`

## 📁 Struktur Proyek

```
invenbar/
├── app/
│   ├── Http/Controllers/
│   │   ├── BarangController.php
│   │   ├── DashboardController.php
│   │   ├── KategoriController.php
│   │   ├── LokasiController.php
│   │   └── UserController.php
│   └── Models/
│       ├── Barang.php
│       ├── Kategori.php
│       ├── Lokasi.php
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── barang/
│   │   ├── dashboard/
│   │   ├── kategori/
│   │   ├── lokasi/
│   │   ├── user/
│   │   ├── components/
│   │   └── layouts/
│   └── css/
└── storage/
    └── app/
        └── public/
            └── gambar-barang/
```

## 🔒 Permissions & Roles

### Roles:

-   **Admin**: Akses penuh ke semua fitur
-   **Petugas**: Akses terbatas ke manajemen barang

### Permissions:

-   `view kategori` - Melihat data kategori
-   `manage kategori` - Kelola kategori (CRUD)
-   `view lokasi` - Melihat data lokasi
-   `manage lokasi` - Kelola lokasi (CRUD)
-   `view barang` - Melihat data barang
-   `manage barang` - Kelola barang (CRUD)

## 📱 Fitur Responsive

InvenBar dibangun dengan Bootstrap 5 yang memastikan tampilan yang optimal di berbagai ukuran layar:

-   Desktop (1200px+)
-   Tablet (768px - 1199px)
-   Mobile (< 768px)

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch feature (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

## 📝 License

Proyek ini menggunakan lisensi [MIT License](LICENSE).

## 👨‍💻 Developer

Dikembangkan dengan ❤️ menggunakan Laravel 11

---

<p align="center">
Made with ❤️ by <strong>InvenBar Team</strong>
</p>

---

<p align="center">
Made with ❤️ by <strong>InvenBar Team</strong>
</p>

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
