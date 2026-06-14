<!-- PUBLIC HEADER -->
    <header id="publicNavbar" class="sticky top-0 z-40 w-full bg-white/90 backdrop-blur-md border-b border-slate-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3 cursor-pointer" onclick="navigateTo('landing')">
                    <div class="w-11 h-11 bg-brand-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-brand-500/20">
                        <i class="fa-solid fa-store text-lg"></i>
                    </div>
                    <div>
                        <span class="block text-lg font-black tracking-tight text-slate-900">UMKM Tanahbaru</span>
                        <span class="block text-[10px] text-brand-600 font-bold tracking-wider uppercase">Portal Kemitraan Lokal</span>
                    </div>
                </div>

                <!-- Navigation Links - Desktop -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#hero" onclick="goToLandingSection('hero'); return false;" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition">Beranda</a>
                    <a href="#catalog" onclick="goToLandingSection('catalog'); return false;" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition">Katalog Produk</a>
                    <a href="#stats" onclick="goToLandingSection('stats'); return false;" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition">Statistik Desa</a>
                    <a href="#how-to" onclick="goToLandingSection('how-to'); return false;" class="text-sm font-semibold text-slate-600 hover:text-brand-500 transition">Cara Daftar</a>
                </nav>

                <!-- Auth Buttons - Desktop -->
                <div class="hidden md:flex items-center gap-3">
                    <button onclick="openAuthPage(true)" class="px-5 py-2.5 text-sm font-bold text-slate-700 hover:text-brand-600 transition">Masuk</button>
                    <button onclick="openAuthPage(false)" class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl shadow-md shadow-brand-500/10 hover:shadow-brand-500/20 transform hover:-translate-y-0.5 transition">Daftar UMKM</button>
                </div>

                <!-- Mobile Hamburger Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 hover:text-brand-500 focus:outline-none" aria-label="Toggle Menu">
                    <i id="mobileMenuIcon" class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobileMenu" class="hidden md:hidden border-b border-slate-100 bg-white px-4 pt-2 pb-6 space-y-3">
            <a href="#hero" onclick="toggleMobileMenu(); goToLandingSection('hero'); return false;" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-50">Beranda</a>
            <a href="#catalog" onclick="toggleMobileMenu(); goToLandingSection('catalog'); return false;" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-50">Katalog Produk</a>
            <a href="#stats" onclick="toggleMobileMenu(); goToLandingSection('stats'); return false;" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-50">Statistik Desa</a>
            <a href="#how-to" onclick="toggleMobileMenu(); goToLandingSection('how-to'); return false;" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-50">Cara Daftar</a>
            <div class="pt-4 border-t border-slate-100 flex flex-col gap-2.5">
                <button onclick="toggleMobileMenu(); openAuthPage(true)" class="w-full py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50 rounded-xl">Masuk</button>
                <button onclick="toggleMobileMenu(); openAuthPage(false)" class="w-full py-3 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl text-center shadow-lg">Daftar UMKM Mandiri</button>
            </div>
        </div>
    </header>

    
