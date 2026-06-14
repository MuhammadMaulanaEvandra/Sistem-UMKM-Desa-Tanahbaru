<?php
// Structured UMKM portal entry point
?>
<?php include __DIR__ . '/includes/head.php'; ?>
<?php include __DIR__ . '/includes/body_start.php'; ?>
<?php include __DIR__ . '/includes/navbar.php'; ?>
<main class="flex-grow">
<?php include __DIR__ . '/pages/landing.php'; ?>
<?php include __DIR__ . '/pages/auth.php'; ?>
<?php include __DIR__ . '/pages/dashboard_mitra.php'; ?>
<?php include __DIR__ . '/pages/dashboard_admin.php'; ?>
</main>
<?php include __DIR__ . '/pages/modals.php'; ?>
<?php include __DIR__ . '/includes/scripts.php'; ?>
