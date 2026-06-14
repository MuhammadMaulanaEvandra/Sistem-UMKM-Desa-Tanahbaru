            <!-- Catalog Section -->
            <section id="catalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
                <div class="text-center max-w-xl mx-auto space-y-3">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Katalog Produk UMKM</h2>
                    <p class="text-sm text-slate-500">Temukan aneka kreasi produk lokal pilihan dengan memilih kategori di bawah ini.</p>
                </div>

                <!-- Search & Filters Container -->
                <div class="space-y-6">
                    <!-- Prominent Search Bar -->
                    <div class="relative max-w-2xl mx-auto">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="catalogSearch" oninput="filterCatalog()" placeholder="Cari produk UMKM..." class="w-full pl-12 pr-10 py-4 bg-white border border-slate-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 rounded-2xl outline-none text-sm font-medium transition shadow-lg shadow-slate-100">
                        <button id="clearSearchBtn" onclick="clearCatalogSearch()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 hidden">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>

                    <!-- Category Chips -->
                    <div class="flex items-center justify-center gap-2 overflow-x-auto pb-3 no-scrollbar max-w-4xl mx-auto px-2">
                        <button onclick="filterCategory('Semua')" id="chip-Semua" class="category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-brand-primary text-white border border-brand-primary transition shadow-sm">Semua</button>
                        <button onclick="filterCategory('Makanan')" id="chip-Makanan" class="category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-white text-slate-600 hover:text-slate-800 border border-slate-200 transition shadow-sm">Makanan</button>
                        <button onclick="filterCategory('Minuman')" id="chip-Minuman" class="category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-white text-slate-600 hover:text-slate-800 border border-slate-200 transition shadow-sm">Minuman</button>
                        <button onclick="filterCategory('Kerajinan')" id="chip-Kerajinan" class="category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-white text-slate-600 hover:text-slate-800 border border-slate-200 transition shadow-sm">Kerajinan</button>
                        <button onclick="filterCategory('Jasa')" id="chip-Jasa" class="category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-white text-slate-600 hover:text-slate-800 border border-slate-200 transition shadow-sm">Jasa</button>
                        <button onclick="filterCategory('Pertanian')" id="chip-Pertanian" class="category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-white text-slate-600 hover:text-slate-800 border border-slate-200 transition shadow-sm">Pertanian</button>
                    </div>
                </div>

                <!-- Product Grid -->
                <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Dinonaktifkan sementara dan digenerate dinamis lewat JavaScript -->
                </div>

                <!-- Load More Button -->
                <div id="loadMoreContainer" class="flex justify-center pt-6">
                    <button onclick="loadMoreProducts()" id="loadMoreBtn" class="px-7 py-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold text-xs rounded-xl transition shadow-sm flex items-center gap-2">
                        <span>Tampilkan Lebih Banyak</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
            </section>

