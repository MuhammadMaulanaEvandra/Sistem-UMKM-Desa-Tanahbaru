                <!-- TAB 1: MAIN DASHBOARD -->
                <div id="adminTab-main" class="admin-tab-content space-y-8">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">Panel Pengelolaan UMKM</h2>
                        <p class="text-xs text-slate-500">Kelola pendaftaran dan katalog UMKM Desa Tanahbaru secara langsung.</p>
                    </div>

                    <!-- 4 Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-500 shrink-0"><i class="fa-solid fa-store text-lg"></i></div>
                            <div>
                                <span id="adm-card-total" class="block text-xl font-black text-slate-900">0</span>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total UMKM</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-500 shrink-0"><i class="fa-solid fa-circle-check text-lg"></i></div>
                            <div>
                                <span id="adm-card-active" class="block text-xl font-black text-slate-900">0</span>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">UMKM Aktif</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-500 shrink-0"><i class="fa-solid fa-clock-rotate-left text-lg"></i></div>
                            <div>
                                <span id="adm-card-pending" class="block text-xl font-black text-slate-900">0</span>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">UMKM Pending</span>
                            </div>
                        </div>
                        <div class="bg-white rounded-3xl p-5 border border-slate-200/60 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-500 shrink-0"><i class="fa-solid fa-box text-lg"></i></div>
                            <div>
                                <span id="adm-card-products" class="block text-xl font-black text-slate-900">0</span>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Produk</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Registrations Table -->
                    <div class="space-y-4">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-hourglass-start text-amber-500 animate-spin"></i> Pendaftaran UMKM Menunggu Verifikasi</h3>
                        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                            <th class="p-4 pl-6 text-center w-16">No</th>
                                            <th class="p-4">Nama Usaha</th>
                                            <th class="p-4">Pemilik</th>
                                            <th class="p-4">Kategori / Sektor</th>
                                            <th class="p-4">Tanggal Daftar</th>
                                            <th class="p-4 pr-6 text-right w-52">Aksi Evaluasi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adminPendingTableBody" class="text-xs text-slate-700 divide-y divide-slate-50">
                                        <!-- Terisi otomatis -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- All UMKM Partners Management Table -->
                    <div class="space-y-4 pt-4">
                        <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-store text-brand-500"></i> Daftar Seluruh Mitra UMKM Desa
                        </h3>
                        <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                            <th class="p-4 pl-6 text-center w-16">No</th>
                                            <th class="p-4">Nama Usaha</th>
                                            <th class="p-4">Pemilik</th>
                                            <th class="p-4">Kategori Sektor</th>
                                            <th class="p-4 text-center w-28">Status Keaktifan</th>
                                            <th class="p-4 pr-6 text-right w-64">Aksi Kelola</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adminAllUmkmTableBody" class="text-xs text-slate-700 divide-y divide-slate-50">
                                        <!-- Terisi otomatis lewat JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

