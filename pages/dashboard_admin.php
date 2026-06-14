<div id="page-dashboard-admin" class="spa-page hidden flex flex-col md:flex-row bg-slate-50 min-h-screen">
    <?php include __DIR__ . '/dashboard_admin/sidebar.php'; ?>

    <!-- Dashboard Area Utama -->
    <main class="flex-grow p-6 sm:p-10 space-y-8 w-full overflow-x-hidden">
        <?php include __DIR__ . '/dashboard_admin/dashboard_utama.php'; ?>
        <?php include __DIR__ . '/dashboard_admin/grafik_statistik.php'; ?>
        <?php include __DIR__ . '/dashboard_admin/laporan_ekspor.php'; ?>
    </main>
</div>
