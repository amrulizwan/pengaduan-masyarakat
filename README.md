# Sistem Pengaduan Masyarakat

##### Proyek ini untuk memenuhi tugas Ujian Akhir Semester Mata Kuliah Web Services

Anggota Kelompok :

> 2201040003 - Amrul Izwan

> 2201040014 - Muhammad Farel Bayu Praditya

> 2201040002 - Muhammad Rezaldi Hidayat

> 2201040012 - Muhammad Adam Zikrillah

## Deskripsi Singkat

Sistem API untuk pengaduan masyarakat berbasis Laravel dengan autentikasi JWT. Sistem ini memungkinkan masyarakat untuk mengirim pengaduan dan admin untuk mengelola serta menanggapi pengaduan tersebut.

## Cara Menjalankan Sistem

### 1. Clone Repository

```bash
git clone https://github.com/amrulizwan/pengaduan-masyarakat
cd pengaduan-masyarakat
```

### 2. Install Dependencies (Composer)

```bash
composer install
composer require tymon/jwt-auth
```

### 3. Setup JWT Authentication

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

### 4. Konfigurasi .env

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database di file `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_pengaduan_masyarakat
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Setup Database

```bash
php artisan migrate
php artisan db:seed
```

### 6. Jalankan Server

```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## Akun Uji Coba

### Admin

- **Email**: admin@example.com
- **Password**: password

### User (Masyarakat)

- **Email**: user@example.com
- **Password**: password

## API Endpoint

Base URL: `http://localhost:8000/api`

- `POST /register` - Registrasi pengguna
- `POST /login` - Login pengguna/admin
- `GET /reports` - Lihat pengaduan (user)
- `POST /reports` - Buat pengaduan baru (user)
- `GET /admin/reports` - Lihat semua pengaduan (admin)
- `PUT /admin/reports/{id}` - Update status pengaduan (admin)

## DOCUMENTATION

[Postman](https://documenter.getpostman.com/view/12581293/2sB34fo2AR) - Postman Documentation

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
