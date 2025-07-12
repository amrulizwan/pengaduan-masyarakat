# Pengaduan Masyarakat API

Sistem API untuk pengaduan masyarakat menggunakan Laravel dengan autentikasi JWT.

## Fitur

### User (Masyarakat)

- ✅ Register & Login
- ✅ Kirim pengaduan
- ✅ Lihat daftar pengaduan miliknya
- ✅ Cek status & detail pengaduan

### Admin

- ✅ Login
- ✅ Lihat semua pengaduan
- ✅ Ubah status pengaduan (menunggu, diproses, selesai, ditolak)
- ✅ Tambah catatan/tanggapan ke pengaduan

## Setup

1. Install dependencies:

```bash
composer install
```

2. Copy environment file:

```bash
cp .env.example .env
```

3. Generate application key:

```bash
php artisan key:generate
```

4. Generate JWT secret:

```bash
php artisan jwt:secret
```

5. Configure database in `.env`
6. Run migrations:

```bash
php artisan migrate
```

7. Seed database:

```bash
php artisan db:seed
```

## API Endpoints

### Authentication

#### Register User

```
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login

```
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Get Profile

```
GET /api/me
Authorization: Bearer {token}
```

#### Logout

```
POST /api/logout
Authorization: Bearer {token}
```

#### Refresh Token

```
POST /api/refresh
Authorization: Bearer {token}
```

### Update Profile

#### Update Profile (PUT)

```
PUT /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Update Profile (PATCH)

```
PATCH /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com"
}
```

### Reports (User)

#### Get User Reports

```
GET /api/reports?status=menunggu&page=1
Authorization: Bearer {token}
```

#### Create Report

```
POST /api/reports
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Kerusakan Jalan",
    "description": "Jalan berlubang di depan rumah nomor 123"
}
```

#### Get Report Detail

```
GET /api/reports/{id}
Authorization: Bearer {token}
```

#### Update Report

```
PUT /api/reports/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Kerusakan Jalan",
    "description": "Jalan berlubang di depan rumah nomor 123"
}
```

#### Update Report (PATCH)

```
PATCH /api/reports/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Kerusakan Jalan"
}
```

#### Delete Report

```
DELETE /api/reports/{id}
Authorization: Bearer {token}
```

### Admin

#### Get All Reports

```
GET /api/admin/reports?status=menunggu&search=jalan&page=1
Authorization: Bearer {admin_token}
```

#### Get Report Detail (Admin)

```
GET /api/admin/reports/{id}
Authorization: Bearer {admin_token}
```

#### Update Report Status

```
PUT /api/admin/reports/{id}
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "status": "diproses",
    "response_note": "Pengaduan sedang ditinjau oleh tim teknis"
}
```

#### Get Statistics

```
GET /api/admin/statistics
Authorization: Bearer {admin_token}
```

## Status Pengaduan

- `menunggu` - Pengaduan baru yang belum ditindaklanjuti
- `diproses` - Pengaduan sedang dalam proses penanganan
- `selesai` - Pengaduan telah selesai ditangani
- `ditolak` - Pengaduan ditolak dengan alasan tertentu

## Default Users

Setelah menjalankan seeder:

### Admin

- Email: admin@example.com
- Password: password

### User

- Email: user@example.com
- Password: password

## Response Format

### Success Response

```json
{
  "success": true,
  "message": "Success message",
  "data": {}
}
```

### Error Response

```json
{
  "success": false,
  "message": "Error message",
  "errors": {}
}
```

## Database Schema

### Users Table

- id
- name
- email
- password
- role (admin/user)
- timestamps

### Reports Table

- id
- user_id (foreign key)
- title
- description
- status (menunggu/diproses/selesai/ditolak)
- response_note
- timestamps

### Response Notes Table

- id
- report_id (foreign key)
- admin_id (foreign key)
- note
- previous_status
- new_status
- timestamps
