    <!-- 1. PUBLIC PRODUCT DETAIL MODAL (With Multiple Photos Carousel) -->
    <div id="productDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div onclick="closeProductModalPublic()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="absolute top-4 right-4 z-10">
                    <button onclick="closeProductModalPublic()" class="w-9 h-9 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-full flex items-center justify-center transition focus:outline-none">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 p-6 sm:p-10">
                    <!-- Column Left: Multi-photo Gallery Carousel -->
                    <div class="md:col-span-5 space-y-4">
                        <div class="relative overflow-hidden aspect-video sm:aspect-square bg-slate-50 border border-slate-100 rounded-2xl shadow-sm flex items-center justify-center group">
                            <img id="modalPubProductImage" src="" alt="Foto Produk" class="w-full h-full object-cover rounded-2xl">
                            
                            <!-- Prev Navigation -->
                            <button id="modalPubImgPrev" onclick="navigateProductPhoto(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-black/55 hover:bg-black/85 text-white rounded-full flex items-center justify-center transition focus:outline-none hidden">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <!-- Next Navigation -->
                            <button id="modalPubImgNext" onclick="navigateProductPhoto(1)" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-black/55 hover:bg-black/85 text-white rounded-full flex items-center justify-center transition focus:outline-none hidden">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                            
                            <!-- Counter Badge -->
                            <span id="modalPubImgCounter" class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-md text-[10px] font-bold text-white px-2.5 py-1 rounded-full hidden">
                                1 / 1
                            </span>
                        </div>
                        <!-- Mini Thumbnails List -->
                        <div id="modalPubThumbnails" class="flex gap-2 overflow-x-auto pb-1.5 no-scrollbar"></div>
                    </div>

                    <!-- Column Right: Information Detail -->
                    <div class="md:col-span-7 space-y-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span id="modalPubProductKategori" class="text-[10px] font-bold text-brand-600 bg-brand-50 px-2.5 py-1 rounded-full uppercase">Kategori</span>
                                <span id="modalPubProductNIB" class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Terverifikasi</span>
                            </div>
                            <h3 id="modalPubProductName" class="text-2xl font-black text-slate-900 leading-tight">Nama Produk</h3>
                            <span id="modalPubProductPrice" class="block text-2xl font-black text-brand-500">Rp 0</span>
                        </div>

                        <div class="space-y-1.5">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Deskripsi Produk</span>
                            <p id="modalPubProductDesc" class="text-xs text-slate-600 leading-relaxed font-light">Deskripsi rinci mengenai produk.</p>
                        </div>

                        <div class="space-y-1.5">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Pilihan Varian Rasa / Ukuran</span>
                            <div id="modalPubProductVarian" class="flex flex-wrap gap-1.5"></div>
                        </div>

                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex justify-between items-center gap-4">
                            <div class="min-w-0">
                                <span id="modalPubShopName" class="block font-bold text-xs text-slate-800 truncate">Nama Toko Mitra</span>
                                <span id="modalPubShopAddress" class="block text-[10px] text-slate-500 truncate mt-0.5"><i class="fa-solid fa-map-location-dot mr-1"></i>RT 03/RW 01, Dusun Krajan</span>
                            </div>
                            <button id="modalPubBtnViewProfile" class="px-3.5 py-2 bg-slate-200/60 hover:bg-slate-200 text-slate-700 font-bold text-[10px] rounded-lg shrink-0 transition">Lihat Profil Usaha</button>
                        </div>

                        <a id="modalPubBtnWa" href="#" target="_blank" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-lg flex items-center justify-center gap-2 transition flex-nowrap">
                            <i class="fa-brands fa-whatsapp text-sm font-bold"></i> Hubungi Pemilik Toko via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

