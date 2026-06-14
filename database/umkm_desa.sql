-- UMKM registration and dashboard schema (MySQL/MariaDB)

CREATE TABLE IF NOT EXISTS `umkm` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_usaha` VARCHAR(255) NOT NULL,
  `nama_pemilik` VARCHAR(255) NOT NULL,
  `nik` VARCHAR(20) NOT NULL,
  `telp` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `whatsapp` VARCHAR(20) NOT NULL,
  `kategori_usaha` VARCHAR(100),
  `skala_usaha` VARCHAR(100),
  `bentuk_usaha` VARCHAR(100),
  `modal_usaha` VARCHAR(100),
  `target_pasaran` VARCHAR(255),
  `tahun_berdiri` YEAR,
  `alamat_usaha` TEXT,
  `deskripsi_usaha` TEXT,
  `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  `alasan_penolakan` TEXT,
  `ktp_path` VARCHAR(255),
  `nib_path` VARCHAR(255),
  `lokasi_path` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'supervisor') DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
