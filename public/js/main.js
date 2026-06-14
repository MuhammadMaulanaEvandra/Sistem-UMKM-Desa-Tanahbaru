// ── State global utama (diisi dari API, bukan localStorage) ──
        let umkms = [];
        let products = [];
        let currentUser = null;
        let currentRole = null;

        let selectedCategory = 'Semua';
        let searchQuery = '';
        let productsToShow = 6; 
        let tempVarianList = [];
        let tempPhotosList = []; 
        
        let currentDetailPhotoIndex = 0;
        let currentDetailPhotos = [];

        let tempRegKtp = "";
        let tempRegNib = "";
        let tempRegLokasi = "";
        let tempFileKtp = null;
        let tempFileNib = null;
        let tempFileLokasi = null;

        // Fungsi kompresi gambar berbasis Canvas untuk membatasi ukuran LocalStorage
        function compressImage(file, maxWidth, maxHeight, callback) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    
                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    // Gunakan resolusi 300x300 berkualitas 0.5 untuk menghemat kapasitas storage
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.5); 
                    callback(dataUrl);
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }

        // Custom Confirmation dialog untuk menghindari standard confirm()
        function showCustomConfirm(title, message, type, onApprove) {
            const modal = document.getElementById('customConfirmModal');
            const confirmTitle = document.getElementById('confirmTitle');
            const confirmMessage = document.getElementById('confirmMessage');
            const iconBg = document.getElementById('confirmIconBg');
            const icon = document.getElementById('confirmIcon');
            const approveBtn = document.getElementById('confirmApproveBtn');
            const cancelBtn = document.getElementById('confirmCancelBtn');

            confirmTitle.innerText = title;
            confirmMessage.innerText = message;

            if (type === 'danger') {
                iconBg.className = "w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-rose-100 text-rose-600";
                icon.className = "fa-solid fa-triangle-exclamation text-xl";
                approveBtn.className = "px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md transition";
            } else {
                iconBg.className = "w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-brand-100 text-brand-500";
                icon.className = "fa-solid fa-circle-info text-xl";
                approveBtn.className = "px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-md transition";
            }

            modal.classList.remove('hidden');

            const handleApprove = () => {
                modal.classList.add('hidden');
                cleanup();
                if (onApprove) onApprove();
            };

            const handleCancel = () => {
                modal.classList.add('hidden');
                cleanup();
            };

            const cleanup = () => {
                approveBtn.removeEventListener('click', handleApprove);
                cancelBtn.removeEventListener('click', handleCancel);
            };

            approveBtn.addEventListener('click', handleApprove);
            cancelBtn.addEventListener('click', handleCancel);
        }

        window.onload = async function() {
            try {
                const data = await fetch('api.php?action=bootstrap').then(r => r.json());
                syncFromApi(data);
            } catch (e) {
                console.error('Bootstrap gagal:', e);
                showToast('Gagal memuat data dari server. Periksa koneksi database.', 'error');
            }

            const storedSession = localStorage.getItem('current_user_session');
            const storedRole    = localStorage.getItem('current_user_role');

            // Set default date range for reports and exports
            const todayStr = new Date().toISOString().slice(0, 10);
            const startOfYearStr = `${new Date().getFullYear()}-01-01`;
            const exportDateStart = document.getElementById('exportDateStart');
            const exportDateEnd = document.getElementById('exportDateEnd');
            if (exportDateStart) exportDateStart.value = startOfYearStr;
            if (exportDateEnd) exportDateEnd.value = todayStr;

            if (storedSession && storedRole) {
                currentUser = JSON.parse(storedSession);
                currentRole = storedRole;
                if (currentRole === 'mitra') {
                    const fresh = umkms.find(u => u.id === currentUser.id);
                    if (fresh) currentUser = fresh;
                }
                navigateTo(currentRole === 'admin' ? 'dashboard-admin' : 'dashboard-mitra');
            } else {
                navigateTo('landing');
            }

            updatePublicStats();
        };

        // ── Helper: kirim POST JSON ke api.php ──
        async function apiCall(payload) {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            if (!response.ok) {
                const err = await response.json().catch(() => ({}));
                throw new Error(err.message || `HTTP ${response.status}`);
            }
            return response.json();
        }

        // ── Helper: terima {umkms, products} dari API → update state + render ──
        function syncFromApi(data) {
            if (Array.isArray(data.umkms))    umkms    = data.umkms;
            if (Array.isArray(data.products)) products = data.products;
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            const bgClass = type === 'success' ? 'bg-emerald-600' : (type === 'error' ? 'bg-rose-600' : 'bg-brand-500');
            const iconClass = type === 'success' ? 'fa-circle-check' : (type === 'error' ? 'fa-triangle-exclamation' : 'fa-circle-info');

            toast.className = `flex items-center gap-3 px-5 py-4 ${bgClass} text-white text-xs font-bold rounded-2xl shadow-xl transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto`;
            toast.innerHTML = `
                <i class="fa-solid ${iconClass} text-base shrink-0"></i>
                <div class="flex-grow">${message}</div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => { toast.remove(); }, 300);
            }, 4000);
        }

        function navigateTo(pageId) {
            document.querySelectorAll('.spa-page').forEach(page => page.classList.add('hidden'));
            
            const navbar = document.getElementById('publicNavbar');
            navbar.classList.remove('hidden');

            if (pageId === 'landing') {
                document.getElementById('page-landing').classList.remove('hidden');
                renderProductGrid();
                updatePublicStats();
            } else if (pageId === 'auth') {
                document.getElementById('page-auth').classList.remove('hidden');
            } else if (pageId === 'dashboard-mitra') {
                navbar.classList.add('hidden'); 
                document.getElementById('page-dashboard-mitra').classList.remove('hidden');
                initializeMitraDashboard();
            } else if (pageId === 'dashboard-admin') {
                navbar.classList.add('hidden'); 
                document.getElementById('page-dashboard-admin').classList.remove('hidden');
                initializeAdminDashboard();
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function goToLandingSection(sectionId) {
            navigateTo('landing');
            setTimeout(() => {
                const target = document.getElementById(sectionId);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 120);
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('mobileMenuIcon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.className = "fa-solid fa-xmark text-xl";
            } else {
                menu.classList.add('hidden');
                icon.className = "fa-solid fa-bars text-xl";
            }
        }

        function openAuthPage(isLogin) {
            navigateTo('auth');
            toggleAuthTab(isLogin);
        }

        function updatePublicStats() {
            const activeUmkmCount = umkms.filter(u => u.status === 'Aktif').length;
            const activeProdCount = products.filter(p => {
                const parent = umkms.find(u => u.id === p.umkmId);
                return p.aktif && parent && parent.status === 'Aktif';
            }).length;
            
            document.getElementById('stat-total-umkm').innerText = activeUmkmCount;
            document.getElementById('stat-total-produk').innerText = activeProdCount;
            document.getElementById('mitraCountBanner').innerText = `${activeUmkmCount}+ Mitra Digital`;
        }

        function renderProductGrid() {
            const grid = document.getElementById('productGrid');
            grid.innerHTML = '';

            let filtered = products.filter(p => {
                const parent = umkms.find(u => u.id === p.umkmId);
                if (!parent || parent.status !== 'Aktif') return false;
                if (!p.aktif) return false;
                if (selectedCategory !== 'Semua' && parent.kategori !== selectedCategory) return false;

                if (searchQuery) {
                    const matchName = p.namaProduk.toLowerCase().includes(searchQuery.toLowerCase());
                    const matchShop = parent.namaUsaha.toLowerCase().includes(searchQuery.toLowerCase());
                    const matchDesc = p.deskripsi.toLowerCase().includes(searchQuery.toLowerCase());
                    return matchName || matchShop || matchDesc;
                }
                return true;
            });

            const paginated = filtered.slice(0, productsToShow);

            if (paginated.length === 0) {
                grid.innerHTML = `
                    <div class="col-span-full py-16 text-center space-y-3">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mx-auto">
                            <i class="fa-solid fa-box-open text-2xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-500">Tidak ada produk yang cocok dengan pencarian Anda.</p>
                    </div>
                `;
                document.getElementById('loadMoreContainer').classList.add('hidden');
                return;
            }

            paginated.forEach(p => {
                const parent = umkms.find(u => u.id === p.umkmId);
                
                const hasPhotos = p.fotos && p.fotos.length > 0 && p.fotos[0];
                const placeholder = `https://placehold.co/400x300/ffe3d1/ea580c?text=${encodeURIComponent(p.namaProduk)}`;
                const imageSrc = hasPhotos ? p.fotos[0] : placeholder;

                const cardHtml = `
                    <div class="bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-md transition duration-300">
                        <div>
                            <div class="relative overflow-hidden aspect-video bg-slate-50 border-b border-slate-100">
                                <img src="${imageSrc}" alt="${p.namaProduk}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='${placeholder}'">
                                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-[9px] font-bold text-brand-600 px-2 py-0.5 rounded-full uppercase shadow-sm">${parent.kategori}</span>
                                ${p.fotos && p.fotos.length > 1 ? `<span class="absolute bottom-2 right-2 bg-slate-900/60 text-white text-[8px] font-bold px-1.5 py-0.5 rounded flex items-center gap-1"><i class="fa-regular fa-images"></i> ${p.fotos.length}</span>` : ''}
                            </div>
                            <div class="p-4 sm:p-5 space-y-2">
                                <span onclick="openShopProfileModalPublic('${parent.id}'); event.stopPropagation();" class="block text-[9px] font-bold text-brand-600 hover:underline cursor-pointer uppercase tracking-wider">${parent.namaUsaha}</span>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-950 truncate">${p.namaProduk}</h4>
                                <span class="block text-sm font-black text-brand-500">Rp ${p.harga.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="px-4 pb-4 sm:px-5 sm:pb-5">
                            <button onclick="openProductDetailPublic('${p.id}')" class="w-full py-2.5 bg-slate-50 hover:bg-brand-500 hover:text-white border border-slate-200 hover:border-brand-500 text-slate-600 font-bold text-[10px] rounded-xl transition flex items-center justify-center gap-1.5">
                                <span>Lihat Produk</span>
                                <i class="fa-solid fa-arrow-right text-[9px]"></i>
                            </button>
                        </div>
                    </div>
                `;
                grid.insertAdjacentHTML('beforeend', cardHtml);
            });

            if (filtered.length > productsToShow) {
                document.getElementById('loadMoreContainer').classList.remove('hidden');
            } else {
                document.getElementById('loadMoreContainer').classList.add('hidden');
            }
        }

        function filterCategory(cat) {
            selectedCategory = cat;
            document.querySelectorAll('.category-chip').forEach(btn => {
                btn.className = "category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-white text-slate-600 hover:text-slate-800 border border-slate-200 transition shadow-sm";
            });
            const activeBtn = document.getElementById(`chip-${cat}`);
            if (activeBtn) {
                activeBtn.className = "category-chip shrink-0 px-5 py-2.5 rounded-full text-xs font-bold bg-brand-primary text-white border border-brand-primary transition shadow-sm";
            }
            productsToShow = 6;
            renderProductGrid();
        }

        function filterCatalog() {
            searchQuery = document.getElementById('catalogSearch').value;
            const clearBtn = document.getElementById('clearSearchBtn');
            if (searchQuery) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
            productsToShow = 6;
            renderProductGrid();
        }

        function clearCatalogSearch() {
            document.getElementById('catalogSearch').value = '';
            searchQuery = '';
            document.getElementById('clearSearchBtn').classList.add('hidden');
            renderProductGrid();
        }

        function loadMoreProducts() {
            productsToShow += 6;
            renderProductGrid();
            showToast("Memuat baris produk berikutnya...", "info");
        }

        function openProductDetailPublic(id) {
            const p = products.find(prod => prod.id === id);
            if (!p) return;
            const shop = umkms.find(u => u.id === p.umkmId);

            currentDetailPhotos = p.fotos && p.fotos.length > 0 ? p.fotos : [`https://placehold.co/400x300/ffe3d1/ea580c?text=${encodeURIComponent(p.namaProduk)}`];
            currentDetailPhotoIndex = 0;

            updateCarouselView();

            document.getElementById('modalPubProductKategori').innerText = shop.kategori;
            document.getElementById('modalPubProductName').innerText = p.namaProduk;
            document.getElementById('modalPubProductPrice').innerText = `Rp ${p.harga.toLocaleString('id-ID')}`;
            document.getElementById('modalPubProductDesc').innerText = p.deskripsi;
            
            const varianContainer = document.getElementById('modalPubProductVarian');
            varianContainer.innerHTML = '';
            if (p.varian && p.varian.length > 0) {
                p.varian.forEach(v => {
                    varianContainer.insertAdjacentHTML('beforeend', `<span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-lg border border-slate-200">${v}</span>`);
                });
            } else {
                varianContainer.insertAdjacentHTML('beforeend', `<span class="text-[10px] text-slate-400 italic">Tidak ada variasi khusus</span>`);
            }

            document.getElementById('modalPubShopName').innerText = shop.namaUsaha;
            document.getElementById('modalPubShopAddress').innerHTML = `<i class="fa-solid fa-map-location-dot mr-1"></i> ${shop.alamat}`;

            const waMsg = `Halo ${shop.namaUsaha}, saya tertarik dengan produk "${p.namaProduk}" yang saya temukan di Portal UMKM Desa Tanahbaru. Apakah masih tersedia?`;
            document.getElementById('modalPubBtnWa').href = `https://wa.me/${shop.wa.replace(/^0/, '62')}?text=${encodeURIComponent(waMsg)}`;
            
            document.getElementById('modalPubBtnViewProfile').onclick = function() {
                closeProductModalPublic();
                setTimeout(() => { openShopProfileModalPublic(shop.id); }, 200);
            };

            document.getElementById('productDetailModal').classList.remove('hidden');
        }

        function updateCarouselView() {
            const imgElement = document.getElementById('modalPubProductImage');
            const prevBtn = document.getElementById('modalPubImgPrev');
            const nextBtn = document.getElementById('modalPubImgNext');
            const counter = document.getElementById('modalPubImgCounter');
            const thumbsContainer = document.getElementById('modalPubThumbnails');

            if (currentDetailPhotoIndex < 0) currentDetailPhotoIndex = 0;
            if (currentDetailPhotoIndex >= currentDetailPhotos.length) currentDetailPhotoIndex = currentDetailPhotos.length - 1;

            const currentSrc = currentDetailPhotos[currentDetailPhotoIndex];
            imgElement.src = currentSrc;
            imgElement.onerror = function() {
                this.src = "https://placehold.co/400x300/ffe3d1/ea580c?text=Foto+Katalog";
            };

            if (currentDetailPhotos.length > 1) {
                prevBtn.classList.remove('hidden');
                nextBtn.classList.remove('hidden');
                counter.classList.remove('hidden');
                counter.innerText = `${currentDetailPhotoIndex + 1} / ${currentDetailPhotos.length}`;
            } else {
                prevBtn.classList.add('hidden');
                nextBtn.classList.add('hidden');
                counter.classList.add('hidden');
            }

            thumbsContainer.innerHTML = '';
            currentDetailPhotos.forEach((src, idx) => {
                const isActive = idx === currentDetailPhotoIndex;
                const activeBorderClass = isActive ? 'border-brand-500 ring-2 ring-brand-500/25' : 'border-slate-200 hover:border-slate-300';
                thumbsContainer.insertAdjacentHTML('beforeend', `
                    <button onclick="jumpToDetailPhoto(${idx})" class="w-14 h-14 shrink-0 rounded-xl border ${activeBorderClass} overflow-hidden bg-slate-50 transition focus:outline-none">
                        <img src="${src}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100/ffe3d1/ea580c?text=Foto'">
                    </button>
                `);
            });
        }

        function navigateProductPhoto(dir) {
            currentDetailPhotoIndex += dir;
            if (currentDetailPhotoIndex < 0) currentDetailPhotoIndex = currentDetailPhotos.length - 1;
            if (currentDetailPhotoIndex >= currentDetailPhotos.length) currentDetailPhotoIndex = 0;
            updateCarouselView();
        }

        function jumpToDetailPhoto(idx) {
            currentDetailPhotoIndex = idx;
            updateCarouselView();
        }

        function closeProductModalPublic() {
            document.getElementById('productDetailModal').classList.add('hidden');
        }

        function openShopProfileModalPublic(shopId) {
            const shop = umkms.find(u => u.id === shopId);
            if (!shop) return;

            document.getElementById('modalShopName').innerText = shop.namaUsaha;
            document.getElementById('modalShopNIB').innerText = `NIB: ${shop.nib}`;
            document.getElementById('modalShopSkala').innerText = `${shop.skalaUsaha}`;
            document.getElementById('modalShopOwner').innerText = shop.pemilik;
            document.getElementById('modalShopWa').innerText = shop.wa;
            document.getElementById('modalShopHours').innerText = `08:00 - 18:00 WIB`;
            document.getElementById('modalShopAddress').innerText = shop.alamat;
            document.getElementById('modalShopDesc').innerText = shop.deskripsi || "Pelaku usaha mikro kebanggaan warga Desa Tanahbaru.";

            const catalogGrid = document.getElementById('modalShopCatalogGrid');
            catalogGrid.innerHTML = '';

            const shopProducts = products.filter(p => p.umkmId === shop.id && p.aktif);

            if (shopProducts.length === 0) {
                catalogGrid.innerHTML = `
                    <div class="col-span-full py-8 text-center text-slate-400">
                        <i class="fa-solid fa-store-slash text-xl block mb-1"></i>
                        <span class="text-[10px] font-bold">Toko belum mendaftarkan katalog produk jualan.</span>
                    </div>
                `;
            } else {
                shopProducts.forEach(p => {
                    const firstPhoto = p.fotos && p.fotos.length > 0 ? p.fotos[0] : `https://placehold.co/200x200/ffe3d1/ea580c?text=${encodeURIComponent(p.namaProduk)}`;
                    
                    catalogGrid.insertAdjacentHTML('beforeend', `
                        <div onclick="closeShopProfileModal(); setTimeout(() => { openProductDetailPublic('${p.id}'); }, 200);" class="bg-slate-50 border border-slate-100 rounded-2xl p-3 flex flex-col justify-between cursor-pointer hover:border-brand-500 hover:shadow-xs transition group">
                            <div>
                                <div class="aspect-square rounded-xl bg-white overflow-hidden border border-slate-100 relative">
                                    <img src="${firstPhoto}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='https://placehold.co/200x200/ffe3d1/ea580c?text=Foto'">
                                </div>
                                <h5 class="text-[11px] font-bold text-slate-900 mt-2 line-clamp-2">${p.namaProduk}</h5>
                            </div>
                            <span class="block text-[11px] font-extrabold text-brand-500 mt-1">Rp ${p.harga.toLocaleString('id-ID')}</span>
                        </div>
                    `);
                });
            }

            const waMsg = `Halo ${shop.namaUsaha}, saya tertarik melihat profil dan produk jualan Anda di Portal UMKM Desa Tanahbaru.`;
            document.getElementById('modalShopBtnWa').href = `https://wa.me/${shop.wa.replace(/^0/, '62')}?text=${encodeURIComponent(waMsg)}`;

            document.getElementById('shopProfileModal').classList.remove('hidden');
        }

        function closeShopProfileModal() {
            document.getElementById('shopProfileModal').classList.add('hidden');
        }

        function toggleAuthTab(switchToLogin) {
            const slider = document.getElementById('authTabHighlighter');
            const loginBtn = document.getElementById('authTabLoginBtn');
            const regBtn = document.getElementById('authTabRegBtn');
            const loginModule = document.getElementById('loginModule');
            const regForm = document.getElementById('registerForm');

            const title = document.getElementById('authFormTitle');
            const subtitle = document.getElementById('authFormSubtitle');

            if (switchToLogin) {
                slider.style.transform = "translateX(0)";
                loginBtn.className = "z-10 w-1/2 py-2.5 text-xs font-bold rounded-xl text-brand-600 transition";
                regBtn.className = "z-10 w-1/2 py-2.5 text-xs font-bold rounded-xl text-slate-500 hover:text-slate-800 transition";
                title.innerText = "Masuk Akun";
                subtitle.innerText = "Silakan masuk ke akun Anda.";
                regForm.classList.add('hidden');
                loginModule.classList.remove('hidden');
            } else {
                slider.style.transform = "translateX(100%)";
                loginBtn.className = "z-10 w-1/2 py-2.5 text-xs font-bold rounded-xl text-slate-500 hover:text-slate-800 transition";
                regBtn.className = "z-10 w-1/2 py-2.5 text-xs font-bold rounded-xl text-brand-600 transition";
                title.innerText = "Registrasi Kemitraan UMKM";
                subtitle.innerText = "Daftarkan unit usaha Anda agar dikenal lebih luas oleh masyarakat.";
                loginModule.classList.add('hidden');
                regForm.classList.remove('hidden');
                
                tempRegKtp = "";
                tempRegNib = "";
                tempRegLokasi = "";
                tempFileKtp = null;
                tempFileNib = null;
                tempFileLokasi = null;
                
                document.getElementById('labelKtpUploaded').className = "text-xs text-rose-500 font-bold";
                document.getElementById('labelKtpUploaded').innerHTML = `<i class="fa-solid fa-circle-xmark"></i> Kosong`;
                document.getElementById('labelNibUploaded').className = "text-xs text-rose-500 font-bold";
                document.getElementById('labelNibUploaded').innerHTML = `<i class="fa-solid fa-circle-xmark"></i> Kosong`;
                document.getElementById('labelLokasiUploaded').className = "text-xs text-rose-500 font-bold";
                document.getElementById('labelLokasiUploaded').innerHTML = `<i class="fa-solid fa-circle-xmark"></i> Kosong`;
                
                nextRegStep(1); 
            }
        }

        function togglePasswordVisibility(id, iconId) {
            const input = document.getElementById(id);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.className = "fa-solid fa-eye text-xs";
            } else {
                input.type = "password";
                icon.className = "fa-solid fa-eye-slash text-xs";
            }
        }

        function toggleNibInput() {
            const checkbox = document.getElementById('regNoNibCheckbox');
            const nibInput = document.getElementById('regNib');
            if (checkbox.checked) {
                nibInput.disabled = true;
                nibInput.value = "Kemitraan Mandiri Desa";
                nibInput.classList.add('bg-slate-100', 'text-slate-400');
            } else {
                nibInput.disabled = false;
                nibInput.value = "";
                nibInput.classList.remove('bg-slate-100', 'text-slate-400');
            }
        }

        function nextRegStep(step) {
            document.getElementById('regStep1').classList.add('hidden');
            document.getElementById('regStep2').classList.add('hidden');
            document.getElementById('regStep3').classList.add('hidden');
            document.getElementById('regStep4').classList.add('hidden');

            const badge = document.getElementById('regStepBadge');
            const percent = document.getElementById('regStepPercent');

            if (step === 1) {
                document.getElementById('regStep1').classList.remove('hidden');
                badge.innerText = "Langkah 1: Profil Pemilik";
                percent.innerText = "20%";
            } else if (step === 2) {
                document.getElementById('regStep2').classList.remove('hidden');
                badge.innerText = "Langkah 2: Detail Kategori Usaha";
                percent.innerText = "40%";
            } else if (step === 3) {
                document.getElementById('regStep3').classList.remove('hidden');
                badge.innerText = "Langkah 3: Unggah Berkas";
                percent.innerText = "60%";
            } else if (step === 4) {
                if (!tempRegKtp || !tempRegNib || !tempRegLokasi) {
                    showToast("Harap selesaikan pengunggahan semua berkas persyaratan terlebih dahulu!", "error");
                    document.getElementById('regStep3').classList.remove('hidden');
                    badge.innerText = "Langkah 3: Unggah Berkas";
                    percent.innerText = "80%";
                    return;
                }
                document.getElementById('regStep4').classList.remove('hidden');
                badge.innerText = "Langkah 4: Setup Sandi Dasbor";
                percent.innerText = "100%";
            }
        }

        function handleRegisterFileSelect(event, docType) {
            const file = event.target.files[0];
            if (!file) return;

            // validasi ukuran 5MB
            if (file.size > 5 * 1024 * 1024) {
                showToast("Ukuran file maksimal 5 MB!", "error");
                event.target.value = '';
                return;
            }

            // validasi tipe
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                showToast("Hanya file JPG, JPEG, PNG, dan PDF yang diperbolehkan!", "error");
                event.target.value = '';
                return;
            }

            const nameFileSpan = document.getElementById(`nameFile${docType.charAt(0).toUpperCase() + docType.slice(1)}`);
            const labelSpan = document.getElementById(`label${docType.charAt(0).toUpperCase() + docType.slice(1)}Uploaded`);
            
            if (docType === 'ktp') {
                tempFileKtp = file;
                tempRegKtp = "File Attached"; // to pass step 4 validation
            } else if (docType === 'nib') {
                tempFileNib = file;
                tempRegNib = "File Attached";
            } else if (docType === 'lokasi') {
                tempFileLokasi = file;
                tempRegLokasi = "File Attached";
            }

            nameFileSpan.innerText = `${file.name.substring(0, 20)}...`;
            labelSpan.className = "text-xs text-emerald-600 font-bold";
            labelSpan.innerHTML = `<i class="fa-solid fa-circle-check"></i> Siap`;
            showToast(`Dokumen ${docType.toUpperCase()} berhasil dipilih!`, "success");
        }

        async function handleLogin(event) {
            if (event) event.preventDefault();
            const email = document.getElementById('loginEmail').value.trim();
            const pass  = document.getElementById('loginPassword').value;

            if (!email || !pass) {
                showToast('Email dan kata sandi harus diisi!', 'error');
                return;
            }

            showToast('Memverifikasi akun...', 'info');
            try {
                const data = await apiCall({ action: 'login', email, password: pass });
                if (!data.ok) {
                    showToast(data.message || 'Login gagal.', 'error');
                    return;
                }
                syncFromApi(data);
                currentUser = data.user;
                currentRole = data.role;
                localStorage.setItem('current_user_session', JSON.stringify(currentUser));
                localStorage.setItem('current_user_role', currentRole);
                const greeting = currentRole === 'admin' ? 'Administrator' : currentUser.pemilik;
                showToast(`Selamat datang, ${greeting}!`, 'success');
                navigateTo(currentRole === 'admin' ? 'dashboard-admin' : 'dashboard-mitra');
            } catch (e) {
                console.error('Login error:', e);
                showToast('Terjadi kesalahan jaringan. Coba lagi.', 'error');
            }
        }

        async function handleRegistration(event) {
            event.preventDefault();
            const pass        = document.getElementById('regPassword').value;
            const confirmPass = document.getElementById('regConfirmPassword').value;

            if (pass.length < 6) {
                showToast('Kata sandi minimal berisi 6 karakter!', 'error');
                return;
            }
            if (pass !== confirmPass) {
                showToast('Kata sandi konfirmasi tidak cocok!', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'register_umkm');
            formData.append('namaUsaha', document.getElementById('regShopName').value);
            formData.append('pemilik', document.getElementById('regOwnerName').value);
            formData.append('nik', document.getElementById('regOwnerNik').value);
            formData.append('nib', document.getElementById('regNib').value);
            formData.append('email', document.getElementById('regOwnerEmail').value);
            formData.append('wa', document.getElementById('regOwnerWa').value);
            formData.append('kategori', document.getElementById('regSektorKbli').value);
            formData.append('skalaUsaha', document.getElementById('regSkalaUsaha').value);
            formData.append('bentukUsaha', document.getElementById('regBentukUsaha').value);
            formData.append('modalKerja', parseInt(document.getElementById('regModalKerja').value) || 0);
            formData.append('kbli', 'Kemitraan Mandiri Desa');
            formData.append('alamat', document.getElementById('regShopAddress').value);
            formData.append('deskripsi', '');
            formData.append('password', pass);
            if (tempFileKtp) formData.append('docKtp', tempFileKtp);
            if (tempFileNib) formData.append('docNib', tempFileNib);
            if (tempFileLokasi) formData.append('docLokasi', tempFileLokasi);

            showToast('Mengirim data pendaftaran...', 'info');
            try {
                const response = await fetch('api.php', {
                    method: 'POST',
                    body: formData
                });
                if (!response.ok) {
                    const err = await response.json().catch(() => ({}));
                    throw new Error(err.message || `HTTP ${response.status}`);
                }
                const data = await response.json();
                if (!data.ok) {
                    showToast(data.message || 'Pendaftaran gagal.', 'error');
                    return;
                }
                syncFromApi(data);
                showToast('Pendaftaran Terkirim ke Pengelola Desa!', 'success');
                showToast('Admin Desa akan meninjau dan menyetujui akun Anda.', 'info');
                document.getElementById('registerForm').reset();
                toggleAuthTab(true);
            } catch (e) {
                console.error('Register error:', e);
                showToast('Terjadi kesalahan jaringan. Coba lagi.', 'error');
            }
        }

        function handleLogout() {
            currentUser = null;
            currentRole = null;
            localStorage.removeItem('current_user_session');
            localStorage.removeItem('current_user_role');
            showToast("Sesi berhasil diakhiri.", "info");
            navigateTo('landing');
        }

        function initializeMitraDashboard() {
            document.getElementById('mitra-sidebar-name').innerText = currentUser.namaUsaha;
            document.getElementById('mitra-sidebar-nib').innerText = `NIB: ${currentUser.nib}`;
            document.getElementById('mitra-header-owner').innerText = currentUser.pemilik;

            document.getElementById('mProfShopName').value = currentUser.namaUsaha;
            document.getElementById('mProfNib').value = currentUser.nib;
            document.getElementById('mProfNik').value = currentUser.nik;
            document.getElementById('mProfOwner').value = currentUser.pemilik;
            document.getElementById('mProfWa').value = currentUser.wa;
            document.getElementById('mProfSkala').value = currentUser.skalaUsaha;
            document.getElementById('mProfBuka').value  = currentUser.jamBuka  || '08:00';
            document.getElementById('mProfTutup').value = currentUser.jamTutup || '17:00';
            document.getElementById('mProfDesc').value = currentUser.deskripsi || '';
            document.getElementById('mProfAddress').value = currentUser.alamat;

            const badge = document.getElementById('mitraStatusBadge');
            const timelineDot2 = document.getElementById('timelineDot2');
            const timelineDot3 = document.getElementById('timelineDot3');
            const reasonBox = document.getElementById('mitraRejectReasonBox');

            badge.innerText = currentUser.status;
            if (currentUser.status === 'Aktif') {
                badge.className = "px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700";
                timelineDot2.className = "absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-brand-500 border-4 border-white flex items-center justify-center";
                timelineDot3.className = "absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-brand-500 border-4 border-white flex items-center justify-center";
                reasonBox.classList.add('hidden');
            } else if (currentUser.status === 'Ditolak') {
                badge.className = "px-3.5 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700";
                timelineDot2.className = "absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-rose-600 border-4 border-white flex items-center justify-center";
                timelineDot3.className = "absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-slate-200 border-4 border-white flex items-center justify-center";
                document.getElementById('mitraRejectReasonText').innerText = currentUser.alasanPenolakan || "Lampiran kelengkapan NIK/NIB tidak sesuai standar data kependudukan.";
                reasonBox.classList.remove('hidden');
            } else {
                badge.className = "px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700";
                timelineDot2.className = "absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-brand-500 border-4 border-white flex items-center justify-center";
                timelineDot3.className = "absolute -left-[41px] top-0.5 w-5 h-5 rounded-full bg-slate-200 border-4 border-white flex items-center justify-center";
                reasonBox.classList.add('hidden');
            }

            const count = products.filter(p => p.umkmId === currentUser.id).length;
            document.getElementById('mitra-summary-active-prod').innerText = count;
            document.getElementById('mitra-summary-oss-status').innerText = currentUser.status;

            switchMitraTab('summary');
        }

        function switchMitraTab(tabId) {
            document.querySelectorAll('.mitra-tab-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.mitra-nav-item').forEach(btn => {
                btn.className = "mitra-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-slate-400 hover:bg-slate-800 hover:text-white transition";
            });

            document.getElementById(`mitraTab-${tabId}`).classList.remove('hidden');
            document.getElementById(`mitraTabBtn-${tabId}`).className = "mitra-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-white bg-brand-500/10 border-l-4 border-brand-500 transition";

            if (tabId === 'products') {
                renderMitraProductTable();
            }
        }

        async function saveMitraProfile(event) {
            event.preventDefault();
            const payload = {
                action:     'update_umkm',
                id:         currentUser.id,
                namaUsaha:  document.getElementById('mProfShopName').value,
                nib:        document.getElementById('mProfNib').value,
                nik:        document.getElementById('mProfNik').value,
                pemilik:    document.getElementById('mProfOwner').value,
                wa:         document.getElementById('mProfWa').value,
                skalaUsaha: document.getElementById('mProfSkala').value,
                deskripsi:  document.getElementById('mProfDesc').value,
                alamat:     document.getElementById('mProfAddress').value,
                modalKerja: currentUser.modalKerja || 0,
                jamBuka:    document.getElementById('mProfBuka').value,
                jamTutup:   document.getElementById('mProfTutup').value
            };
            showToast('Menyimpan profil...', 'info');
            try {
                const data = await apiCall(payload);
                if (!data.ok) { showToast(data.message || 'Gagal menyimpan profil.', 'error'); return; }
                syncFromApi(data);
                const fresh = umkms.find(u => u.id === currentUser.id);
                if (fresh) {
                    currentUser = fresh;
                    localStorage.setItem('current_user_session', JSON.stringify(currentUser));
                }
                showToast('Data berhasil disimpan.', 'success');
                initializeMitraDashboard();
            } catch (e) {
                console.error('Save profile error:', e);
                showToast('Terjadi kesalahan jaringan.', 'error');
            }
        }

        function renderMitraProductTable() {
            const tbody = document.getElementById('mitraProductTableBody');
            tbody.innerHTML = '';

            const filtered = products.filter(p => p.umkmId === currentUser.id);

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-slate-400 font-light">Belum mengunggah katalog produk. Tekan "Tambah" untuk mulai.</td></tr>`;
                return;
            }

            filtered.forEach((p, idx) => {
                const hasPhotos = p.fotos && p.fotos.length > 0 && p.fotos[0];
                const placeholder = `https://placehold.co/100x100/ffe3d1/ea580c?text=${encodeURIComponent(p.namaProduk)}`;
                const imageSrc = hasPhotos ? p.fotos[0] : placeholder;
                const chips = p.varian ? p.varian.map(v => `<span class="inline-block bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md text-[9px] mr-1 mb-1 font-bold">${v}</span>`).join('') : '';

                const row = `
                    <tr class="hover:bg-slate-50/50">
                        <td class="p-4 text-center font-bold text-slate-400">${idx + 1}</td>
                        <td class="p-4">
                            <div class="relative w-12 h-12 bg-slate-50 border border-slate-100 rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="${imageSrc}" class="w-full h-full object-cover" onerror="this.src='${placeholder}'">
                                ${p.fotos && p.fotos.length > 1 ? `<span class="absolute bottom-0 right-0 bg-slate-900/70 text-white text-[7px] font-black px-1 rounded-tl">${p.fotos.length}F</span>` : ''}
                            </div>
                        </td>
                        <td class="p-4 font-bold text-slate-800">${p.namaProduk}</td>
                        <td class="p-4 font-bold text-brand-600">Rp ${p.harga.toLocaleString('id-ID')}</td>
                        <td class="p-4">${chips || '-'}</td>
                        <td class="p-4 text-right pr-6 space-x-1 whitespace-nowrap">
                            <button onclick="openProductModal('${p.id}')" class="px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-600 rounded-lg font-bold text-[10px] transition"><i class="fa-solid fa-pen"></i> Sunting</button>
                            <button onclick="deleteProduct('${p.id}')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-[10px] transition"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        function openProductModal(id = null) {
            const title = document.getElementById('crudModalTitle');
            const form = document.getElementById('productCrudForm');
            form.reset();
            tempVarianList = [];
            tempPhotosList = [];
            renderTempVarianChips();
            renderTempPhotosPreviews();

            if (id) {
                title.innerText = "Sunting Katalog Produk";
                const p = products.find(prod => prod.id === id);
                document.getElementById('crudProductId').value = p.id;
                document.getElementById('crudProductName').value = p.namaProduk;
                document.getElementById('crudProductPrice').value = p.harga;
                document.getElementById('crudProductDesc').value = p.deskripsi;
                tempVarianList = p.varian ? [...p.varian] : [];
                tempPhotosList = p.fotos ? [...p.fotos] : [];
                renderTempVarianChips();
                renderTempPhotosPreviews();
            } else {
                title.innerText = "Tambah Produk Baru";
                document.getElementById('crudProductId').value = '';
            }

            document.getElementById('productCrudModal').classList.remove('hidden');
        }

        function closeCrudModal() {
            document.getElementById('productCrudModal').classList.add('hidden');
        }

        function handleProductFileSelect(event) {
            const files = event.target.files;
            if (!files || files.length === 0) return;

            let loadedCount = 0;
            showToast(`Mengompresi & menyiapkan berkas foto jualan...`, "info");

            for (let i = 0; i < files.length; i++) {
                compressImage(files[i], 300, 300, function(compressedBase64) {
                    tempPhotosList.push(compressedBase64);
                    loadedCount++;
                    if (loadedCount === files.length) {
                        renderTempPhotosPreviews();
                        showToast(`Berhasil menambahkan ${files.length} foto dari perangkat!`, "success");
                    }
                });
            }
        }

        function addProductPhotoUrl() {
            const input = document.getElementById('crudPhotoUrlInput');
            const val = input.value.trim();
            if (val) {
                if (!val.startsWith('http')) {
                    showToast("Harap masukkan tautan / URL foto yang valid (dimulai dengan http/https)", "error");
                    return;
                }
                tempPhotosList.push(val);
                input.value = '';
                renderTempPhotosPreviews();
                showToast("Foto eksternal berhasil ditambahkan ke daftar!", "success");
            } else {
                showToast("Silakan masukkan tautan foto terlebih dahulu.", "info");
            }
        }

        function removeTempPhoto(index) {
            tempPhotosList.splice(index, 1);
            renderTempPhotosPreviews();
            showToast("Foto dihapus.", "info");
        }

        function renderTempPhotosPreviews() {
            const container = document.getElementById('crudPhotosPreviewContainer');
            container.innerHTML = '';
            tempPhotosList.forEach((src, idx) => {
                container.insertAdjacentHTML('beforeend', `
                    <div class="relative w-full aspect-square bg-slate-100 rounded-xl border border-slate-200 overflow-hidden group">
                        <img src="${src}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100/ffe3d1/ea580c?text=Foto+Eror'">
                        <button type="button" onclick="removeTempPhoto(${idx})" class="absolute top-1 right-1 w-5 h-5 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center shadow focus:outline-none transition">
                            <i class="fa-solid fa-times text-[10px]"></i>
                        </button>
                    </div>
                `);
            });
        }

        function addVarianChip() {
            const input = document.getElementById('crudVarianInput');
            const val = input.value.trim();
            if (val && !tempVarianList.includes(val)) {
                tempVarianList.push(val);
                input.value = '';
                renderTempVarianChips();
            }
        }

        function removeTempVarianChip(index) {
            tempVarianList.splice(index, 1);
            renderTempVarianChips();
        }

        function renderTempVarianChips() {
            const container = document.getElementById('crudVarianContainer');
            container.innerHTML = '';
            tempVarianList.forEach((v, idx) => {
                container.insertAdjacentHTML('beforeend', `
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-brand-50 text-brand-700 text-[10px] font-bold rounded-lg border border-brand-200">
                        <span>${v}</span>
                        <button type="button" onclick="removeTempVarianChip(${idx})" class="text-brand-400 hover:text-brand-600"><i class="fa-solid fa-circle-xmark"></i></button>
                    </span>
                `);
            });
        }

        async function handleProductCrudSubmit(event) {
            event.preventDefault();
            const id = document.getElementById('crudProductId').value;
            const name = document.getElementById('crudProductName').value;
            const price = parseInt(document.getElementById('crudProductPrice').value) || 0;
            const desc = document.getElementById('crudProductDesc').value;

            if (tempPhotosList.length === 0) {
                tempPhotosList.push(`https://placehold.co/400x300/ffe3d1/ea580c?text=${encodeURIComponent(name)}`);
            }

            const payload = {
                action:     'save_product',
                id:         id || 0,
                umkmId:     currentUser.id,
                namaProduk: name,
                harga:      price,
                deskripsi:  desc,
                fotos:      [...tempPhotosList],
                varian:     [...tempVarianList],
                aktif:      true
            };

            showToast(id ? 'Memperbarui produk...' : 'Menambah produk baru...', 'info');
            try {
                const data = await apiCall(payload);
                if (!data.ok) { showToast(data.message || 'Gagal menyimpan produk.', 'error'); return; }
                syncFromApi(data);
                showToast(id ? 'Perubahan berhasil diperbarui.' : 'Produk berhasil ditambahkan.', 'success');
                closeCrudModal();
                renderMitraProductTable();
            } catch (e) {
                console.error('Save product error:', e);
                showToast('Terjadi kesalahan jaringan.', 'error');
            }
        }

        function deleteProduct(id) {
            showCustomConfirm(
                'Hapus Produk Publik',
                'Apakah Anda benar-benar yakin mau melenyapkan produk jualan ini dari etalase katalog publik?',
                'danger',
                async function() {
                    try {
                        const data = await apiCall({ action: 'delete_product', id });
                        if (!data.ok) { showToast(data.message || 'Gagal menghapus produk.', 'error'); return; }
                        syncFromApi(data);
                        showToast('Data berhasil dihapus.', 'success');
                        renderMitraProductTable();
                    } catch (e) {
                        console.error('Delete product error:', e);
                        showToast('Terjadi kesalahan jaringan.', 'error');
                    }
                }
            );
        }

        function initializeAdminDashboard() {
            const total = umkms.length;
            const active = umkms.filter(u => u.status === 'Aktif').length;
            const pending = umkms.filter(u => u.status === 'Pending').length;
            const prods = products.filter(p => {
                const parent = umkms.find(u => u.id === p.umkmId);
                return p.aktif && parent && parent.status === 'Aktif';
            }).length;

            document.getElementById('adm-card-total').innerText = total;
            document.getElementById('adm-card-active').innerText = active;
            document.getElementById('adm-card-pending').innerText = pending;
            document.getElementById('adm-card-products').innerText = prods;

            renderAdminPendingTable();
            renderAdminAllUmkmTable();
            renderCharts();
            switchAdminTab('main');
        }

        function switchAdminTab(tabId) {
            document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.admin-nav-item').forEach(btn => {
                btn.className = "admin-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-slate-400 hover:bg-slate-800 hover:text-white transition";
            });

            document.getElementById(`adminTab-${tabId}`).classList.remove('hidden');
            document.getElementById(`adminTabBtn-${tabId}`).className = "admin-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold text-white bg-brand-500/10 border-l-4 border-brand-500 transition";
        }

        function renderAdminPendingTable() {
            const tbody = document.getElementById('adminPendingTableBody');
            tbody.innerHTML = '';

            const pending = umkms.filter(u => u.status === 'Pending' || u.status === 'Nonaktif');

            if (pending.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-slate-400 font-light"><i class="fa-solid fa-circle-check text-emerald-500 text-lg mr-2"></i>Semua berkas pendaftaran kemitraan baru telah diverifikasi bersih.</td></tr>`;
                return;
            }

            pending.forEach((u, idx) => {
                let statusText = '';
                if (u.status === 'Nonaktif') {
                    statusText = ' <span class="bg-rose-100 text-rose-700 text-[8px] font-bold px-1.5 py-0.5 rounded-full ml-1.5 uppercase">Nonaktif</span>';
                }
                const row = `
                    <tr class="hover:bg-slate-50/50">
                        <td class="p-4 text-center font-bold text-slate-400">${idx + 1}</td>
                        <td class="p-4">
                            <button onclick="viewAdminUmkmDetail('${u.id}')" class="font-bold text-brand-600 hover:underline text-left">${u.namaUsaha}</button>
                            ${statusText}
                        </td>
                        <td class="p-4 font-semibold text-slate-700">${u.pemilik}</td>
                        <td class="p-4"><span class="bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full text-[10px] font-bold">${u.kategori}</span></td>
                        <td class="p-4 font-medium text-slate-500">${u.tanggalDaftar}</td>
                        <td class="p-4 text-right pr-6 space-x-1 whitespace-nowrap">
                            <button onclick="viewAdminUmkmDetail('${u.id}')" class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-[10px] transition"><i class="fa-solid fa-magnifying-glass"></i> Tinjau Berkas</button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        function renderAdminAllUmkmTable() {
            const tbody = document.getElementById('adminAllUmkmTableBody');
            tbody.innerHTML = '';

            const activeMitra = umkms.filter(u => u.status === 'Aktif');

            if (activeMitra.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-slate-400 font-light">Belum ada mitra UMKM aktif terdaftar di basis data.</td></tr>`;
                return;
            }

            activeMitra.forEach((u, idx) => {
                const statusBadge = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700"><i class="fa-solid fa-circle text-[6px]"></i> Aktif</span>`;
                
                const actionBtn = `
                    <button onclick="toggleUmkmStatus('${u.id}', 'Nonaktif')" class="px-2.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-[10px] transition">
                        <i class="fa-solid fa-ban"></i> Nonaktifkan
                    </button>
                `;

                const row = `
                    <tr class="hover:bg-slate-50/50">
                        <td class="p-4 text-center font-bold text-slate-400">${idx + 1}</td>
                        <td class="p-4">
                            <button onclick="viewAdminUmkmDetail('${u.id}')" class="font-bold text-brand-600 hover:underline text-left">${u.namaUsaha}</button>
                        </td>
                        <td class="p-4 font-semibold text-slate-700">${u.pemilik}</td>
                        <td class="p-4"><span class="bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full text-[10px] font-bold">${u.kategori}</span></td>
                        <td class="p-4 text-center">${statusBadge}</td>
                        <td class="p-4 text-right pr-6 space-x-1 whitespace-nowrap">
                            <button onclick="viewAdminUmkmDetail('${u.id}')" class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-[10px] transition">
                                <i class="fa-solid fa-magnifying-glass"></i> Detail
                            </button>
                            ${actionBtn}
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        function toggleUmkmStatus(id, newStatus) {
            const u = umkms.find(u => u.id === id);
            if (!u) return;
            const shopName    = u.namaUsaha;
            const statusLabel = newStatus === 'Aktif' ? 'mengaktifkan kembali' : 'menonaktifkan sementara';

            showCustomConfirm(
                'Konfirmasi Perubahan Status',
                `Apakah Anda yakin ingin ${statusLabel} mitra "${shopName}"? Produk jualan milik mitra ini akan otomatis diselaraskan di halaman publik.`,
                newStatus === 'Aktif' ? 'info' : 'danger',
                async function() {
                    try {
                        const data = await apiCall({ action: 'update_umkm_status', id, status: newStatus, alasanPenolakan: '' });
                        if (!data.ok) { showToast(data.message || 'Gagal mengubah status.', 'error'); return; }
                        syncFromApi(data);
                        showToast(newStatus === 'Aktif' ? 'UMKM berhasil diaktifkan.' : 'UMKM berhasil dinonaktifkan.', 'success');
                        initializeAdminDashboard();
                        updatePublicStats();
                        renderProductGrid();
                    } catch (e) {
                        console.error('Toggle status error:', e);
                        showToast('Terjadi kesalahan jaringan.', 'error');
                    }
                }
            );
        }

        async function approveUmkm(id) {
            try {
                const data = await apiCall({ action: 'update_umkm_status', id, status: 'Aktif', alasanPenolakan: '' });
                if (!data.ok) { showToast(data.message || 'Gagal menyetujui.', 'error'); return; }
                syncFromApi(data);
                showToast('UMKM berhasil disetujui.', 'success');
                initializeAdminDashboard();
                closeAdminUmkmDetail();
                renderProductGrid();
            } catch (e) {
                console.error('Approve UMKM error:', e);
                showToast('Terjadi kesalahan jaringan.', 'error');
            }
        }

        function openRejectionModal(id) {
            document.getElementById('rejUmkmId').value = id;
            document.getElementById('rejReasonText').value = '';
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        function closeRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }

        async function handleRejectionSubmit(event) {
            event.preventDefault();
            const id     = document.getElementById('rejUmkmId').value;
            const reason = document.getElementById('rejReasonText').value;

            showToast('Memproses penolakan...', 'info');
            try {
                const data = await apiCall({ action: 'update_umkm_status', id, status: 'Ditolak', alasanPenolakan: reason });
                if (!data.ok) { showToast(data.message || 'Gagal menolak pendaftaran.', 'error'); return; }
                syncFromApi(data);
                showToast('UMKM berhasil ditolak.', 'success');
                closeRejectionModal();
                initializeAdminDashboard();
                closeAdminUmkmDetail();
                renderProductGrid();
            } catch (e) {
                console.error('Rejection error:', e);
                showToast('Terjadi kesalahan jaringan.', 'error');
            }
        }

        function viewAdminUmkmDetail(id) {
            const u = umkms.find(um => um.id === id);
            if (!u) return;

            document.getElementById('admDetUsaha').innerText = u.namaUsaha;
            document.getElementById('admDetNik').innerText = u.nik;
            document.getElementById('admDetPemilik').innerText = u.pemilik;
            document.getElementById('admDetNib').innerText = u.nib;
            document.getElementById('admDetKategori').innerText = u.kategori;
            document.getElementById('admDetBentuk').innerText = u.bentukUsaha;
            document.getElementById('admDetSkala').innerText = u.skalaUsaha;
            document.getElementById('admDetModal').innerText = `Rp ${u.modalKerja.toLocaleString('id-ID')}`;
            document.getElementById('admDetWa').innerText = u.wa;

            const statusBadge = document.getElementById('admDetStatus');
            statusBadge.innerText = u.status;
            if (u.status === 'Aktif') {
                statusBadge.className = "inline-block px-2.5 py-1 text-[9px] font-bold rounded-full mt-1 bg-emerald-100 text-emerald-700";
            } else if (u.status === 'Ditolak') {
                statusBadge.className = "inline-block px-2.5 py-1 text-[9px] font-bold rounded-full mt-1 bg-rose-100 text-rose-700";
            } else {
                statusBadge.className = "inline-block px-2.5 py-1 text-[9px] font-bold rounded-full mt-1 bg-amber-100 text-amber-700";
            }

            const setDocView = (imgId, iframeId, msgId, path) => {
                const img = document.getElementById(imgId);
                const iframe = document.getElementById(iframeId);
                const msg = document.getElementById(msgId);
                
                img.classList.add('hidden');
                iframe.classList.add('hidden');
                msg.classList.add('hidden');
                
                if (!path) {
                    msg.innerText = 'Dokumen belum diunggah.';
                    msg.classList.remove('hidden');
                } else if (path.toLowerCase().endsWith('.pdf')) {
                    iframe.src = path;
                    iframe.classList.remove('hidden');
                } else {
                    img.src = path;
                    img.classList.remove('hidden');
                }
            };

            setDocView('admDetImgKtp', 'admDetIframeKtp', 'msgImgKtp', u.docKtp);
            setDocView('admDetImgNib', 'admDetIframeNib', 'msgImgNib', u.docNib);
            setDocView('admDetImgLokasi', 'admDetIframeLokasi', 'msgImgLokasi', u.docLokasi);

            const actContainer = document.getElementById('admDetActionsContainer');
            actContainer.innerHTML = '';
            if (u.status === 'Pending') {
                actContainer.innerHTML = `
                    <div class="grid grid-cols-2 gap-2 w-full pt-2">
                        <button onclick="approveUmkm('${u.id}')" class="px-3.5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-[10px] transition flex items-center justify-center gap-1"><i class="fa-solid fa-check"></i> Setujui Berkas</button>
                        <button onclick="openRejectionModal('${u.id}')" class="px-3.5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-[10px] transition flex items-center justify-center gap-1"><i class="fa-solid fa-xmark"></i> Tolak / Koreksi</button>
                    </div>
                `;
            } else if (u.status === 'Aktif') {
                actContainer.innerHTML = `
                    <button onclick="toggleUmkmStatus('${u.id}', 'Nonaktif')" class="w-full px-3.5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl font-bold text-[10px] transition"><i class="fa-solid fa-ban mr-1"></i> Nonaktifkan Profil Usaha</button>
                `;
            } else {
                actContainer.innerHTML = `
                    <button onclick="approveUmkm('${u.id}')" class="w-full px-3.5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-[10px] transition"><i class="fa-solid fa-rotate-left mr-1"></i> Pulihkan & Setujui Kemitraan</button>
                `;
            }

            document.getElementById('adminUmkmDetailModal').classList.remove('hidden');
        }

        function closeAdminUmkmDetail() {
            document.getElementById('adminUmkmDetailModal').classList.add('hidden');
        }

        function openDocLightbox(imgId, iframeId) {
            const img = document.getElementById(imgId);
            const iframe = document.getElementById(iframeId);
            const lightboxImg = document.getElementById('lightboxImage');
            const lightboxIframe = document.getElementById('lightboxIframe');
            
            lightboxImg.classList.add('hidden');
            lightboxIframe.classList.add('hidden');

            if (img && !img.classList.contains('hidden')) {
                lightboxImg.src = img.src;
                lightboxImg.classList.remove('hidden');
            } else if (iframe && !iframe.classList.contains('hidden')) {
                lightboxIframe.src = iframe.src;
                lightboxIframe.classList.remove('hidden');
            } else {
                return;
            }

            document.getElementById('lightboxModal').classList.remove('hidden');
        }

        function closeLightbox() {
            document.getElementById('lightboxModal').classList.add('hidden');
        }

        let chart1 = null;
        let chart2 = null;

        function renderCharts() {
            const catCounts = { 'Makanan': 0, 'Minuman': 0, 'Kerajinan': 0, 'Jasa': 0, 'Pertanian': 0 };
            umkms.forEach(u => {
                if (catCounts[u.kategori] !== undefined) {
                    catCounts[u.kategori]++;
                }
            });

            const ctx1 = document.getElementById('chartKategori');
            if (ctx1) {
                if (chart1) chart1.destroy();
                chart1 = new Chart(ctx1, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(catCounts),
                        datasets: [{
                            data: Object.values(catCounts),
                            backgroundColor: ['#f97316', '#fb923c', '#fdba74', '#fed7aa', '#ffedd5'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
                        }
                    }
                });
            }

            const ctx2 = document.getElementById('chartPertumbuhan');
            if (ctx2) {
                if (chart2) chart2.destroy();

                const currentYearStr = new Date().getFullYear().toString();
                const monthlyCounts = [0, 0, 0, 0, 0, 0];
                umkms.forEach(u => {
                    const regDate = getUmkmRegistrationDate(u);
                    if (regDate) {
                        const parts = regDate.split('-');
                        const year = parts[0];
                        const month = parseInt(parts[1]) - 1;
                        if (year === currentYearStr && month >= 0 && month < 6) {
                            monthlyCounts[month]++;
                        }
                    }
                });

                chart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                        datasets: [{
                            label: 'Pendaftaran Baru',
                            data: monthlyCounts,
                            backgroundColor: '#ea580c',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 9 } } },
                            x: { grid: { display: false }, ticks: { font: { size: 9 } } }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        }

        function handleExportReport(event) {
            event.preventDefault();
            const start = document.getElementById('exportDateStart').value;
            const end = document.getElementById('exportDateEnd').value;
            const selectedFormat = document.querySelector('input[name="exportFormat"]:checked');
            const format = selectedFormat ? selectedFormat.value : 'pdf';

            if (!start || !end) {
                showToast("Lengkapi rentang tanggal laporan terlebih dahulu.", "error");
                return;
            }

            if (new Date(`${start}T00:00:00`) > new Date(`${end}T23:59:59`)) {
                showToast("Tanggal mulai tidak boleh lebih besar dari tanggal selesai.", "error");
                return;
            }

            const report = buildExportReport(start, end);
            if (report.rows.length === 0) {
                showToast(`Tidak ada data UMKM pada periode ${start} s/d ${end}.`, "error");
                return;
            }

            showToast("Memproses data kemitraan...", "info");

            try {
                const formatLabel = format === 'excel' ? 'EXCEL' : 'PDF';
                const filename = `laporan-umkm-${start}-sd-${end}.${format === 'excel' ? 'xlsx' : 'pdf'}`;

                if (format === 'excel') {
                    downloadBlob(
                        createExcelReportBlob(report),
                        filename,
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    );
                } else {
                    downloadBlob(createPdfReportBlob(report), filename, 'application/pdf');
                }

                showToast(`Ekspor berhasil! Laporan format ${formatLabel} periode ${start} s/d ${end} telah diunduh.`, "success");
            } catch (error) {
                console.error('Export report failed:', error);
                showToast("Ekspor gagal diproses. Silakan coba lagi.", "error");
            }
        }

        function buildExportReport(start, end) {
            const startDate = new Date(`${start}T00:00:00`);
            const endDate = new Date(`${end}T23:59:59`);
            const rows = umkms
                .map(u => {
                    const tanggalDaftar = getUmkmRegistrationDate(u);
                    const produkMitra = products.filter(p => p.umkmId === u.id);

                    return {
                        tanggalDaftar,
                        namaUsaha: u.namaUsaha || '-',
                        pemilik: u.pemilik || '-',
                        nik: u.nik || '-',
                        nib: u.nib || '-',
                        email: u.email || '-',
                        wa: u.wa || '-',
                        kategori: u.kategori || '-',
                        skalaUsaha: u.skalaUsaha || '-',
                        bentukUsaha: u.bentukUsaha || '-',
                        modalKerja: Number(u.modalKerja) || 0,
                        kbli: u.kbli || '-',
                        alamat: u.alamat || '-',
                        deskripsi: u.deskripsi || '-',
                        status: u.status || '-',
                        alasanPenolakan: u.alasanPenolakan || '-',
                        jumlahProduk: produkMitra.length,
                        jumlahProdukAktif: produkMitra.filter(p => p.aktif).length
                    };
                })
                .filter(row => {
                    const registeredAt = new Date(`${row.tanggalDaftar}T12:00:00`);
                    return !Number.isNaN(registeredAt.getTime()) && registeredAt >= startDate && registeredAt <= endDate;
                })
                .sort((a, b) => a.tanggalDaftar.localeCompare(b.tanggalDaftar));

            const summary = rows.reduce((acc, row) => {
                acc.total += 1;
                acc.aktif += row.status === 'Aktif' ? 1 : 0;
                acc.pending += row.status === 'Pending' ? 1 : 0;
                acc.nonaktif += row.status === 'Nonaktif' ? 1 : 0;
                acc.ditolak += row.status === 'Ditolak' ? 1 : 0;
                acc.produk += row.status === 'Aktif' ? row.jumlahProduk : 0;
                return acc;
            }, { total: 0, aktif: 0, pending: 0, nonaktif: 0, ditolak: 0, produk: 0 });

            return {
                start,
                end,
                generatedAt: new Date(),
                rows,
                summary
            };
        }

        function getUmkmRegistrationDate(umkm) {
            const candidates = [umkm.tanggalDaftar, umkm.created_at, umkm.createdAt];
            const validDate = candidates.find(value => /^\d{4}-\d{2}-\d{2}/.test(String(value || '')));
            return validDate ? String(validDate).slice(0, 10) : new Date().toISOString().slice(0, 10);
        }

        function createExcelReportBlob(report) {
            const headers = [
                'No', 'Tanggal Daftar', 'Nama Usaha', 'Pemilik', 'NIK', 'NIB', 'Email',
                'WhatsApp', 'Kategori', 'Skala Usaha', 'Bentuk Usaha', 'Modal Kerja',
                'KBLI/Program', 'Status', 'Produk Aktif', 'Total Produk', 'Alamat',
                'Deskripsi', 'Alasan Penolakan'
            ];

            const rows = [
                ['Laporan Data UMKM Desa Tanahbaru'],
                [`Periode: ${formatDisplayDate(report.start)} s/d ${formatDisplayDate(report.end)}`],
                [`Dibuat: ${formatDateTime(report.generatedAt)}`],
                [],
                ['Ringkasan', 'Total UMKM', 'Aktif', 'Pending', 'Nonaktif', 'Ditolak', 'Total Produk'],
                ['', report.summary.total, report.summary.aktif, report.summary.pending, report.summary.nonaktif, report.summary.ditolak, report.summary.produk],
                [],
                headers,
                ...report.rows.map((row, index) => [
                    index + 1,
                    row.tanggalDaftar,
                    row.namaUsaha,
                    row.pemilik,
                    row.nik,
                    row.nib,
                    row.email,
                    row.wa,
                    row.kategori,
                    row.skalaUsaha,
                    row.bentukUsaha,
                    row.modalKerja,
                    row.kbli,
                    row.status,
                    row.jumlahProdukAktif,
                    row.jumlahProduk,
                    row.alamat,
                    row.deskripsi,
                    row.alasanPenolakan
                ])
            ];

            return buildXlsxBlob(rows, 'Laporan UMKM');
        }

        function buildXlsxBlob(rows, sheetName) {
            const sheetXml = createWorksheetXml(rows);
            const files = {
                '[Content_Types].xml': `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/></Types>`,
                '_rels/.rels': `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>`,
                'xl/workbook.xml': `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="${escapeXml(sheetName).slice(0, 31)}" sheetId="1" r:id="rId1"/></sheets></workbook>`,
                'xl/_rels/workbook.xml.rels': `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/></Relationships>`,
                'xl/worksheets/sheet1.xml': sheetXml
            };

            return new Blob([createZipArchive(files)], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
        }

        function createWorksheetXml(rows) {
            const columnCount = rows.reduce((max, row) => Math.max(max, row.length), 0);
            const cols = Array.from({ length: columnCount }, (_, index) => {
                const width = index === 0 ? 6 : (index >= 16 ? 34 : 18);
                return `<col min="${index + 1}" max="${index + 1}" width="${width}" customWidth="1"/>`;
            }).join('');

            const sheetData = rows.map((row, rowIndex) => {
                const cells = row.map((value, colIndex) => {
                    const cellRef = `${columnName(colIndex + 1)}${rowIndex + 1}`;
                    if (typeof value === 'number') {
                        return `<c r="${cellRef}"><v>${value}</v></c>`;
                    }

                    return `<c r="${cellRef}" t="inlineStr"><is><t>${escapeXml(value)}</t></is></c>`;
                }).join('');

                return `<row r="${rowIndex + 1}">${cells}</row>`;
            }).join('');

            return `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><cols>${cols}</cols><sheetData>${sheetData}</sheetData></worksheet>`;
        }

        function createZipArchive(files) {
            const encoder = new TextEncoder();
            const localParts = [];
            const centralParts = [];
            let offset = 0;

            Object.entries(files).forEach(([filename, content]) => {
                const nameBytes = encoder.encode(filename);
                const dataBytes = encoder.encode(content);
                const crc = crc32(dataBytes);
                const localHeader = createZipLocalHeader(nameBytes, dataBytes.length, crc);
                const centralHeader = createZipCentralHeader(nameBytes, dataBytes.length, crc, offset);

                localParts.push(localHeader, dataBytes);
                centralParts.push(centralHeader);
                offset += localHeader.length + dataBytes.length;
            });

            const centralSize = centralParts.reduce((total, part) => total + part.length, 0);
            const centralOffset = offset;
            const endRecord = createZipEndRecord(Object.keys(files).length, centralSize, centralOffset);

            return concatUint8Arrays([...localParts, ...centralParts, endRecord]);
        }

        function createZipLocalHeader(nameBytes, size, crc) {
            const header = new Uint8Array(30 + nameBytes.length);
            const view = new DataView(header.buffer);
            view.setUint32(0, 0x04034b50, true);
            view.setUint16(4, 20, true);
            view.setUint16(6, 0, true);
            view.setUint16(8, 0, true);
            view.setUint16(10, getDosTime(), true);
            view.setUint16(12, getDosDate(), true);
            view.setUint32(14, crc, true);
            view.setUint32(18, size, true);
            view.setUint32(22, size, true);
            view.setUint16(26, nameBytes.length, true);
            view.setUint16(28, 0, true);
            header.set(nameBytes, 30);
            return header;
        }

        function createZipCentralHeader(nameBytes, size, crc, offset) {
            const header = new Uint8Array(46 + nameBytes.length);
            const view = new DataView(header.buffer);
            view.setUint32(0, 0x02014b50, true);
            view.setUint16(4, 20, true);
            view.setUint16(6, 20, true);
            view.setUint16(8, 0, true);
            view.setUint16(10, 0, true);
            view.setUint16(12, getDosTime(), true);
            view.setUint16(14, getDosDate(), true);
            view.setUint32(16, crc, true);
            view.setUint32(20, size, true);
            view.setUint32(24, size, true);
            view.setUint16(28, nameBytes.length, true);
            view.setUint16(30, 0, true);
            view.setUint16(32, 0, true);
            view.setUint16(34, 0, true);
            view.setUint16(36, 0, true);
            view.setUint32(38, 0, true);
            view.setUint32(42, offset, true);
            header.set(nameBytes, 46);
            return header;
        }

        function createZipEndRecord(totalFiles, centralSize, centralOffset) {
            const record = new Uint8Array(22);
            const view = new DataView(record.buffer);
            view.setUint32(0, 0x06054b50, true);
            view.setUint16(4, 0, true);
            view.setUint16(6, 0, true);
            view.setUint16(8, totalFiles, true);
            view.setUint16(10, totalFiles, true);
            view.setUint32(12, centralSize, true);
            view.setUint32(16, centralOffset, true);
            view.setUint16(20, 0, true);
            return record;
        }

        function crc32(bytes) {
            const table = crc32.table || (crc32.table = Array.from({ length: 256 }, (_, index) => {
                let value = index;
                for (let bit = 0; bit < 8; bit++) {
                    value = (value & 1) ? (0xedb88320 ^ (value >>> 1)) : (value >>> 1);
                }
                return value >>> 0;
            }));

            let crc = 0xffffffff;
            for (let i = 0; i < bytes.length; i++) {
                crc = table[(crc ^ bytes[i]) & 0xff] ^ (crc >>> 8);
            }
            return (crc ^ 0xffffffff) >>> 0;
        }

        function getDosTime() {
            const now = new Date();
            return (now.getHours() << 11) | (now.getMinutes() << 5) | Math.floor(now.getSeconds() / 2);
        }

        function getDosDate() {
            const now = new Date();
            return ((now.getFullYear() - 1980) << 9) | ((now.getMonth() + 1) << 5) | now.getDate();
        }

        function concatUint8Arrays(parts) {
            const totalLength = parts.reduce((total, part) => total + part.length, 0);
            const result = new Uint8Array(totalLength);
            let offset = 0;
            parts.forEach(part => {
                result.set(part, offset);
                offset += part.length;
            });
            return result;
        }

        function createPdfReportBlob(report) {
            const pageWidth = 595;
            const pageHeight = 842;
            const margin = 36;
            const pages = [];
            let content = [];
            let y = 0;

            const addLine = line => content.push(line);
            const addText = (text, x, textY, size = 9, bold = false) => {
                addLine(`0 0 0 rg`);
                addLine(`BT /F${bold ? 2 : 1} ${size} Tf ${x} ${textY} Td (${escapePdfText(text)}) Tj ET`);
            };
            const addRect = (x, rectY, w, h, fill = null, stroke = null) => {
                if (fill) addLine(`${fill} rg ${x} ${rectY} ${w} ${h} re f`);
                if (stroke) addLine(`${stroke} RG ${x} ${rectY} ${w} ${h} re S`);
            };

            const startPage = (pageNumber) => {
                content = [];
                pages.push(content);

                if (pageNumber === 1) {
                    y = 800;
                    addText('Laporan Data UMKM Desa Tanahbaru', margin, y, 16, true);
                    addText(`Periode: ${formatDisplayDate(report.start)} s/d ${formatDisplayDate(report.end)}`, margin, y - 18, 9);
                    addText(`Dibuat: ${formatDateTime(report.generatedAt)}`, margin, y - 30, 8);

                    // Add Summary Box in Portrait - moved lower
                    const summaryY = 680;
                    addSummaryBox('Total UMKM', report.summary.total, 36, summaryY, 115, addRect, addText);
                    addSummaryBox('Aktif UMKM', report.summary.aktif, 161, summaryY, 115, addRect, addText);
                    addSummaryBox('Pending UMKM', report.summary.pending, 286, summaryY, 115, addRect, addText);
                    addSummaryBox('Total Produk', report.summary.produk, 411, summaryY, 115, addRect, addText);
                    y = 600;
                } else {
                    y = 800;
                    addText('Laporan Data UMKM Desa Tanahbaru', margin, y, 12, true);
                    addText(`Lanjutan periode ${formatDisplayDate(report.start)} s/d ${formatDisplayDate(report.end)}`, margin, y - 14, 8);
                    y = 760;
                }
            };

            startPage(1);

            report.rows.forEach((row, index) => {
                const rowData = { ...row, no: index + 1 };
                
                const fields = [
                    { label: 'Nama Usaha', value: rowData.namaUsaha },
                    { label: 'Pemilik', value: rowData.pemilik },
                    { label: 'NIK', value: rowData.nik },
                    { label: 'Email', value: rowData.email },
                    { label: 'WhatsApp', value: rowData.wa },
                    { label: 'Kategori', value: rowData.kategori },
                    { label: 'Skala Usaha', value: rowData.skalaUsaha },
                    { label: 'Bentuk Usaha', value: rowData.bentukUsaha },
                    { label: 'Modal Kerja', value: 'Rp ' + Number(rowData.modalKerja).toLocaleString('id-ID') },
                    { label: 'Status', value: rowData.status },
                    { label: 'Jumlah Produk', value: String(rowData.jumlahProduk) }
                ];

                const alamatLines = wrapPdfText(rowData.alamat, 380);
                const deskripsiLines = wrapPdfText(rowData.deskripsi, 380);

                const headerHeight = 18;
                const fieldsHeight = fields.length * 12;
                const alamatHeight = alamatLines.length * 12;
                const deskripsiHeight = deskripsiLines.length * 12;
                const blockHeight = headerHeight + fieldsHeight + alamatHeight + deskripsiHeight + 20;

                if (y - blockHeight < 50) {
                    startPage(pages.length + 1);
                }

                // Draw UMKM Header
                addRect(margin, y - 18, pageWidth - (margin * 2), 18, '0.93 0.95 0.98');
                addText(`UMKM #${index + 1}`, margin + 10, y - 13, 9, true);
                y -= 18;

                // Draw Simple Fields
                fields.forEach(field => {
                    addText(field.label, margin + 10, y - 10, 8, true);
                    addText(`: ${field.value}`, margin + 120, y - 10, 8);
                    y -= 12;
                });

                // Draw Alamat
                addText('Alamat', margin + 10, y - 10, 8, true);
                alamatLines.forEach((line, lineIdx) => {
                    addText(lineIdx === 0 ? `: ${line}` : line, lineIdx === 0 ? margin + 120 : margin + 126, y - 10, 8);
                    y -= 12;
                });

                // Draw Deskripsi
                addText('Deskripsi', margin + 10, y - 10, 8, true);
                deskripsiLines.forEach((line, lineIdx) => {
                    addText(lineIdx === 0 ? `: ${line}` : line, lineIdx === 0 ? margin + 120 : margin + 126, y - 10, 8);
                    y -= 12;
                });

                y -= 6;
                addLine(`0.8 0.8 0.8 RG ${margin} ${y} m ${pageWidth - margin} ${y} l S`);
                y -= 14; 
            });

            pages.forEach((page, index) => {
                page.push(`0.75 0.79 0.86 RG ${margin} 34 m ${pageWidth - margin} 34 l S`);
                page.push(`0 0 0 rg BT /F1 7 Tf ${margin} 20 Td (${escapePdfText(`Halaman ${index + 1} dari ${pages.length}`)}) Tj ET`);
            });

            return new Blob([buildPdfDocument(pages, pageWidth, pageHeight)], { type: 'application/pdf' });
        }

        function addSummaryBox(label, value, x, y, w, addRect, addText) {
            addRect(x, y, w, 44, '1 0.97 0.93', '0.98 0.82 0.67');
            addText(label, x + 10, y + 27, 8);
            addText(String(value), x + 10, y + 10, 15, true);
        }

        function buildPdfDocument(pages, pageWidth, pageHeight) {
            const objects = {};
            const pageRefs = [];
            let nextObject = 5;

            pages.forEach(page => {
                const pageObject = nextObject++;
                const contentObject = nextObject++;
                pageRefs.push(`${pageObject} 0 R`);
                objects[pageObject] = `<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ${pageWidth} ${pageHeight}] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents ${contentObject} 0 R >>`;

                const stream = page.join('\n');
                objects[contentObject] = `<< /Length ${stream.length} >>\nstream\n${stream}\nendstream`;
            });

            objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
            objects[2] = `<< /Type /Pages /Kids [${pageRefs.join(' ')}] /Count ${pages.length} >>`;
            objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';
            objects[4] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>';

            const maxObject = nextObject - 1;
            let pdf = '%PDF-1.4\n';
            const offsets = [0];

            for (let i = 1; i <= maxObject; i++) {
                offsets[i] = pdf.length;
                pdf += `${i} 0 obj\n${objects[i]}\nendobj\n`;
            }

            const xrefOffset = pdf.length;
            pdf += `xref\n0 ${maxObject + 1}\n0000000000 65535 f \n`;
            for (let i = 1; i <= maxObject; i++) {
                pdf += `${String(offsets[i]).padStart(10, '0')} 00000 n \n`;
            }
            pdf += `trailer\n<< /Size ${maxObject + 1} /Root 1 0 R >>\nstartxref\n${xrefOffset}\n%%EOF`;

            return pdf;
        }

        function downloadBlob(blob, filename, mimeType) {
            const fileBlob = blob instanceof Blob ? blob : new Blob([blob], { type: mimeType });
            const url = URL.createObjectURL(fileBlob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            link.remove();
            setTimeout(() => URL.revokeObjectURL(url), 1000);
        }

        function formatDisplayDate(value) {
            const date = new Date(`${value}T12:00:00`);
            if (Number.isNaN(date.getTime())) return value;
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        }

        function formatDateTime(value) {
            return value.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function columnName(index) {
            let name = '';
            while (index > 0) {
                const modulo = (index - 1) % 26;
                name = String.fromCharCode(65 + modulo) + name;
                index = Math.floor((index - modulo) / 26);
            }
            return name;
        }

        function escapeXml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&apos;');
        }

        function escapePdfText(value) {
            return String(value ?? '')
                .normalize('NFKD')
                .replace(/[^\x20-\x7E]/g, ' ')
                .replace(/\\/g, '\\\\')
                .replace(/\(/g, '\\(')
                .replace(/\)/g, '\\)')
                .trim();
        }

        function truncatePdfText(value, width) {
            const text = String(value ?? '').normalize('NFKD').replace(/[^\x20-\x7E]/g, ' ').trim();
            const maxLength = Math.max(3, Math.floor(width / 4.1));
            return text.length > maxLength ? `${text.slice(0, maxLength - 3)}...` : text;
        }

        function wrapPdfText(value, width) {
            const text = String(value ?? '').normalize('NFKD').replace(/[^\x20-\x7E]/g, ' ').trim();
            const maxChars = Math.max(3, Math.floor(width / 3.9));
            if (text.length <= maxChars) {
                return [text];
            }

            const words = text.split(' ');
            const lines = [];
            let currentLine = '';

            words.forEach(word => {
                if (word.length > maxChars) {
                    if (currentLine) {
                        lines.push(currentLine);
                        currentLine = '';
                    }
                    let remaining = word;
                    while (remaining.length > maxChars) {
                        lines.push(remaining.slice(0, maxChars));
                        remaining = remaining.slice(maxChars);
                    }
                    currentLine = remaining;
                } else {
                    const testLine = currentLine ? `${currentLine} ${word}` : word;
                    if (testLine.length > maxChars) {
                        lines.push(currentLine);
                        currentLine = word;
                    } else {
                        currentLine = testLine;
                    }
                }
            });

            if (currentLine) {
                lines.push(currentLine);
            }

            return lines.length > 0 ? lines : [''];
        }
        