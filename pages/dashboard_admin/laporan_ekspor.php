                <!-- TAB 3: REPORTS EXPORT -->
                <div id="adminTab-reports" class="admin-tab-content space-y-6 hidden">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Ekspor Laporan Data UMKM</h2>
                        <p class="text-xs text-slate-500">Saring rentang waktu pendaftaran untuk mengekspor database.</p>
                    </div>

                    <form onsubmit="handleExportReport(event)" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/60 shadow-sm space-y-6 max-w-xl">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Mulai</label>
                                <input type="date" required id="exportDateStart" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal Selesai</label>
                                <input type="date" required id="exportDateEnd" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Format Ekspor Berkas</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-between p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:border-brand-500">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-file-pdf text-rose-500 text-lg"></i>
                                        <span class="text-xs font-semibold">Dokumen PDF (Rekap)</span>
                                    </div>
                                    <input type="radio" name="exportFormat" value="pdf" checked class="text-brand-500">
                                </label>
                                <label class="flex items-center justify-between p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:border-brand-500">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-file-excel text-emerald-600 text-lg"></i>
                                        <span class="text-xs font-semibold">Tabel Excel (XLSX)</span>
                                    </div>
                                    <input type="radio" name="exportFormat" value="excel" class="text-brand-500">
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-lg flex items-center justify-center gap-2 transition">
                            <i class="fa-solid fa-download"></i> Unduh Rekap Laporan
                        </button>
                    </form>
                </div>

