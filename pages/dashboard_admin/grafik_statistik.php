                <!-- TAB 2: GRAPHICS & STATS -->
                <div id="adminTab-analytics" class="admin-tab-content space-y-6 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Grafik Kinerja Ekonomi Kreatif</h2>
                            <p class="text-xs text-slate-500">Visualisasi statistik persebaran kategori UMKM dan tren bulanan.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-500">Periode:</span>
                            <select id="adminChartPeriod" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold outline-none" onchange="renderCharts()">
                                <option value="2026">Tahun Buku 2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Chart 1: Pie Kategori -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Proporsi Kategori Sektor Usaha</h3>
                            <div class="h-64 relative flex justify-center">
                                <canvas id="chartKategori"></canvas>
                            </div>
                        </div>
                        <!-- Chart 2: Monthly Line -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-sm space-y-4">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Pertumbuhan Pendaftaran Mitra Baru</h3>
                            <div class="h-64 relative flex justify-center">
                                <canvas id="chartPertumbuhan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

