    <!-- 3. ADD/EDIT PRODUCT MODAL (MITRA DASHBOARD) -->
    <div id="productCrudModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div onclick="closeCrudModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <h3 id="crudModalTitle" class="text-lg font-black text-slate-900">Tambah Produk Baru</h3>
                        <p class="text-xs text-slate-500">Lengkapi deskripsi, variasi, dan tambahkan beberapa foto jualan produk.</p>
                    </div>

                    <form id="productCrudForm" onsubmit="handleProductCrudSubmit(event)" class="space-y-4">
                        <input type="hidden" id="crudProductId">
                        
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Produk</label>
                            <input type="text" id="crudProductName" required placeholder="Contoh: Keripik Singkong Balado" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Harga (Rupiah)</label>
                            <input type="number" id="crudProductPrice" required placeholder="Contoh: 15000" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                        </div>

                        <!-- MULTI-PHOTO INPUT SECTION -->
                        <div class="space-y-2 border-y border-slate-100 py-3">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Foto Jualan Produk (Multi-Foto)</label>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Upload from Device -->
                                <label class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-200 hover:border-brand-500 hover:bg-brand-50/20 rounded-2xl cursor-pointer text-center transition">
                                    <i class="fa-solid fa-cloud-arrow-up text-brand-500 text-lg mb-1"></i>
                                    <span class="text-[10px] font-black text-slate-700">Pilih dari HP / Laptop</span>
                                    <input type="file" id="crudPhotoFileInput" accept="image/*" multiple onchange="handleProductFileSelect(event)" class="hidden">
                                </label>
                                
                                <!-- Alternate via URL Links -->
                                <div class="flex flex-col justify-center space-y-1.5">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Atau Tempel Link Foto</span>
                                    <input type="text" id="crudPhotoUrlInput" placeholder="https://..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[10px] font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                                    <button type="button" onclick="addProductPhotoUrl()" class="w-full py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg transition">
                                        <i class="fa-solid fa-plus text-[8px] mr-1"></i> Tambah Link
                                    </button>
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400">Bisa diunggah beberapa kali untuk menyusun lebih banyak gambar di katalog.</p>
                            
                            <!-- Thumbnail List Previews -->
                            <div id="crudPhotosPreviewContainer" class="grid grid-cols-4 gap-2 pt-2">
                                <!-- Generated Dynamically -->
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Deskripsi</label>
                            <textarea id="crudProductDesc" required placeholder="Jelaskan keunikan rasa atau bahan baku..." rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition"></textarea>
                        </div>

                        <!-- Varian Input Component -->
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Varian Produk (Chip)</label>
                            <div class="flex gap-2">
                                <input type="text" id="crudVarianInput" placeholder="Ketik satu varian (contoh: Original)" class="flex-grow px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                                <button type="button" onclick="addVarianChip()" class="px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl transition"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div id="crudVarianContainer" class="flex flex-wrap gap-1.5 pt-2"></div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="button" onclick="closeCrudModal()" class="w-1/3 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                            <button type="submit" class="w-2/3 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Katalog
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

