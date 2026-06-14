                 <!-- LOGIN MODULE -->
                    <div id="loginModule" class="space-y-6">
                        <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-4">
                            <!-- Inputs -->
                            <div class="space-y-1.5">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Alamat Email</label>
                                <input type="email" id="loginEmail" required placeholder="nama@email.com" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:border-brand-500 focus:bg-white rounded-xl outline-none text-xs font-medium transition">
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Kata Sandi</label>
                                    <a href="#" onclick="showToast('Hubungi Pemdes Tanahbaru untuk menyetel ulang kata sandi Anda.', 'info')" class="text-[10px] font-semibold text-brand-600 hover:underline">Lupa Sandi?</a>
                                </div>
                                <div class="relative">
                                    <input type="password" id="loginPassword" required placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 focus:border-brand-500 focus:bg-white rounded-xl outline-none text-xs font-medium transition">
                                    <button type="button" onclick="togglePasswordVisibility('loginPassword', 'loginEyeIcon')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                        <i class="fa-solid fa-eye-slash text-xs" id="loginEyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2 text-xs">
                                <span>Masuk ke Dashboard</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

