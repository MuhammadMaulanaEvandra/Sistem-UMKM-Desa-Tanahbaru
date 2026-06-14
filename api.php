<?php
declare(strict_types=1);

require_once __DIR__ . '/database/connection.php';

header('Content-Type: application/json; charset=utf-8');

function respond(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function read_json(): array
{
    if (!empty($_POST)) {
        return $_POST;
    }
    
    $raw = file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') {
        return [];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function ensure_schema(PDO $pdo): void
{
    $columns = [
        'nib' => "ALTER TABLE `umkm` ADD COLUMN `nib` VARCHAR(100) NULL AFTER `nik`",
        'password_hash' => "ALTER TABLE `umkm` ADD COLUMN `password_hash` VARCHAR(255) NULL AFTER `email`",
        'jam_buka' => "ALTER TABLE `umkm` ADD COLUMN `jam_buka` VARCHAR(5) NULL AFTER `tahun_berdiri`",
        'jam_tutup' => "ALTER TABLE `umkm` ADD COLUMN `jam_tutup` VARCHAR(5) NULL AFTER `jam_buka`",
    ];

    foreach ($columns as $column => $sql) {
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'umkm' AND COLUMN_NAME = ?"
        );
        $stmt->execute([$column]);
        if ((int) $stmt->fetchColumn() === 0) {
            $pdo->exec($sql);
        }
    }

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `umkm_id` INT NOT NULL,
            `nama_produk` VARCHAR(255) NOT NULL,
            `harga` INT NOT NULL DEFAULT 0,
            `deskripsi` TEXT,
            `foto_json` LONGTEXT,
            `varian_json` TEXT,
            `aktif` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY `idx_umkm_id` (`umkm_id`),
            CONSTRAINT `fk_products_umkm` FOREIGN KEY (`umkm_id`) REFERENCES `umkm` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    // Buat akun admin default secara otomatis jika tabel admin_users kosong
    $adminCount = (int) $pdo->query("SELECT COUNT(*) FROM `admin_users`")->fetchColumn();
    if ($adminCount === 0) {
        $pdo->prepare(
            "INSERT INTO `admin_users` (`username`, `password_hash`, `role`) VALUES (?, ?, 'admin')"
        )->execute(['admin@tanahbaru.go.id', password_hash('admin123', PASSWORD_DEFAULT)]);
    }
}

function status_to_ui(?string $status): string
{
    return match ($status) {
        'approved' => 'Aktif',
        'rejected' => 'Ditolak',
        'inactive' => 'Nonaktif',
        default => 'Pending',
    };
}

function status_to_db(string $status): string
{
    return match ($status) {
        'Aktif' => 'approved',
        'Ditolak' => 'rejected',
        'Nonaktif' => 'inactive',
        default => 'pending',
    };
}

function normalize_umkm(array $row): array
{
    return [
        'id' => (string) $row['id'],
        'namaUsaha' => $row['nama_usaha'] ?? '',
        'pemilik' => $row['nama_pemilik'] ?? '',
        'nik' => $row['nik'] ?? '',
        'nib' => $row['nib'] ?? '',
        'email' => $row['email'] ?? '',
        'wa' => $row['whatsapp'] ?? ($row['telp'] ?? ''),
        'kategori' => $row['kategori_usaha'] ?? '',
        'skalaUsaha' => $row['skala_usaha'] ?? '',
        'bentukUsaha' => $row['bentuk_usaha'] ?? '',
        'modalKerja' => (int) preg_replace('/[^0-9]/', '', (string) ($row['modal_usaha'] ?? '0')),
        'kbli' => $row['target_pasaran'] ?? '',
        'alamat' => $row['alamat_usaha'] ?? '',
        'deskripsi' => $row['deskripsi_usaha'] ?? '',
        'status' => status_to_ui($row['status'] ?? 'pending'),
        'alasanPenolakan' => $row['alasan_penolakan'] ?? '',
        'tanggalDaftar' => substr((string) ($row['created_at'] ?? date('Y-m-d')), 0, 10),
        'docKtp' => $row['ktp_path'] ?? '',
        'docNib' => $row['nib_path'] ?? '',
        'docLokasi' => $row['lokasi_path'] ?? '',
        'jamBuka' => $row['jam_buka'] ?? '08:00',
        'jamTutup' => $row['jam_tutup'] ?? '17:00',
    ];
}

function normalize_product(array $row): array
{
    $photos = json_decode((string) ($row['foto_json'] ?? '[]'), true);
    $variants = json_decode((string) ($row['varian_json'] ?? '[]'), true);

    return [
        'id' => (string) $row['id'],
        'umkmId' => (string) $row['umkm_id'],
        'namaProduk' => $row['nama_produk'] ?? '',
        'harga' => (int) ($row['harga'] ?? 0),
        'deskripsi' => $row['deskripsi'] ?? '',
        'fotos' => is_array($photos) ? $photos : [],
        'varian' => is_array($variants) ? $variants : [],
        'aktif' => (bool) ($row['aktif'] ?? 1),
    ];
}

function fetch_umkms(PDO $pdo): array
{
    return array_map(
        'normalize_umkm',
        $pdo->query('SELECT * FROM `umkm` ORDER BY `created_at` DESC, `id` DESC')->fetchAll()
    );
}

function fetch_products(PDO $pdo): array
{
    return array_map(
        'normalize_product',
        $pdo->query('SELECT * FROM `products` ORDER BY `created_at` DESC, `id` DESC')->fetchAll()
    );
}

function sync_response(PDO $pdo, array $extra = []): array
{
    return array_merge([
        'ok' => true,
        'umkms' => fetch_umkms($pdo),
        'products' => fetch_products($pdo),
    ], $extra);
}

ensure_schema($pdo);

$input = read_json();
$action = (string) ($_GET['action'] ?? $input['action'] ?? 'bootstrap');

try {
    if ($action === 'bootstrap') {
        respond(sync_response($pdo));
    }

    if ($action === 'login') {
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        // 1. Coba cari di admin_users
        $stmt = $pdo->prepare('SELECT * FROM `admin_users` WHERE `username` = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, (string) $admin['password_hash'])) {
            respond(sync_response($pdo, [
                'user' => [
                    'id' => (string) $admin['id'],
                    'email' => $admin['username'],
                    'name' => $admin['username'],
                    'role' => $admin['role'],
                ],
                'role' => 'admin',
            ]));
        }

        // 2. Coba cari di umkm
        $stmt = $pdo->prepare('SELECT * FROM `umkm` WHERE `email` = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && !empty($user['password_hash']) && password_verify($password, (string) $user['password_hash'])) {
            respond(sync_response($pdo, [
                'user' => normalize_umkm($user),
                'role' => 'mitra',
            ]));
        }

        respond(['ok' => false, 'message' => 'Email atau kata sandi salah.'], 401);
    }

    if ($action === 'register_umkm') {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM `umkm` WHERE `email` = ? OR `nik` = ?');
        $stmt->execute([$input['email'] ?? '', $input['nik'] ?? '']);
        if ((int) $stmt->fetchColumn() > 0) {
            respond(['ok' => false, 'message' => 'Email atau NIK sudah terdaftar.'], 409);
        }

        // Fungsi helper untuk upload
        $upload_file = function(array $file, string $prefix): string {
            if (empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) return '';
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($ext, $allowed_extensions)) {
                throw new Exception("Ekstensi file tidak diizinkan. Gunakan JPG, PNG, atau PDF.");
            }
            
            if ($file['size'] > 5 * 1024 * 1024) {
                throw new Exception("Ukuran file maksimal 5 MB.");
            }
            
            $upload_dir = __DIR__ . '/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Sanitasi filename
            $filename = $prefix . '_' . uniqid() . '.' . $ext;
            $filepath = $upload_dir . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                throw new Exception("Gagal mengunggah file.");
            }
            
            return 'uploads/' . $filename;
        };

        $ktpPath = isset($_FILES['docKtp']) ? $upload_file($_FILES['docKtp'], 'ktp') : '';
        $nibPath = isset($_FILES['docNib']) ? $upload_file($_FILES['docNib'], 'nib') : '';
        $lokasiPath = isset($_FILES['docLokasi']) ? $upload_file($_FILES['docLokasi'], 'lokasi') : '';

        $stmt = $pdo->prepare(
            'INSERT INTO `umkm`
            (`nama_usaha`, `nama_pemilik`, `nik`, `nib`, `telp`, `email`, `password_hash`, `whatsapp`,
             `kategori_usaha`, `skala_usaha`, `bentuk_usaha`, `modal_usaha`, `target_pasaran`,
             `alamat_usaha`, `deskripsi_usaha`, `status`, `alasan_penolakan`, `ktp_path`, `nib_path`, `lokasi_path`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            trim((string) ($input['namaUsaha'] ?? '')),
            trim((string) ($input['pemilik'] ?? '')),
            trim((string) ($input['nik'] ?? '')),
            trim((string) ($input['nib'] ?? '')),
            trim((string) ($input['wa'] ?? '')),
            trim((string) ($input['email'] ?? '')),
            password_hash((string) ($input['password'] ?? ''), PASSWORD_DEFAULT),
            trim((string) ($input['wa'] ?? '')),
            trim((string) ($input['kategori'] ?? '')),
            trim((string) ($input['skalaUsaha'] ?? '')),
            trim((string) ($input['bentukUsaha'] ?? '')),
            (string) ((int) ($input['modalKerja'] ?? 0)),
            trim((string) ($input['kbli'] ?? 'Kemitraan Mandiri Desa')),
            trim((string) ($input['alamat'] ?? '')),
            trim((string) ($input['deskripsi'] ?? '')),
            'pending',
            '',
            $ktpPath,
            $nibPath,
            $lokasiPath,
        ]);

        respond(sync_response($pdo));
    }

    if ($action === 'update_umkm') {
        $stmt = $pdo->prepare(
            'UPDATE `umkm` SET
             `nama_usaha` = ?, `nama_pemilik` = ?, `nik` = ?, `nib` = ?, `telp` = ?, `whatsapp` = ?,
             `skala_usaha` = ?, `modal_usaha` = ?, `alamat_usaha` = ?, `deskripsi_usaha` = ?,
             `jam_buka` = ?, `jam_tutup` = ?
             WHERE `id` = ?'
        );
        $stmt->execute([
            trim((string) ($input['namaUsaha'] ?? '')),
            trim((string) ($input['pemilik'] ?? '')),
            trim((string) ($input['nik'] ?? '')),
            trim((string) ($input['nib'] ?? '')),
            trim((string) ($input['wa'] ?? '')),
            trim((string) ($input['wa'] ?? '')),
            trim((string) ($input['skalaUsaha'] ?? '')),
            (string) ((int) ($input['modalKerja'] ?? 0)),
            trim((string) ($input['alamat'] ?? '')),
            trim((string) ($input['deskripsi'] ?? '')),
            trim((string) ($input['jamBuka'] ?? '08:00')),
            trim((string) ($input['jamTutup'] ?? '17:00')),
            (int) ($input['id'] ?? 0),
        ]);

        respond(sync_response($pdo));
    }

    if ($action === 'update_umkm_status') {
        $stmt = $pdo->prepare('UPDATE `umkm` SET `status` = ?, `alasan_penolakan` = ? WHERE `id` = ?');
        $stmt->execute([
            status_to_db((string) ($input['status'] ?? 'Pending')),
            (string) ($input['alasanPenolakan'] ?? ''),
            (int) ($input['id'] ?? 0),
        ]);

        respond(sync_response($pdo));
    }

    if ($action === 'save_product') {
        $id = (int) ($input['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare(
                'UPDATE `products` SET `nama_produk` = ?, `harga` = ?, `deskripsi` = ?, `foto_json` = ?, `varian_json` = ?, `aktif` = ? WHERE `id` = ?'
            );
            $stmt->execute([
                trim((string) ($input['namaProduk'] ?? '')),
                (int) ($input['harga'] ?? 0),
                trim((string) ($input['deskripsi'] ?? '')),
                json_encode($input['fotos'] ?? [], JSON_UNESCAPED_UNICODE),
                json_encode($input['varian'] ?? [], JSON_UNESCAPED_UNICODE),
                !empty($input['aktif']) ? 1 : 0,
                $id,
            ]);
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO `products` (`umkm_id`, `nama_produk`, `harga`, `deskripsi`, `foto_json`, `varian_json`, `aktif`)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                (int) ($input['umkmId'] ?? 0),
                trim((string) ($input['namaProduk'] ?? '')),
                (int) ($input['harga'] ?? 0),
                trim((string) ($input['deskripsi'] ?? '')),
                json_encode($input['fotos'] ?? [], JSON_UNESCAPED_UNICODE),
                json_encode($input['varian'] ?? [], JSON_UNESCAPED_UNICODE),
                !empty($input['aktif']) ? 1 : 0,
            ]);
        }

        respond(sync_response($pdo));
    }

    if ($action === 'delete_product') {
        $stmt = $pdo->prepare('DELETE FROM `products` WHERE `id` = ?');
        $stmt->execute([(int) ($input['id'] ?? 0)]);
        respond(sync_response($pdo));
    }

    respond(['ok' => false, 'message' => 'Aksi API tidak dikenal.'], 404);
} catch (Throwable $e) {
    respond(['ok' => false, 'message' => $e->getMessage()], 500);
}
