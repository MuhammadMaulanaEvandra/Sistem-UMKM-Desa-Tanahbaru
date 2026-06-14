                <!-- TAB 3: MANAGE PRODUCTS -->
                <div id="mitraTab-products" class="mitra-tab-content space-y-6 hidden">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Kelola Katalog Produk</h2>
                            <p class="text-xs text-slate-500">Tambah, sunting, atau hapus produk unggulan toko Anda. Anda bisa mengunggah **beberapa foto** sekaligus di katalog produk.</p>
                        </div>
                        <button onclick="openProductModal()" class="px-5 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/10 flex items-center gap-2 self-start sm:self-auto">
                            <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                        </button>
                    </div>

                    <!-- Product Table -->
                    <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        <th class="p-4 pl-6 text-center w-16">No</th>
                                        <th class="p-4 w-24">Foto</th>
                                        <th class="p-4">Nama Produk</th>
                                        <th class="p-4">Harga</th>
                                        <th class="p-4">Varian</th>
                                        <th class="p-4 pr-6 text-right w-36">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="mitraProductTableBody" class="text-xs text-slate-700 divide-y divide-slate-50">
                                    <!-- Terisi otomatis -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

