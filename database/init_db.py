import mysql.connector
from mysql.connector import Error

# MySQL/MariaDB Configuration
config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'port': 3306
}

try:
    # Connect to MySQL server (without specifying database)
    conn = mysql.connector.connect(**config)
    cur = conn.cursor()
    
    # Create database if not exists
    cur.execute("CREATE DATABASE IF NOT EXISTS `umkm_desa` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")
    cur.execute("USE `umkm_desa`")
    
    # Create UMKM table
    cur.execute('''
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ''')
    
    # Create admin_users table
    cur.execute('''
    CREATE TABLE IF NOT EXISTS `admin_users` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `username` VARCHAR(100) NOT NULL UNIQUE,
      `password_hash` VARCHAR(255) NOT NULL,
      `role` ENUM('admin', 'supervisor') DEFAULT 'admin',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      KEY `idx_username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ''')
    
    conn.commit()
    print('MySQL/MariaDB database "umkm_desa" created successfully with tables!')
    
except Error as err:
    if err.errno == 2003:
        print(f"Error: Cannot connect to MySQL server at localhost:3306")
        print("Make sure MySQL/MariaDB service is running (e.g., in XAMPP Control Panel)")
    else:
        print(f"Error: {err}")
finally:
    if conn.is_connected():
        cur.close()
        conn.close()