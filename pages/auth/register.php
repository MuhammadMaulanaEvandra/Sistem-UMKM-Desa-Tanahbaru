                    <!-- REGISTER MODULE (Standard Multi-Step Form) -->
                    <form id="registerForm" onsubmit="handleRegistration(event)" class="space-y-4 hidden">
                        <!-- Step Indicator Badge -->
                        <div class="flex justify-between items-center text-[11px] font-bold text-slate-400 mb-2">
                            <span id="regStepBadge" class="bg-brand-100 text-brand-700 px-2.5 py-1 rounded-full uppercase text-[9px] tracking-wider font-extrabold">Langkah 1: Profil Pemilik</span>
                            <span>Selesai <span id="regStepPercent">20%</span></span>
                        </div>

                        <!-- STEP 1: Profil Pemilik -->
                        <div id="regStep1" class="space-y-3">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Lengkap Pemilik (Owner)</label>
                                <input type="text" id="regOwnerName" required placeholder="Contoh: Ibu Siti Aminah" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" id="regOwnerNik" required maxlength="16" placeholder="Masukkan 16 digit NIK" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">No. WhatsApp</label>
                                    <input type="tel" id="regOwnerWa" required placeholder="08xxxx" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Email Usaha</label>
                                    <input type="email" id="regOwnerEmail" required placeholder="email@toko.com" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                                </div>
                            </div>
                            <button type="button" onclick="nextRegStep(2)" class="w-full py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-2">
                                <span>Lanjutkan ke Detail Usaha</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>

                        <!-- STEP 2: Detail Profil Usaha -->
                        <div id="regStep2" class="space-y-3 hidden">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Bentuk Usaha</label>
                                    <select id="regBentukUsaha" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium outline-none focus:bg-white focus:border-brand-500 transition">
                                        <option value="Perseorangan">Perseorangan (Individu)</option>
                                        <option value="CV">Kemitraan (CV)</option>
                                        <option value="PT">Badan Usaha (PT)</option>
                                        <option value="Koperasi">Koperasi / Kelompok Usaha</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Skala Usaha</label>
                                    <select id="regSkalaUsaha" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium outline-none focus:bg-white focus:border-brand-500 transition">
                                        <option value="Mikro">Usaha Mikro (Kecil/Rumahan)</option>
                                        <option value="Kecil">Usaha Kecil (Berkembang)</option>
                                        <option value="Menengah">Usaha Menengah (Menengah/Besar)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor NIB / Izin Usaha (Jika Ada)</label>
                                <div class="space-y-2">
                                    <input type="text" id="regNib" placeholder="Masukkan Nomor Izin Usaha" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                                    <label class="flex items-center gap-2 cursor-pointer text-[10px] text-slate-500">
                                        <input type="checkbox" id="regNoNibCheckbox" onchange="toggleNibInput()" class="rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                                        Belum memiliki izin resmi (Kami siap membantu)
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Modal Kerja (Rupiah)</label>
                                    <input type="number" id="regModalKerja" required placeholder="Contoh: 15000000" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Kategori Sektor</label>
                                    <select id="regSektorKbli" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium outline-none focus:bg-white focus:border-brand-500 transition">
                                        <option value="Makanan">Kuliner (Makanan)</option>
                                        <option value="Minuman">Kuliner (Minuman)</option>
                                        <option value="Kerajinan">Industri Kerajinan & Kayu</option>
                                        <option value="Jasa">Jasa Kreatif & Perdagangan</option>
                                        <option value="Pertanian">Pertanian & Peternakan Desa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Nama Toko / Usaha</label>
                                <input type="text" id="regShopName" required placeholder="Contoh: Krupuk Gurih Barokah" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                            </div>

                            <div class="flex gap-3">
                                <button type="button" onclick="nextRegStep(1)" class="w-1/3 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Kembali</button>
                                <button type="button" onclick="nextRegStep(3)" class="w-2/3 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-2">
                                    <span>Selanjutnya: Unggah Berkas</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- STEP 3: Dokumen Persyaratan -->
                        <div id="regStep3" class="space-y-3 hidden">
                            <p class="text-[10px] text-slate-500 mb-2 leading-relaxed">
                                Silakan unggah berkas kelengkapan dari HP atau komputer Anda untuk verifikasi identitas usaha.
                            </p>

                            <!-- Slot Upload KTP -->
                            <div class="space-y-1.5 p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 flex justify-between items-center">
                                    <span>1. Foto KTP Pemilik *</span>
                                    <span id="labelKtpUploaded" class="text-xs text-rose-500 font-bold"><i class="fa-solid fa-circle-xmark"></i> Kosong</span>
                                </span>
                                <label class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-address-card text-brand-500 text-sm"></i>
                                    <span class="text-xs text-slate-500" id="nameFileKtp">Pilih File Foto KTP</span>
                                    <input type="file" id="regFileKtp" required accept="image/jpeg, image/png, image/jpg, application/pdf" onchange="handleRegisterFileSelect(event, 'ktp')" class="hidden">
                                </label>
                            </div>

                            <!-- Slot Upload Keterangan Usaha -->
                            <div class="space-y-1.5 p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 flex justify-between items-center">
                                    <span>2. Foto Berkas NIB / Keterangan Usaha *</span>
                                    <span id="labelNibUploaded" class="text-xs text-rose-500 font-bold"><i class="fa-solid fa-circle-xmark"></i> Kosong</span>
                                </span>
                                <label class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-file-invoice text-brand-500 text-sm"></i>
                                    <span class="text-xs text-slate-500" id="nameFileNib">Pilih File Berkas Usaha</span>
                                    <input type="file" id="regFileNib" required accept="image/jpeg, image/png, image/jpg, application/pdf" onchange="handleRegisterFileSelect(event, 'nib')" class="hidden">
                                </label>
                            </div>

                            <!-- Slot Upload Lokasi Usaha -->
                            <div class="space-y-1.5 p-3.5 bg-slate-50 border border-slate-200 rounded-2xl">
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 flex justify-between items-center">
                                    <span>3. Foto Tempat / Lokasi Jualan *</span>
                                    <span id="labelLokasiUploaded" class="text-xs text-rose-500 font-bold"><i class="fa-solid fa-circle-xmark"></i> Kosong</span>
                                </span>
                                <label class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-image-portrait text-brand-500 text-sm"></i>
                                    <span class="text-xs text-slate-500" id="nameFileLokasi">Pilih Foto Tempat Usaha</span>
                                    <input type="file" id="regFileLokasi" required accept="image/jpeg, image/png, image/jpg, application/pdf" onchange="handleRegisterFileSelect(event, 'lokasi')" class="hidden">
                                </label>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="button" onclick="nextRegStep(2)" class="w-1/3 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Kembali</button>
                                <button type="button" onclick="nextRegStep(4)" class="w-2/3 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-2">
                                    <span>Selanjutnya: Kata Sandi</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- STEP 4: Kata Sandi Akun -->
                        <div id="regStep4" class="space-y-3 hidden">
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-1.5">
                                <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Akses Dasbor Pemilik</span>
                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                    Buat kata sandi khusus Anda untuk mengelola katalog produk, mengubah profil toko, dan memantau status keaktifan profil Anda langsung dari dasbor ini.
                                </p>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Alamat Lengkap Usaha</label>
                                <input type="text" id="regShopAddress" required placeholder="RT/RW, Dusun, Desa Tanahbaru" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Kata Sandi Akun</label>
                                    <input type="password" id="regPassword" required placeholder="Minimal 6 karakter" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Ulangi Kata Sandi</label>
                                    <input type="password" id="regConfirmPassword" required placeholder="Ketik ulang sandi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-xs font-medium focus:bg-white focus:border-brand-500 transition">
                                </div>
                            </div>

                            <label class="flex items-start gap-2.5 cursor-pointer text-[10px] text-slate-500 leading-relaxed pt-2">
                                <input type="checkbox" required class="mt-0.5 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                                Saya menyatakan data yang diserahkan adalah benar dan setuju dengan syarat & ketentuan portal kemitraan warga.
                            </label>

                            <div class="flex gap-3">
                                <button type="button" onclick="nextRegStep(3)" class="w-1/3 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Kembali</button>
                                <button type="submit" class="w-2/3 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-2 transition-all">
                                    <span>Kirim Berkas Pendaftaran</span>
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>

                    </form>

