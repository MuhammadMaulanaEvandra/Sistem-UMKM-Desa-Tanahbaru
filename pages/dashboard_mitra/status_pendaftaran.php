                <!-- TAB 4: STATUS PENDAFTARAN -->
                <div id="mitraTab-oss-status" class="mitra-tab-content space-y-6 hidden">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Status Verifikasi Pendaftaran</h2>
                        <p class="text-xs text-slate-500">Pantau proses keaktifan berkas profil UMKM Anda.</p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/60 shadow-sm space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="text-xs font-bold uppercase">Status Saat Ini:</div>
                            <span id="mitraStatusBadge" class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Menunggu Verifikasi</span>
                        </div>

                        <!-- Reject Reason Box (Hidden unless rejected) -->
                        <div id="mitraRejectReasonBox" class="bg-rose-50 border border-rose-100 rounded-2xl p-4 flex gap-3 text-xs text-rose-800 hidden">
                            <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm mt-0.5 shrink-0"></i>
                            <div>
                                <span class="font-bold block mb-1">Catatan Koreksi Admin:</span>
                                <p id="mitraRejectReasonText" class="font-medium text-rose-600">Mohon perbaiki isian NIK karena tidak sesuai dengan KTP elektronik Pemilik.</p>
                            </div>
                        </div>

                        <!-- Visual Registration Timeline -->
                        <div class="space-y-6 relative border-l-2 border-slate-100 ml-4 pl-8 py-2">
                            <div class="relative">
                                <span class="absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-brand-500 border-4 border-white flex items-center justify-center"></span>
                                <h4 class="text-xs font-bold text-slate-800">1. Penyerahan Berkas Online</h4>
                                <p class="text-[10px] text-slate-400 mt-0.5">Sistem memformat data pendaftaran.</p>
                            </div>
                            <div class="relative">
                                <span id="timelineDot2" class="absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-slate-200 border-4 border-white flex items-center justify-center"></span>
                                <h4 class="text-xs font-bold text-slate-800">2. Peninjauan oleh Tim Pengelola</h4>
                                <p class="text-[10px] text-slate-400 mt-0.5">Tim pengelola membantu mencocokkan kategori usaha.</p>
                            </div>
                            <div class="relative">
                                <span id="timelineDot3" class="absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-slate-200 border-4 border-white flex items-center justify-center"></span>
                                <h4 class="text-xs font-bold text-slate-800">3. Tampil di Katalog Publik</h4>
                                <p class="text-[10px] text-slate-400 mt-0.5">Toko online Anda resmi dipublish di halaman utama katalog.</p>
                            </div>
                        </div>
                    </div>
                </div>

