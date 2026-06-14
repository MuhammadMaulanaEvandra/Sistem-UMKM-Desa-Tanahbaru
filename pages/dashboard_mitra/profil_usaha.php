                <!-- TAB 2: PROFILE FORM -->
                <div id="mitraTab-profile" class="mitra-tab-content space-y-6 hidden">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Profil Usaha Anda</h2>
                        <p class="text-xs text-slate-500">Perbarui informasi toko Anda untuk menyinkronkan data katalog publik.</p>
                    </div>

                    <form id="mitraProfileForm" onsubmit="saveMitraProfile(event)" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/60 shadow-sm space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Toko / Usaha</label>
                                <input type="text" id="mProfShopName" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor NIB / Izin Usaha</label>
                                <input type="text" id="mProfNib" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor NIK Pemilik</label>
                                <input type="text" id="mProfNik" required maxlength="16" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Pemilik</label>
                                <input type="text" id="mProfOwner" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">No. WhatsApp</label>
                                <input type="tel" id="mProfWa" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Skala Usaha</label>
                                <select id="mProfSkala" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                                    <option value="Mikro">Mikro (Kecil/Rumahan)</option>
                                    <option value="Kecil">Kecil (Berkembang)</option>
                                    <option value="Menengah">Menengah (Berkembang/Besar)</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Jam Operasional Buka</label>
                                <input type="time" id="mProfBuka" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Jam Operasional Tutup</label>
                                <input type="time" id="mProfTutup" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Deskripsi Singkat Toko</label>
                            <textarea id="mProfDesc" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition"></textarea>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Alamat Tempat Usaha</label>
                            <input type="text" id="mProfAddress" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                        </div>

                        <button type="submit" class="px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/15 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Profil Baru
                        </button>
                    </form>
                </div>

