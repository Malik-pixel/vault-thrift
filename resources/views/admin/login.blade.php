<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Masuk Konsol Kurator — VAULT Curated Thrift</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "on-surface": "#1a1b22",
                        "on-surface-variant": "#47464a",
                        "surface-container-high": "#e8e7f1",
                        "surface-container-low": "#f4f2fd",
                        "surface-container": "#eeedf7",
                        "surface-container-lowest": "#ffffff",
                        "surface": "#fbf8ff",
                        "secondary-fixed": "#E6FD52",
                        "secondary-container": "#E6FD52",
                        "secondary": "#596400",
                        "outline": "#71717A",
                        "outline-variant": "#c8c5ca",
                        "primary": "#0F0F11",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a"
                    },
                    borderRadius: { DEFAULT: "0px", full: "9999px" },
                    fontFamily: {
                        "body-md": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "headline-lg": ["Space Grotesk", "sans-serif"],
                        "headline-md": ["Space Grotesk", "sans-serif"],
                        "label-lg": ["Space Grotesk", "sans-serif"],
                        "label-md": ["Space Grotesk", "sans-serif"],
                        "label-sm": ["Space Grotesk", "sans-serif"]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-secondary-fixed selection:text-primary">
<div class="min-h-screen flex flex-col justify-between bg-surface">
    <!-- Top Bar -->
    <header class="w-full bg-surface-container-lowest px-4 md:px-12 py-3 border-b border-outline-variant flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-primary"></span>
                <span class="font-headline-md text-lg font-bold tracking-tight uppercase text-primary">VAULT / ADMIN CONSOLE</span>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 bg-secondary-container border border-primary text-primary font-label-sm text-[10px] font-bold uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                LARAGON // LOCAL ENGINE SECURE
            </span>
        </div>
        <div class="flex items-center gap-4">
            <a class="inline-flex items-center gap-1 font-label-md text-[11px] font-bold text-on-surface-variant hover:text-primary uppercase transition-colors" href="{{ route('home') }}">
                <span class="material-symbols-outlined text-[14px]">arrow_back</span>PUBLIC STORE
            </a>
            <div class="w-8 h-8 bg-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
            </div>
        </div>
    </header>

    <!-- Main Auth Dossier -->
    <main class="flex-1 flex flex-col items-center justify-center px-4 md:px-12 py-10 bg-surface">
        <div class="flex flex-col w-full max-w-4xl mx-auto">
            <div class="w-full flex flex-wrap items-center justify-between gap-y-2 pb-3 text-on-surface-variant font-label-sm text-[10px] uppercase">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-secondary-fixed border border-primary"></span>
                    <span class="text-primary font-headline-md font-bold tracking-widest text-[11px]">GATEWAY / RESTRICTED ENTRYPOINT</span>
                    <span class="px-1.5 py-0.5 bg-surface-container-high border border-outline-variant text-on-surface">LVL-01 CLEARANCE</span>
                </div>
                <div class="flex items-center gap-4">
                    <span>STACK: <strong class="text-primary">LARAVEL 10 + MYSQL</strong></span>
                    <span>AUTH: <strong class="text-secondary font-bold">BCRYPT + RATE LIMIT</strong></span>
                </div>
            </div>

            <div class="w-full bg-surface-container-lowest border border-primary shadow-[0_6px_0_#0F0F11] flex flex-col md:flex-row overflow-hidden">
                <!-- Left Column: Login Form -->
                <div class="flex-1 p-6 md:p-10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4">
                            <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-primary text-on-primary font-label-sm text-[10px] tracking-widest uppercase">
                                <span class="material-symbols-outlined text-[12px] text-secondary-fixed">lock</span>
                                RESTRICTED ACCESS // AUTH PROTOCOL
                            </div>
                            <span class="font-label-sm text-[10px] text-on-surface-variant tracking-wider">VER: 1.0-LARAGON</span>
                        </div>

                        <div class="space-y-1 pb-5">
                            <h1 class="font-headline-lg text-2xl md:text-3xl font-bold uppercase text-primary tracking-tight">
                                MASUK KONSOL KURATOR
                            </h1>
                            <p class="font-body-md text-sm text-on-surface-variant">
                                Portal internal khusus <span class="text-primary font-semibold">1 akun Super Admin</span> untuk manajemen inventaris 1-of-1, verifikasi pesanan WhatsApp, dan pembaruan stok.
                            </p>
                        </div>

                        <div class="w-full bg-surface-container-low border border-outline-variant p-2.5 flex items-center justify-between mb-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-secondary-fixed border border-primary animate-ping"></span>
                                <span class="font-label-md text-[11px] font-bold uppercase text-on-surface">Laragon / MySQL Database Live</span>
                            </div>
                            <span class="font-label-sm text-[10px] font-bold text-primary px-2 py-0.5 bg-secondary-container border border-primary">SESSION CSRF PROTECTED</span>
                        </div>

                        @if(session('status'))
                            <div class="mb-4 p-3 bg-secondary-container border border-primary text-primary text-xs font-bold uppercase">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-4 p-3 bg-error-container border border-error text-on-error-container text-xs font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">error</span>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif

                        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <label class="font-label-md text-[11px] font-bold uppercase text-primary tracking-wider flex items-center gap-1" for="email">
                                        <span class="material-symbols-outlined text-[14px]">shield_person</span>
                                        Email Kurator
                                    </label>
                                    <span class="font-label-sm text-[10px] text-on-surface-variant">SINGLE ADMIN SEAT</span>
                                </div>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    required
                                    autofocus
                                    value="{{ old('email') }}"
                                    placeholder="rian.kurator@vault.archive"
                                    class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:border-[1.5px] px-4 py-2.5 text-sm text-primary placeholder:text-outline focus:outline-none"
                                />
                            </div>

                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <label class="font-label-md text-[11px] font-bold uppercase text-primary tracking-wider flex items-center gap-1" for="password">
                                        <span class="material-symbols-outlined text-[14px]">key</span>
                                        Master Security Password
                                    </label>
                                    <button type="button" onclick="togglePassVisibility()" class="font-label-sm text-[10px] font-bold text-secondary hover:text-primary uppercase tracking-wider inline-flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-[13px]" id="eye-icon">visibility</span>
                                        <span id="eye-text">Tampilkan</span>
                                    </button>
                                </div>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    placeholder="••••••••••••••••••••"
                                    class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:border-[1.5px] px-4 py-2.5 text-sm text-primary placeholder:text-outline focus:outline-none"
                                />
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <input name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 accent-primary cursor-pointer"/>
                                    <span class="text-xs text-on-surface">Ingat sesi workstation ini</span>
                                </label>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full bg-primary text-on-primary py-3 px-4 font-label-lg text-[13px] font-bold tracking-widest uppercase hover:bg-secondary-fixed hover:text-primary border border-primary transition-colors flex items-center justify-center gap-2 group">
                                    <span>OTORISASI &amp; MASUK KE DASHBOARD</span>
                                    <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </button>
                            </div>
                        </form>

                        <div class="flex flex-wrap items-center justify-between pt-6 font-label-md text-[11px] text-on-surface-variant uppercase">
                            <span>Rate Limit: Maks 5x / menit</span>
                            <a class="hover:text-primary transition-colors flex items-center gap-1 font-bold" href="{{ route('catalog') }}">
                                <span class="material-symbols-outlined text-[13px]">storefront</span>
                                Buka Katalog Publik
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Visual Dossier Panel -->
                <div class="w-full md:w-80 bg-surface-container border-t md:border-t-0 md:border-l border-outline-variant flex flex-col justify-between p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-widest">DOSSIER IDENTITY</span>
                            <span class="w-2 h-2 bg-secondary-fixed border border-primary"></span>
                        </div>

                        <div class="bg-surface-container-lowest border border-outline-variant p-2.5 space-y-2">
                            <div class="relative aspect-square w-full overflow-hidden bg-surface-container-high border border-outline-variant">
                                <img src="{{ asset('images/stitch/login-dossier.jpg') }}" alt="VAULT Archive Piece" class="w-full h-full object-cover grayscale contrast-125"/>
                                <div class="absolute top-2 left-2 bg-primary text-on-primary px-1.5 py-0.5 font-label-sm text-[10px] tracking-widest uppercase">
                                    1-OF-1 ARCHIVE
                                </div>
                                <div class="absolute bottom-2 right-2 bg-secondary-fixed border border-primary text-primary px-1.5 py-0.5 font-label-sm text-[10px] font-bold">
                                    #VLT-0001
                                </div>
                            </div>
                            <div class="pt-1">
                                <span class="font-label-sm text-[10px] text-on-surface-variant block uppercase">SYSTEM ARCHITECTURE</span>
                                <span class="font-headline-md text-sm font-bold text-primary block uppercase">VAULT CURATED THRIFT</span>
                            </div>
                        </div>

                        <div class="space-y-1.5 text-[10px] font-label-sm uppercase">
                            <span class="text-on-surface-variant tracking-wider block">CLEARANCE MATRIX</span>
                            <div class="flex items-center justify-between py-1.5 bg-surface-container-lowest border border-outline-variant px-2">
                                <span>STOCK SYNC (1-OF-1)</span>
                                <span class="text-secondary font-bold">ATOMIC TX</span>
                            </div>
                            <div class="flex items-center justify-between py-1.5 bg-surface-container-lowest border border-outline-variant px-2">
                                <span>WHATSAPP ORDER LOG</span>
                                <span class="text-secondary font-bold">LIVE</span>
                            </div>
                            <div class="flex items-center justify-between py-1.5 bg-surface-container-lowest border border-outline-variant px-2">
                                <span>ADMIN LIMIT</span>
                                <span class="text-primary font-bold">1 SUPER ADMIN</span>
                            </div>
                        </div>
                    </div>

                    <p class="pt-6 font-label-sm text-[10px] text-on-surface-variant leading-relaxed">
                        <strong>PERINGATAN SISTEM:</strong> Akses dibatasi khusus kurator resmi. Kata sandi di-hash dengan bcrypt dan dilindungi pembatasan percobaan login.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full px-4 md:px-12 py-3 border-t border-outline-variant flex flex-col sm:flex-row items-center justify-between text-on-surface-variant font-label-sm text-[10px] uppercase gap-1 bg-surface-container-lowest">
        <span>VAULT CURATED THRIFT © {{ date('Y') }} ARCHIVE SYSTEM</span>
        <span>LARAVEL 10 • MYSQL • COOKIE HTTPONLY SAMESITE</span>
    </footer>
</div>

<script>
    function togglePassVisibility() {
        const input = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeText = document.getElementById('eye-text');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.textContent = 'visibility_off';
            eyeText.textContent = 'Sembunyikan';
        } else {
            input.type = 'password';
            eyeIcon.textContent = 'visibility';
            eyeText.textContent = 'Tampilkan';
        }
    }
</script>
</body>
</html>

