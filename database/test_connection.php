<?php
/**
 * Database Connection Test
 * 
 * Jalankan file ini di browser untuk memverifikasi koneksi MySQL:
 * http://localhost/NewRpl/database/test_connection.php
 */

require_once 'connection.php';

try {
    // Test koneksi
    $result = $pdo->query("SELECT 1");
    echo "<h2 style='color: green;'>✓ Koneksi MySQL Berhasil!</h2>";
    
    // Tampilkan info database
    echo "<h3>Informasi Database:</h3>";
    echo "<ul>";
    echo "<li><strong>Host:</strong> $db_host:$db_port</li>";
    echo "<li><strong>Database:</strong> $db_name</li>";
    echo "<li><strong>Charset:</strong> utf8mb4</li>";
    echo "</ul>";
    
    // Cek tabel
    echo "<h3>Tabel yang Ada:</h3>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            // Count rows
            $countStmt = $pdo->query("SELECT COUNT(*) as cnt FROM `$table`");
            $count = $countStmt->fetch()['cnt'];
            echo "<li><code>$table</code> (records: $count)</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠ Tidak ada tabel ditemukan. Jalankan init_db.py untuk membuat tabel.</p>";
    }
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>✗ Koneksi MySQL Gagal!</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='color: #666; font-size: 12px;'>";
    echo "Pastikan:<br>";
    echo "• MySQL/MariaDB service berjalan<br>";
    echo "• Database '" . htmlspecialchars($db_name) . "' sudah dibuat<br>";
    echo "• Konfigurasi di connection.php sudah benar<br>";
    echo "</p>";
}
?>

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        margin: 40px;
        background: #f5f5f5;
    }
    h2, h3 {
        color: #333;
    }
    code {
        background: #f0f0f0;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
    }
</style>
