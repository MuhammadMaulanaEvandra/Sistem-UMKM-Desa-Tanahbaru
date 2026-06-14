<div id="page-dashboard-mitra" class="spa-page hidden flex flex-col md:flex-row bg-slate-50 min-h-screen">
    <?php include __DIR__ . '/dashboard_mitra/sidebar.php'; ?>

    <!-- Dashboard Area Utama -->
    <main class="flex-grow p-6 sm:p-10 space-y-8 w-full overflow-x-hidden">
        <?php include __DIR__ . '/dashboard_mitra/ringkasan_usaha.php'; ?>
        <?php include __DIR__ . '/dashboard_mitra/profil_usaha.php'; ?>
        <?php include __DIR__ . '/dashboard_mitra/kelola_produk.php'; ?>
        <?php include __DIR__ . '/dashboard_mitra/status_pendaftaran.php'; ?>
    </main>
</div>
