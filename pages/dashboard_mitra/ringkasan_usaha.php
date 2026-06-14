                <!-- TAB 1: SUMMARY -->
                <div id="mitraTab-summary" class="mitra-tab-content space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900">Halo, <span id="mitra-header-owner">Ibu Siti</span>!</h2>
                            <p class="text-xs text-slate-500">Berikut adalah statistik operasional usaha Anda yang terverifikasi.</p>
                        </div>
                        <?php
                        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $tgl = date('j') . ' ' . $bulan[date('n')] . ' ' . date('Y');
                        ?>
                        <span class="text-xs font-bold bg-slate-200/50 border border-slate-200 text-slate-600 px-3 py-1.5 rounded-full"><i class="fa-regular fa-calendar mr-1.5"></i>Hari Ini, <?php echo $tgl; ?></span>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-500"><i class="fa-solid fa-boxes-stacked text-lg"></i></div>
                            <div>
                                <span id="mitra-summary-active-prod" class="block text-2xl font-black text-slate-900">0</span>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Produk Aktif</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-500"><i class="fa-solid fa-shield-halved text-lg"></i></div>
                            <div>
                                <span id="mitra-summary-oss-status" class="block text-sm font-black text-slate-900">Aktif</span>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Status Pendaftaran</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-500"><i class="fa-regular fa-clock text-lg"></i></div>
                            <div>
                                <span id="mitra-summary-updated" class="block text-sm font-black text-slate-900"><?php echo $bulan[date('n')] . ' ' . date('Y'); ?></span>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Tanggal Diperbarui</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informational Banner -->
                    <div class="bg-gradient-to-r from-brand-500 to-amber-500 rounded-3xl p-6 text-white shadow-lg flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="space-y-1 text-center sm:text-left">
                            <h3 class="text-base font-extrabold">Pendampingan Modal Kerja & Program Pelatihan</h3>
                            <p class="text-xs text-white/80 max-w-xl">Komunitas desa sedang membuka kemitraan permodalan bagi UMKM yang telah melengkapi data profil usahanya. Kunjungi sekretariat untuk informasi lebih lanjut.</p>
                        </div>
                        <button onclick="switchMitraTab('profile')" class="px-5 py-2.5 bg-white text-brand-600 font-bold text-xs rounded-xl shadow-md shrink-0 transition hover:bg-slate-50">Lengkapi Profil</button>
                    </div>
                </div>

