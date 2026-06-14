            <!-- Sidebar Navigasi Kiri -->
            <aside class="w-full md:w-64 bg-slate-900 text-slate-300 shrink-0 flex flex-col justify-between border-r border-slate-800">
                <div class="p-6 space-y-8">
                    <!-- Profile Widget -->
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-brand-500 flex items-center justify-center text-white shrink-0 shadow-lg">
                            <i class="fa-solid fa-user-shield text-lg"></i>
                        </div>
                        <div>
                            <span class="block font-bold text-white text-sm">Admin Desa</span>
                            <span class="block text-[10px] text-brand-400 font-bold uppercase tracking-wider">Pemdes Tanahbaru</span>
                        </div>
                    </div>

                    <!-- Navigation Items -->
                    <nav class="space-y-1">
                        <button onclick="switchAdminTab('main')" id="adminTabBtn-main" class="admin-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-white bg-brand-500/10 border-l-4 border-brand-500 transition">
                            <i class="fa-solid fa-chart-pie text-brand-500"></i> Dasbor Utama
                        </button>
                        <button onclick="switchAdminTab('analytics')" id="adminTabBtn-analytics" class="admin-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold hover:bg-slate-800 hover:text-white transition">
                            <i class="fa-solid fa-chart-line"></i> Grafik Statistik
                        </button>
                        <button onclick="switchAdminTab('reports')" id="adminTabBtn-reports" class="admin-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold hover:bg-slate-800 hover:text-white transition">
                            <i class="fa-solid fa-file-invoice"></i> Laporan & Ekspor
                        </button>
                    </nav>
                </div>

                <div class="p-6 border-t border-slate-800">
                    <button onclick="handleLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-rose-400 hover:bg-rose-500/10 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Dashboard
                    </button>
                </div>
            </aside>

