# Database Configuration

## Overview
Proyek ini menggunakan **MySQL/MariaDB** dengan PDO (PHP Data Objects) untuk koneksi database.

## Setup Instructions

### 1. Persiapan XAMPP
- Pastikan XAMPP Control Panel berjalan dengan MySQL/MariaDB aktif
- Port default: `3306`

### 2. Membuat Database
Pilih salah satu metode:

#### Method A: Menggunakan Python Script (Recommended)
```bash
cd database
python init_db.py
```
Script ini akan:
- Membuat database `newrpl` (jika belum ada)
- Membuat tabel `umkm`
- Membuat tabel `admin_users`

#### Method B: Menggunakan phpMyAdmin
1. Buka `http://localhost/phpmyadmin`
2. Login dengan user `root` (tanpa password)
3. Import file `umkm_desa.sql`:
   - Klik menu "Import"
   - Pilih file `umkm_desa.sql`
   - Jalankan

#### Method C: Menggunakan MySQL Command Line
```bash
mysql -u root -p < umkm_desa.sql
```

### 3. Konfigurasi Koneksi (opsional)
Edit file `connection.php` jika menggunakan kredensial berbeda:
```php
$db_host = 'localhost';    // Host MySQL
$db_user = 'root';         // Username MySQL
$db_pass = '';             // Password (kosong default)
$db_name = 'newrpl';       // Database name
$db_port = 3306;           // Port MySQL
```

### 4. Menggunakan Koneksi di PHP
```php
<?php
require_once 'database/connection.php';

// Contoh query
$stmt = $pdo->prepare("SELECT * FROM umkm WHERE status = ?");
$stmt->execute(['pending']);
$results = $stmt->fetchAll();
```

## Database Schema

### Table: umkm
| Column | Type | Deskripsi |
|--------|------|-----------|
| id | INT | Primary Key, Auto Increment |
| nama_usaha | VARCHAR(255) | Nama unit usaha |
| nama_pemilik | VARCHAR(255) | Nama pemilik UMKM |
| nik | VARCHAR(20) | NIK pemilik |
| telp | VARCHAR(20) | Nomor telepon |
| email | VARCHAR(255) | Email |
| whatsapp | VARCHAR(20) | Nomor WhatsApp |
| kategori_usaha | VARCHAR(100) | Kategori bisnis |
| skala_usaha | VARCHAR(100) | Skala usaha |
| bentuk_usaha | VARCHAR(100) | Bentuk usaha |
| modal_usaha | VARCHAR(100) | Modal awal |
| target_pasaran | VARCHAR(255) | Target pasar |
| tahun_berdiri | YEAR | Tahun berdiri |
| alamat_usaha | TEXT | Alamat lengkap |
| deskripsi_usaha | TEXT | Deskripsi usaha |
| status | ENUM | pending, approved, rejected |
| alasan_penolakan | TEXT | Alasan jika ditolak |
| ktp_path | VARCHAR(255) | Path file KTP |
| nib_path | VARCHAR(255) | Path file NIB |
| lokasi_path | VARCHAR(255) | Path foto lokasi |
| created_at | TIMESTAMP | Waktu dibuat |

### Table: admin_users
| Column | Type | Deskripsi |
|--------|------|-----------|
| id | INT | Primary Key, Auto Increment |
| username | VARCHAR(100) | Username unik |
| password_hash | VARCHAR(255) | Hash password (bcrypt recommended) |
| role | ENUM | admin atau supervisor |
| created_at | TIMESTAMP | Waktu dibuat |

## Requirements

### PHP Extensions
- `php_pdo.dll` (included in PHP)
- `php_pdo_mysql.dll` (untuk MySQL/MariaDB)

### Python (optional, hanya jika menggunakan init script)
```bash
pip install mysql-connector-python
```

## Troubleshooting

### Error: "SQLSTATE[HY000]: General error"
- Pastikan MySQL/MariaDB service sudah berjalan
- Cek konfigurasi host, user, password di `connection.php`

### Error: "No database selected"
- Pastikan database `newrpl` sudah dibuat
- Jalankan `python init_db.py` lagi

### Error: "Connection refused"
- Pastikan port 3306 tidak terblokir
- Cek di XAMPP Control Panel apakah MySQL aktif

## Migration dari SQLite
Jika sebelumnya menggunakan SQLite:
1. Backup data SQLite (jika ada)
2. Jalankan `init_db.py` untuk membuat MySQL database
3. Update kode PHP untuk menggunakan koneksi baru (sudah otomatis di `connection.php`)
4. Hapus file `db.sqlite` jika tidak diperlukan lagi
