    <!-- 4. REJECTION REASON MODAL (ADMIN DASHBOARD) -->
    <div id="rejectionModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div onclick="closeRejectionModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Kembalikan Berkas Pendaftaran</h3>
                        <p class="text-xs text-slate-500">Berikan catatan perbaikan profil usaha secara jelas.</p>
                    </div>

                    <form id="rejectionForm" onsubmit="handleRejectionSubmit(event)" class="space-y-4">
                        <input type="hidden" id="rejUmkmId">
                        
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Catatan Koreksi</label>
                            <textarea id="rejReasonText" required placeholder="Contoh: Lampiran NIK kurang jelas atau NIB belum sesuai." rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold outline-none focus:bg-white focus:border-brand-500 transition"></textarea>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="closeRejectionModal()" class="w-1/3 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                            <button type="submit" class="w-2/3 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> Kirim Catatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

