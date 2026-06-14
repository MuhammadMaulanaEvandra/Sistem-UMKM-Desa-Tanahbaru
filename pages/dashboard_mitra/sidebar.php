            <!-- Sidebar Navigasi Kiri -->
            <aside class="w-full md:w-64 bg-slate-900 text-slate-300 shrink-0 flex flex-col justify-between border-r border-slate-800">
                <div class="p-6 space-y-8">
                    <!-- Profile Widget -->
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-brand-500 flex items-center justify-center text-white shrink-0 shadow-lg shadow-brand-500/10">
                            <i class="fa-solid fa-shop text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <span id="mitra-sidebar-name" class="block font-bold text-white text-sm truncate">Warung Barokah</span>
                            <span id="mitra-sidebar-nib" class="block text-[10px] text-slate-400 truncate">NIB: 1234567890123</span>
                        </div>
                    </div>

                    <!-- Navigation Items -->
                    <nav class="space-y-1">
                        <button onclick="switchMitraTab('summary')" id="mitraTabBtn-summary" class="mitra-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-white bg-brand-500/10 border-l-4 border-brand-500 transition">
                            <i class="fa-solid fa-chart-line text-brand-500"></i> Ringkasan Usaha
                        </button>
                        <button onclick="switchMitraTab('profile')" id="mitraTabBtn-profile" class="mitra-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold hover:bg-slate-800 hover:text-white transition">
                            <i class="fa-solid fa-id-card"></i> Profil Usaha Anda
                        </button>
                        <button onclick="switchMitraTab('products')" id="mitraTabBtn-products" class="mitra-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold hover:bg-slate-800 hover:text-white transition">
                            <i class="fa-solid fa-boxes-packing"></i> Kelola Produk
                        </button>
                        <button onclick="switchMitraTab('oss-status')" id="mitraTabBtn-oss-status" class="mitra-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold hover:bg-slate-800 hover:text-white transition">
                            <i class="fa-solid fa-shield-halved"></i> Status Pendaftaran
                        </button>
                    </nav>
                </div>

                <div class="p-6 border-t border-slate-800">
                    <button onclick="handleLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-rose-400 hover:bg-rose-500/10 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Dashboard
                    </button>
                </div>
            </aside>

