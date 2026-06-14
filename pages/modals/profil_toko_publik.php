    <!-- 2. PUBLIC SHOP PROFILE MODAL (With complete business profile + catalog jualan) -->
    <div id="shopProfileModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div onclick="closeShopProfileModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="absolute top-4 right-4 z-10">
                    <button onclick="closeShopProfileModal()" class="w-9 h-9 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-full flex items-center justify-center transition focus:outline-none">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="p-6 sm:p-8 space-y-6 max-h-[90vh] overflow-y-auto">
                    <!-- Shop Top Brand -->
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                        <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-500 shrink-0 shadow-sm">
                            <i class="fa-solid fa-store text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 id="modalShopName" class="text-xl font-black text-slate-900 truncate">Nama Toko</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span id="modalShopNIB" class="text-[9px] font-bold text-brand-600 bg-brand-50 px-2 rounded-full">NIB: 1234567890123</span>
                                <span id="modalShopSkala" class="text-[9px] font-bold text-slate-500 bg-slate-100 px-2 rounded-full">Mikro</span>
                            </div>
                        </div>
                    </div>

                    <!-- Business Details -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-700">
                        <div class="space-y-1">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Nama Pemilik Usaha</span>
                            <span id="modalShopOwner" class="font-bold">Ibu Siti Aminah</span>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">No. WhatsApp / Kontak</span>
                            <span id="modalShopWa" class="font-bold">0812345678</span>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Jam Operasional</span>
                            <span id="modalShopHours" class="font-bold">08:00 - 17:00 WIB</span>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Alamat Lengkap</span>
                            <span id="modalShopAddress" class="font-bold">RT 03/RW 01, Krajan</span>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-xs text-slate-700">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Profil / Deskripsi Usaha</span>
                        <p id="modalShopDesc" class="font-light leading-relaxed font-sans">Penjelasan rinci mengenai latar belakang usaha lokal.</p>
                    </div>

                    <!-- Daftar Jualan Mereka apa aja (Catalogue Grid) -->
                    <div class="border-t border-slate-100 pt-5 space-y-4">
                        <h4 class="text-xs font-black tracking-wider text-slate-900 uppercase flex items-center gap-2">
                            <i class="fa-solid fa-basket-shopping text-brand-500"></i>
                            <span>Daftar Produk Jualan Toko</span>
                        </h4>
                        
                        <div id="modalShopCatalogGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <!-- Generated dinamik: list jualan produk usaha ini -->
                        </div>
                    </div>

                    <a id="modalShopBtnWa" href="#" target="_blank" class="w-full py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-lg flex items-center justify-center gap-2 transition">
                        <i class="fa-brands fa-whatsapp font-bold text-sm"></i> Kirim Pesan WhatsApp Langsung
                    </a>
                </div>
            </div>
        </div>
    </div>

