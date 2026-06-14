
<body class="h-full text-slate-800 flex flex-col antialiased">

    <!-- Custom Elegant Floating Toast Notification Container -->
    <div id="toastContainer" class="fixed top-6 right-6 z-50 flex flex-col gap-3 max-w-md w-full px-4 pointer-events-none"></div>

    <!-- Custom Modal Confirm Dialog System (Replacing standard alert & confirm) -->
    <div id="customConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-6 shadow-2xl border border-slate-100 transform transition-all">
            <div class="flex items-start gap-4">
                <div id="confirmIconBg" class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0">
                    <i id="confirmIcon" class="fa-solid text-xl"></i>
                </div>
                <div class="space-y-1">
                    <h3 id="confirmTitle" class="text-base font-black text-slate-900">Judul Konfirmasi</h3>
                    <p id="confirmMessage" class="text-xs text-slate-500 leading-relaxed">Pesan rincian konfirmasi aksi pengguna di sini.</p>
                </div>
            </div>
            <div class="flex gap-3 justify-end">
                <button id="confirmCancelBtn" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">Batal</button>
                <button id="confirmApproveBtn" class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-md transition">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <!-- Image Lightbox Viewer Modal -->
    <div id="lightboxModal" class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm hidden" onclick="closeLightbox()">
        <div class="relative max-w-4xl max-h-[85vh] w-full h-[85vh] flex items-center justify-center">
            <button class="absolute -top-12 right-0 text-white hover:text-slate-300 text-2xl focus:outline-none"><i class="fa-solid fa-circle-xmark"></i></button>
            <img id="lightboxImage" src="" alt="Pratinjau Dokumen" class="max-w-full max-h-[80vh] object-contain rounded-2xl border border-white/10 shadow-2xl hidden" onclick="event.stopPropagation()">
            <iframe id="lightboxIframe" src="" class="w-full h-full rounded-2xl bg-white hidden" onclick="event.stopPropagation()"></iframe>
        </div>
    </div>

    
