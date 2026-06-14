    <!-- 5. ADMIN VIEW DETAIL UMKM MODAL (With Document Viewer for all requirements) -->
    <div id="adminUmkmDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div onclick="closeAdminUmkmDetail()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="absolute top-4 right-4 z-10">
                    <button onclick="closeAdminUmkmDetail()" class="w-9 h-9 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-full flex items-center justify-center transition focus:outline-none">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
                    <!-- Left Column: Business & Owner Legal Data -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                            <div class="w-14 h-14 bg-brand-100 rounded-xl flex items-center justify-center text-brand-500 shrink-0"><i class="fa-solid fa-file-invoice text-2xl"></i></div>
                            <div>
                                <h3 id="admDetUsaha" class="text-base font-black text-slate-900 leading-tight">Detail Pendaftaran UMKM</h3>
                                <span id="admDetStatus" class="inline-block px-2.5 py-1 text-[9px] font-bold rounded-full mt-1">Pending</span>
                            </div>
                        </div>

                        <div class="space-y-4 text-xs">
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Nama Lengkap Pemilik</span>
                                <span id="admDetPemilik" class="font-extrabold text-slate-800">Ibu Siti</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Nomor NIK Pemilik</span>
                                <span id="admDetNik" class="font-bold font-mono text-slate-600">1234567890123456</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Nomor NIB / Izin Usaha</span>
                                <span id="admDetNib" class="font-bold font-mono text-slate-600">1234567890123</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kategori Sektor</span>
                                <span id="admDetKategori" class="font-bold text-slate-700">Makanan</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Bentuk Usaha</span>
                                <span id="admDetBentuk" class="font-semibold text-slate-700">Perseorangan</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Skala &amp; Modal Usaha</span>
                                <span class="block text-slate-700 font-bold"><span id="admDetSkala">Usaha Mikro</span> (<span id="admDetModal">Rp 15.000.000</span>)</span>
                            </div>
                            <div class="space-y-1">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">No. WhatsApp</span>
                                <span id="admDetWa" class="font-bold text-slate-700">0812345</span>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-5 space-y-3">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Tindakan Evaluasi Cepat</span>
                            <div id="admDetActionsContainer" class="flex flex-col gap-2"></div>
                        </div>
                    </div>

                    <!-- Right Column: Required Documents Viewer -->
                    <div class="lg:col-span-7 space-y-6 border-t lg:border-t-0 lg:border-l border-slate-100 pt-6 lg:pt-0 lg:pl-8">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-folder-open text-brand-500"></i>
                            <span>Dokumen & Persyaratan Terlampir</span>
                        </h4>

                        <div class="space-y-4">
                            <!-- Dokumen 1: KTP -->
                            <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">A. Foto KTP Pemilik</span>
                                    <button onclick="openDocLightbox('admDetImgKtp', 'admDetIframeKtp')" class="text-[10px] text-brand-600 hover:underline font-bold"><i class="fa-solid fa-expand mr-1"></i> Perbesar Dokumen</button>
                                </div>
                                <div class="relative h-44 w-full bg-slate-200/50 rounded-xl overflow-hidden border border-slate-200">
                                    <div id="msgImgKtp" class="absolute inset-0 flex items-center justify-center text-xs font-bold text-slate-500 bg-slate-100 hidden"></div>
                                    <img id="admDetImgKtp" src="" alt="Scan KTP" class="w-full h-full object-cover cursor-pointer" onclick="openDocLightbox('admDetImgKtp', 'admDetIframeKtp')" onerror="this.onerror=null; this.classList.add('hidden'); document.getElementById('msgImgKtp').innerText = 'File tidak ditemukan.'; document.getElementById('msgImgKtp').classList.remove('hidden');">
                                    <iframe id="admDetIframeKtp" class="w-full h-full hidden" src=""></iframe>
                                </div>
                            </div>

                            <!-- Dokumen 2: NIB / SKU -->
                            <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">B. Foto Berkas Keterangan Usaha / NIB</span>
                                    <button onclick="openDocLightbox('admDetImgNib', 'admDetIframeNib')" class="text-[10px] text-brand-600 hover:underline font-bold"><i class="fa-solid fa-expand mr-1"></i> Perbesar Dokumen</button>
                                </div>
                                <div class="relative h-44 w-full bg-slate-200/50 rounded-xl overflow-hidden border border-slate-200">
                                    <div id="msgImgNib" class="absolute inset-0 flex items-center justify-center text-xs font-bold text-slate-500 bg-slate-100 hidden"></div>
                                    <img id="admDetImgNib" src="" alt="Scan Berkas" class="w-full h-full object-cover cursor-pointer" onclick="openDocLightbox('admDetImgNib', 'admDetIframeNib')" onerror="this.onerror=null; this.classList.add('hidden'); document.getElementById('msgImgNib').innerText = 'File tidak ditemukan.'; document.getElementById('msgImgNib').classList.remove('hidden');">
                                    <iframe id="admDetIframeNib" class="w-full h-full hidden" src=""></iframe>
                                </div>
                            </div>

                            <!-- Dokumen 3: Lokasi Usaha -->
                            <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">C. Foto Lokasi / Tempat Usaha</span>
                                    <button onclick="openDocLightbox('admDetImgLokasi', 'admDetIframeLokasi')" class="text-[10px] text-brand-600 hover:underline font-bold"><i class="fa-solid fa-expand mr-1"></i> Perbesar Dokumen</button>
                                </div>
                                <div class="relative h-44 w-full bg-slate-200/50 rounded-xl overflow-hidden border border-slate-200">
                                    <div id="msgImgLokasi" class="absolute inset-0 flex items-center justify-center text-xs font-bold text-slate-500 bg-slate-100 hidden"></div>
                                    <img id="admDetImgLokasi" src="" alt="Fisik Lokasi Toko" class="w-full h-full object-cover cursor-pointer" onclick="openDocLightbox('admDetImgLokasi', 'admDetIframeLokasi')" onerror="this.onerror=null; this.classList.add('hidden'); document.getElementById('msgImgLokasi').innerText = 'File tidak ditemukan.'; document.getElementById('msgImgLokasi').classList.remove('hidden');">
                                    <iframe id="admDetIframeLokasi" class="w-full h-full hidden" src=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

