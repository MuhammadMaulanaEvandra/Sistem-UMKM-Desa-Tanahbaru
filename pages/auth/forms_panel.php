            <!-- RIGHT PANEL: Forms Panel -->
            <main class="w-full lg:w-1/2 flex flex-col justify-between p-6 sm:p-12 md:p-16 overflow-y-auto max-h-[100vh]">
                <div class="flex justify-between items-center w-full mb-8">
                    <button onclick="navigateTo('landing')" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-brand-500 transition">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                    </button>
                </div>

                <div class="my-auto max-w-md w-full mx-auto space-y-8">
                    
                    <!-- Form Title Block -->
                    <div class="space-y-2">
                        <h3 id="authFormTitle" class="text-3xl font-black text-slate-900 tracking-tight">Masuk Akun</h3>
                        <p id="authFormSubtitle" class="text-sm text-slate-500">Silakan masuk ke akun Anda.</p>
                    </div>

                    <!-- Custom Dual Tab Switcher -->
                    <div class="flex bg-slate-100 p-1.5 rounded-2xl relative">
                        <div id="authTabHighlighter" class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-6px)] bg-white rounded-xl shadow-md transition-transform duration-300 ease-out"></div>
                        <button onclick="toggleAuthTab(true)" id="authTabLoginBtn" class="z-10 w-1/2 py-2.5 text-xs font-bold rounded-xl text-brand-600 transition">Masuk</button>
                        <button onclick="toggleAuthTab(false)" id="authTabRegBtn" class="z-10 w-1/2 py-2.5 text-xs font-bold rounded-xl text-slate-500 hover:text-slate-800 transition">Daftar Baru</button>
                    </div>

                    <?php include __DIR__ . '/login.php'; ?>
                    <?php include __DIR__ . '/register.php'; ?>

                </div>

                <div class="pt-8 text-center text-[10px] text-slate-400 border-t border-slate-100 mt-8">
                    Portal terpadu dikelola Pengelola Portal UMKM Desa Tanahbaru.
                </div>
            </main>

