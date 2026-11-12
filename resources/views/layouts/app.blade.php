<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'VAULT CURATED THRIFT — Archive Streetwear & Vintage')</title>
    <meta name="description" content="@yield('meta_description', 'Katalog curated thrift & archive streetwear 1-of-1 di Indonesia. 100% original, grading kondisi jujur 1-10, ukuran cm presisi, order cepat via WhatsApp.')"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
        }
        .tabular-nums { font-variant-numeric: tabular-nums; }
        .hard-shadow { box-shadow: 0px 4px 0px 0px #0F0F11; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-surface": "#1a1b22",
                        "on-surface-variant": "#47464a",
                        "on-secondary-container": "#0F0F11",
                        "inverse-surface": "#2f3038",
                        "tertiary-fixed-dim": "#ffb690",
                        "on-tertiary-fixed-variant": "#783200",
                        "on-tertiary": "#ffffff",
                        "surface-container-highest": "#e3e1ec",
                        "tertiary-fixed": "#ffdbca",
                        "inverse-primary": "#c8c6c8",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff",
                        "on-primary-fixed": "#1b1b1d",
                        "on-tertiary-container": "#d95f00",
                        "surface-tint": "#5f5e60",
                        "surface": "#fbf8ff",
                        "on-primary-fixed-variant": "#474649",
                        "secondary-fixed": "#E6FD52",
                        "on-secondary": "#ffffff",
                        "on-background": "#1a1b22",
                        "primary-fixed": "#e5e1e4",
                        "surface-container": "#eeedf7",
                        "secondary-container": "#E6FD52",
                        "surface-container-low": "#f4f2fd",
                        "tertiary-container": "#F97316",
                        "surface-bright": "#fbf8ff",
                        "primary-fixed-dim": "#c8c6c8",
                        "secondary-fixed-dim": "#bcd226",
                        "background": "#fbf8ff",
                        "outline-variant": "#c8c5ca",
                        "on-tertiary-fixed": "#341100",
                        "secondary": "#596400",
                        "surface-dim": "#dad9e3",
                        "surface-variant": "#e3e1ec",
                        "tertiary": "#F97316",
                        "inverse-on-surface": "#f1effa",
                        "on-error-container": "#93000a",
                        "on-secondary-fixed-variant": "#424b00",
                        "error-container": "#ffdad6",
                        "outline": "#71717A",
                        "error": "#ba1a1a",
                        "surface-container-high": "#e8e7f1",
                        "primary": "#0F0F11",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#858386",
                        "on-secondary-fixed": "#191e00",
                        "primary-container": "#1b1b1d"
                    },
                    borderRadius: {
                        DEFAULT: "0px",
                        none: "0px",
                        sm: "0px",
                        md: "0px",
                        lg: "0px",
                        xl: "0px",
                        full: "9999px"
                    },
                    spacing: {
                        "space-lg": "1.5rem",
                        "margin-tablet": "2rem",
                        "space-md": "1rem",
                        "gutter-desktop": "1.5rem",
                        "margin-desktop": "3rem",
                        "gutter": "1rem",
                        "margin": "1rem",
                        "space-sm": "0.5rem",
                        "space-xs": "0.25rem",
                        "space-xl": "2.5rem"
                    },
                    fontFamily: {
                        "body-md": ["Inter", "sans-serif"],
                        "label-lg": ["Space Grotesk", "sans-serif"],
                        "label-md": ["Space Grotesk", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "headline-lg": ["Space Grotesk", "sans-serif"],
                        "display-lg": ["Space Grotesk", "sans-serif"],
                        "label-sm": ["Space Grotesk", "sans-serif"],
                        "display-lg-mobile": ["Space Grotesk", "sans-serif"],
                        "headline-lg-mobile": ["Space Grotesk", "sans-serif"],
                        "headline-md": ["Space Grotesk", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"]
                    },
                    fontSize: {
                        "body-md": ["14px", { lineHeight: "20px", letterSpacing: "0em", fontWeight: "400" }],
                        "label-lg": ["13px", { lineHeight: "16px", letterSpacing: "0.06em", fontWeight: "700" }],
                        "label-md": ["11px", { lineHeight: "14px", letterSpacing: "0.08em", fontWeight: "600" }],
                        "body-sm": ["12px", { lineHeight: "16px", letterSpacing: "0.01em", fontWeight: "400" }],
                        "headline-lg": ["32px", { lineHeight: "36px", letterSpacing: "-0.03em", fontWeight: "700" }],
                        "display-lg": ["56px", { lineHeight: "60px", letterSpacing: "-0.04em", fontWeight: "700" }],
                        "label-sm": ["10px", { lineHeight: "12px", letterSpacing: "0.1em", fontWeight: "600" }],
                        "display-lg-mobile": ["36px", { lineHeight: "40px", letterSpacing: "-0.03em", fontWeight: "700" }],
                        "headline-lg-mobile": ["24px", { lineHeight: "28px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "headline-md": ["20px", { lineHeight: "26px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "body-lg": ["16px", { lineHeight: "24px", letterSpacing: "-0.01em", fontWeight: "400" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-secondary-container selection:text-primary overflow-x-hidden">

<!-- FIXED TOP TICKER & NAVBAR -->
<header class="fixed top-0 left-0 right-0 z-50 bg-surface/90 backdrop-blur-xl border-b border-outline-variant/60">
    <!-- Ticker Bar (FR-01) -->
    <div class="bg-primary text-surface px-margin py-space-xs overflow-hidden border-b border-primary">
        <div class="max-w-[1440px] mx-auto flex items-center justify-center">
            <div class="w-full flex items-center justify-center gap-space-md whitespace-nowrap overflow-hidden">
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">
                    {{ $storeSettings['ticker_text'] }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Navbar (FR-02, FR-03) -->
    <div class="h-16 md:h-20 max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex items-center justify-between gap-space-md">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-space-sm shrink-0 group">
            <div class="w-9 h-9 bg-primary text-secondary-container flex items-center justify-center font-headline-md font-bold text-lg border border-primary group-hover:bg-secondary-container group-hover:text-primary transition-colors">
                V/
            </div>
            <div class="flex flex-col">
                <span class="font-headline-md text-headline-md tracking-tight uppercase text-primary leading-none font-bold">VAULT</span>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant leading-tight">CURATED THRIFT</span>
            </div>
        </a>

        <!-- Global Search Bar (FR-03) -->
        <form action="{{ route('catalog') }}" method="GET" class="hidden lg:flex items-center flex-1 max-w-sm mx-space-md">
            <div class="w-full flex items-center gap-space-xs bg-surface-container px-space-md py-space-xs border border-outline-variant focus-within:border-primary focus-within:border-[1.5px]">
                <span class="material-symbols-outlined text-outline text-[18px]">search</span>
                <input
                    name="q"
                    value="{{ request('q') }}"
                    class="w-full bg-transparent font-body-sm text-body-sm text-on-surface placeholder:text-outline focus:outline-none"
                    placeholder="Cari vintage tee, stussy, carhartt..."
                    type="text"
                />
                @if(request('q'))
                    <a href="{{ route('catalog') }}" class="text-outline hover:text-primary"><span class="material-symbols-outlined text-[16px]">close</span></a>
                @endif
            </div>
        </form>

        <!-- Primary Navigation -->
        <nav class="hidden xl:flex items-center gap-space-lg">
            <a href="{{ route('home') }}" class="font-label-md text-label-md uppercase tracking-wider transition-colors {{ request()->routeIs('home') ? 'text-primary font-bold underline underline-offset-4 decoration-2' : 'text-on-surface-variant hover:text-primary' }}">
                Beranda
            </a>
            <a href="{{ route('catalog') }}" class="font-label-md text-label-md uppercase tracking-wider transition-colors {{ request()->routeIs('catalog') ? 'text-primary font-bold underline underline-offset-4 decoration-2' : 'text-on-surface-variant hover:text-primary' }}">
                Katalog Produk
            </a>

            <!-- Kategori Dropdown -->
            <div class="relative group">
                <button type="button" class="inline-flex items-center gap-1 font-label-md text-label-md uppercase tracking-wider text-on-surface-variant hover:text-primary transition-colors py-2">
                    <span>Kategori</span>
                    <span class="material-symbols-outlined text-[16px]">expand_more</span>
                </button>
                <div class="hidden group-hover:block absolute left-0 top-full w-60 bg-surface-container-lowest border border-primary hard-shadow z-50">
                    <div class="p-2 border-b border-outline-variant bg-surface-container-low font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">
                        Pilih Segmen Arsip
                    </div>
                    <a href="{{ route('catalog') }}" class="block px-4 py-2.5 font-label-md text-label-md uppercase text-primary hover:bg-secondary-container transition-colors border-b border-outline-variant/40">
                        Semua Produk
                    </a>
                    @foreach($navCategories as $navCat)
                        <a href="{{ route('catalog', ['kategori' => $navCat->slug]) }}" class="block px-4 py-2.5 font-label-md text-label-md uppercase text-on-surface hover:bg-secondary-container transition-colors border-b border-outline-variant/40 last:border-b-0">
                            {{ $navCat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('about') }}" class="font-label-md text-label-md uppercase tracking-wider transition-colors {{ request()->routeIs('about') ? 'text-primary font-bold underline underline-offset-4 decoration-2' : 'text-on-surface-variant hover:text-primary' }}">
                Tentang Kami
            </a>
        </nav>

        <!-- Actions: Tanya Admin WA + Saved + Admin + Mobile Menu -->
        <div class="flex items-center gap-space-xs sm:gap-space-sm">
            @php
                $askAdminUrl = 'https://wa.me/' . $storeSettings['whatsapp_clean'] . '?text=' . rawurlencode('Halo Admin VAULT Curated Thrift, saya ingin bertanya tentang koleksi arsip yang tersedia.');
            @endphp
            <a href="{{ $askAdminUrl }}" target="_blank" rel="noopener noreferrer" class="hidden sm:flex items-center gap-space-xs bg-secondary-container text-primary border border-primary px-space-md py-space-xs hover:bg-primary hover:text-secondary-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                <span class="font-label-md text-label-md uppercase tracking-wider font-bold">Tanya Admin</span>
            </a>

            <a href="{{ route('saved') }}" class="relative p-2 text-on-surface-variant hover:text-primary border border-transparent hover:border-outline-variant transition-colors" title="Item Tersimpan (Wishlist)">
                <span class="material-symbols-outlined text-[22px]">bookmark</span>
                <span id="nav-saved-count" class="hidden absolute -top-1 -right-1 bg-primary text-secondary-container font-label-sm text-[9px] px-1 min-w-[16px] text-center font-bold">0</span>
            </a>

            <a href="{{ auth()->check() ? route('admin.dashboard') : route('admin.login') }}" class="hidden sm:flex w-8 h-8 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary items-center justify-center transition-colors" title="Konsol Kurator Admin">
                <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
            </a>

            <button type="button" id="mobile-menu-btn" class="xl:hidden p-2 border border-outline-variant text-primary hover:bg-surface-container" aria-label="Buka Menu">
                <span class="material-symbols-outlined text-[22px]">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Slide-down Menu -->
    <div id="mobile-menu-drawer" class="hidden xl:hidden bg-surface-container-lowest border-t border-outline-variant px-margin py-space-md">
        <form action="{{ route('catalog') }}" method="GET" class="mb-space-md">
            <div class="flex items-center bg-surface-container border border-outline-variant px-space-sm py-space-xs">
                <span class="material-symbols-outlined text-outline text-[18px] mr-2">search</span>
                <input name="q" value="{{ request('q') }}" class="w-full bg-transparent text-body-sm focus:outline-none" placeholder="Cari artikel, brand, SKU..." type="text"/>
            </div>
        </form>
        <div class="flex flex-col gap-1 font-label-md text-label-md uppercase tracking-wider">
            <a href="{{ route('home') }}" class="py-2 px-3 {{ request()->routeIs('home') ? 'bg-primary text-on-primary' : 'hover:bg-surface-container' }}">Beranda</a>
            <a href="{{ route('catalog') }}" class="py-2 px-3 {{ request()->routeIs('catalog') ? 'bg-primary text-on-primary' : 'hover:bg-surface-container' }}">Katalog Produk</a>
            <div class="py-1 px-3 text-label-sm text-outline">Kategori:</div>
            <div class="grid grid-cols-2 gap-1 pl-3 pb-2">
                @foreach($navCategories as $navCat)
                    <a href="{{ route('catalog', ['kategori' => $navCat->slug]) }}" class="py-1.5 px-2 bg-surface-container-low hover:bg-secondary-container text-primary text-label-sm">{{ $navCat->name }}</a>
                @endforeach
            </div>
            <a href="{{ route('about') }}" class="py-2 px-3 {{ request()->routeIs('about') ? 'bg-primary text-on-primary' : 'hover:bg-surface-container' }}">Tentang Kami</a>
            <a href="{{ route('saved') }}" class="py-2 px-3 hover:bg-surface-container">Tersimpan (Bookmark)</a>
            <a href="{{ $askAdminUrl }}" target="_blank" class="mt-2 py-2.5 px-3 bg-secondary-container text-primary font-bold flex items-center justify-center gap-2 border border-primary">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                Tanya Admin via WhatsApp
            </a>
        </div>
    </div>
</header>

<main class="w-full pt-[92px] md:pt-[108px] bg-surface min-h-screen">
    @yield('content')
</main>

<!-- FOOTER (FR-04) -->
<footer class="w-full bg-surface-container-low text-on-surface pt-space-xl pb-space-lg border-t border-outline-variant">
    <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-xl">
        <div class="flex flex-col gap-space-md">
            <div class="flex flex-col">
                <span class="font-headline-md text-headline-md tracking-tight uppercase text-primary leading-none font-bold">VAULT</span>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant leading-tight">CURATED THRIFT</span>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                Platform kurasi arsip streetwear dan vintage terpilih di Indonesia. Setiap artikel melewati proses autentikasi ketat, grading presisi, serta sterilisasi siap pakai.
            </p>
            <div class="flex flex-col gap-space-xs font-body-sm text-body-sm text-on-surface-variant">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Jam Operasional:</span>
                <span>{{ $storeSettings['operating_hours'] }}</span>
                <span class="mt-space-xs font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Studio Kurasi:</span>
                <span>{{ $storeSettings['studio_address'] }}</span>
            </div>
        </div>

        <div class="flex flex-col gap-space-md">
            <span class="font-label-lg text-label-lg uppercase tracking-wider text-primary">Kategori Populer</span>
            <ul class="flex flex-col gap-space-xs font-body-md text-body-md text-on-surface-variant">
                @foreach($navCategories as $navCat)
                    <li>
                        <a class="hover:text-primary transition-colors" href="{{ route('catalog', ['kategori' => $navCat->slug]) }}">
                            {{ $navCat->name }}
                        </a>
                    </li>
                @endforeach
                <li><a class="hover:text-primary transition-colors" href="{{ route('catalog', ['status' => 'available']) }}">Stok Tersedia (1-of-1)</a></li>
                <li><a class="hover:text-primary transition-colors" href="{{ route('catalog', ['status' => 'sold']) }}">Arsip Terjual</a></li>
            </ul>
        </div>

        <div class="flex flex-col gap-space-md">
            <span class="font-label-lg text-label-lg uppercase tracking-wider text-primary">Bantuan &amp; Belanja</span>
            <ul class="flex flex-col gap-space-xs font-body-md text-body-md text-on-surface-variant">
                <li><a class="hover:text-primary transition-colors" href="{{ route('about') }}#protokol">Protokol Kurasi &amp; Keaslian</a></li>
                <li><a class="hover:text-primary transition-colors" href="{{ route('about') }}#studio">Lokasi Studio &amp; Fitting</a></li>
                <li><a class="hover:text-primary transition-colors" href="{{ route('about') }}#faq">Pertanyaan Umum (FAQ)</a></li>
                <li><a class="hover:text-primary transition-colors" href="{{ route('saved') }}">Daftar Tersimpan</a></li>
                <li><a class="hover:text-primary transition-colors" href="{{ route('admin.login') }}">Portal Admin Kurator</a></li>
            </ul>
        </div>

        <div class="flex flex-col gap-space-md">
            <span class="font-label-lg text-label-lg uppercase tracking-wider text-primary">Pembayaran &amp; Hotline</span>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Mendukung transfer rekening bank resmi dan metode instan:</p>
            <div class="flex flex-wrap gap-space-xs font-label-sm text-label-sm uppercase">
                <span class="bg-surface-container-lowest border border-outline-variant px-space-sm py-space-xs text-on-surface font-bold">BCA</span>
                <span class="bg-surface-container-lowest border border-outline-variant px-space-sm py-space-xs text-on-surface font-bold">Mandiri</span>
                <span class="bg-surface-container-lowest border border-outline-variant px-space-sm py-space-xs text-on-surface font-bold">BNI</span>
                <span class="bg-surface-container-lowest border border-outline-variant px-space-sm py-space-xs text-on-surface font-bold">QRIS</span>
            </div>
            <div class="flex flex-col gap-space-xs mt-space-sm">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Media Sosial &amp; Chat:</span>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Instagram: {{ $storeSettings['instagram_handle'] }}</span>
                <a class="font-body-sm text-body-sm text-primary font-semibold hover:underline" href="{{ $askAdminUrl }}" target="_blank" rel="noopener noreferrer">
                    WhatsApp Official Admin (+{{ $storeSettings['whatsapp_clean'] }})
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop mt-space-xl pt-space-md border-t border-outline-variant flex flex-col sm:flex-row items-center justify-between gap-space-sm font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant text-center sm:text-left">
        <span>© {{ date('Y') }} VAULT Curated Thrift. All Rights Reserved.</span>
        <span>Pre-loved streetwear &amp; curated archives.</span>
    </div>
</footer>

<!-- GLOBAL QUICK WHATSAPP ORDER MODAL (FR-30, FR-31, FR-32) -->
<div id="vault-wa-order-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-primary/75 backdrop-blur-sm p-4">
    <div class="bg-surface-container-lowest border border-primary hard-shadow w-full max-w-lg max-h-[92vh] overflow-y-auto">
        <div class="bg-primary text-on-primary px-space-md py-space-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                <span class="font-label-md text-label-md uppercase tracking-widest font-bold">FORM ORDER VIA WHATSAPP // 1-OF-1</span>
            </div>
            <button type="button" onclick="closeOrderModal()" class="text-surface hover:text-secondary-container p-1">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-space-md md:p-space-lg">
            <!-- Selected Product Summary -->
            <div class="bg-surface-container-low border border-outline-variant p-space-sm mb-space-md flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <span id="modal-product-sku" class="font-label-sm text-label-sm uppercase text-secondary font-bold block">#VLT-0000</span>
                    <p id="modal-product-name" class="font-headline-md text-[15px] font-bold uppercase text-primary truncate">Nama Produk</p>
                    <span id="modal-product-size" class="font-body-sm text-body-sm text-on-surface-variant">Size -</span>
                </div>
                <div class="text-right shrink-0">
                    <span class="font-label-sm text-[10px] uppercase text-outline block">HARGA PAS</span>
                    <span id="modal-product-price" class="font-headline-md text-headline-md font-bold text-primary tabular-nums">Rp 0</span>
                </div>
            </div>

            <!-- Form Step -->
            <form id="vault-wa-order-form" class="flex flex-col gap-space-sm">
                <input type="hidden" name="product_id" id="modal-product-id" value=""/>

                <div>
                    <label for="order_buyer_name" class="block font-label-sm text-label-sm uppercase tracking-wider text-primary mb-1">
                        Nama Lengkap Pembeli <span class="text-error">*</span>
                    </label>
                    <input id="order_buyer_name" name="buyer_name" required type="text" placeholder="Contoh: Dimas Aditya"
                           class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:border-[1.5px] px-3 py-2.5 text-body-md focus:outline-none"/>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                    <div>
                        <label for="order_buyer_phone" class="block font-label-sm text-label-sm uppercase tracking-wider text-primary mb-1">
                            Nomor WhatsApp Aktif <span class="text-error">*</span>
                        </label>
                        <input id="order_buyer_phone" name="buyer_phone" required type="text" placeholder="081234567890"
                               class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:border-[1.5px] px-3 py-2.5 text-body-md focus:outline-none"/>
                    </div>
                    <div>
                        <label for="order_buyer_city" class="block font-label-sm text-label-sm uppercase tracking-wider text-primary mb-1">
                            Kota / Kecamatan
                        </label>
                        <input id="order_buyer_city" name="buyer_city" type="text" placeholder="Jakarta Selatan"
                               class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:border-[1.5px] px-3 py-2.5 text-body-md focus:outline-none"/>
                    </div>
                </div>

                <div>
                    <label for="order_buyer_address" class="block font-label-sm text-label-sm uppercase tracking-wider text-primary mb-1">
                        Alamat Pengiriman Lengkap <span class="text-error">*</span>
                    </label>
                    <textarea id="order_buyer_address" name="buyer_address" required rows="2" placeholder="Jalan, nomor rumah, RT/RW, kode pos..."
                              class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:border-[1.5px] px-3 py-2 text-body-md focus:outline-none resize-none"></textarea>
                </div>

                <div>
                    <label for="order_payment_method" class="block font-label-sm text-label-sm uppercase tracking-wider text-primary mb-1">
                        Preferensi Metode Transfer
                    </label>
                    <select id="order_payment_method" name="payment_method"
                            class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary px-3 py-2.5 font-label-md text-label-md uppercase focus:outline-none">
                        <option value="BCA">Transfer Bank BCA</option>
                        <option value="Mandiri">Transfer Bank Mandiri</option>
                        <option value="BNI">Transfer Bank BNI</option>
                        <option value="QRIS">QRIS Instan</option>
                    </select>
                </div>

                <div class="bg-surface-container p-2.5 text-[11px] text-on-surface-variant leading-snug border-l-2 border-primary">
                    <strong>Info 1-of-1:</strong> Mengirim form akan mencatat pesanan <em>Menunggu Konfirmasi</em> dan membuka WhatsApp dengan detail artikel otomatis. Stok terkunci setelah pembayaran dikonfirmasi admin.
                </div>

                <div id="order-modal-error" class="hidden bg-error-container text-on-error-container px-3 py-2 text-body-sm font-medium"></div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeOrderModal()" class="px-4 py-2.5 border border-primary text-primary font-label-md text-label-md uppercase hover:bg-surface-container">
                        Batal
                    </button>
                    <button type="submit" id="order-submit-btn" class="flex-1 sm:flex-none px-5 py-2.5 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary font-label-lg text-label-lg uppercase tracking-wider flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        <span>Kirim &amp; Buka WhatsApp</span>
                    </button>
                </div>
            </form>

            <!-- Success State -->
            <div id="order-modal-success" class="hidden flex-col gap-space-sm">
                <div class="bg-secondary-container border border-primary p-space-md text-primary">
                    <div class="flex items-center gap-2 font-label-md text-label-md uppercase font-bold">
                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        <span>Pesanan Tercatat: <span id="success-order-no">ORD-2026-0001</span></span>
                    </div>
                    <p class="text-body-sm mt-1">Status: <strong>Menunggu Konfirmasi</strong>. Pesan WhatsApp Anda sudah siap dikirim ke admin kurator.</p>
                </div>
                <pre id="success-wa-preview" class="bg-surface-container-low border border-outline-variant p-3 text-[12px] font-body-sm whitespace-pre-wrap text-on-surface max-h-44 overflow-y-auto"></pre>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a id="success-wa-link" href="#" target="_blank" rel="noopener noreferrer" class="flex-1 py-3 px-4 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary font-label-lg text-label-lg uppercase tracking-wider text-center flex items-center justify-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                        <span>Buka WhatsApp Sekarang</span>
                    </a>
                    <button type="button" onclick="closeOrderModal()" class="py-3 px-4 border border-primary text-primary font-label-md text-label-md uppercase hover:bg-surface-container">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mobile Menu Toggle
    (function() {
        const btn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-menu-drawer');
        if (btn && drawer) {
            btn.addEventListener('click', () => drawer.classList.toggle('hidden'));
        }
    })();

    // LocalStorage Bookmark / Wishlist Engine
    const VAULT_SAVED_KEY = 'vault_saved_ids';
    function getSavedIds() {
        try {
            return JSON.parse(localStorage.getItem(VAULT_SAVED_KEY) || '[]').map(Number).filter(Boolean);
        } catch (e) {
            return [];
        }
    }
    function setSavedIds(ids) {
        localStorage.setItem(VAULT_SAVED_KEY, JSON.stringify([...new Set(ids)]));
        syncSavedBadges();
    }
    function toggleSaveProduct(productId, btnEl) {
        const id = Number(productId);
        let ids = getSavedIds();
        const exists = ids.includes(id);
        if (exists) {
            ids = ids.filter(x => x !== id);
        } else {
            ids.push(id);
        }
        setSavedIds(ids);
        if (btnEl) {
            const icon = btnEl.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = exists ? 'bookmark_border' : 'bookmark';
            btnEl.classList.toggle('bg-secondary-container', !exists);
        }
        window.dispatchEvent(new CustomEvent('vault:saved-updated', { detail: { ids } }));
    }
    function syncSavedBadges() {
        const ids = getSavedIds();
        const navBadge = document.getElementById('nav-saved-count');
        if (navBadge) {
            navBadge.textContent = ids.length;
            navBadge.classList.toggle('hidden', ids.length === 0);
        }
        document.querySelectorAll('[data-bookmark-id]').forEach(btn => {
            const id = Number(btn.getAttribute('data-bookmark-id'));
            const active = ids.includes(id);
            const icon = btn.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = active ? 'bookmark' : 'bookmark_border';
            btn.classList.toggle('bg-secondary-container', active);
        });
    }
    document.addEventListener('DOMContentLoaded', syncSavedBadges);

    // Quick Order WhatsApp Modal Logic
    function openOrderModal(btn) {
        const modal = document.getElementById('vault-wa-order-modal');
        const form = document.getElementById('vault-wa-order-form');
        const successBox = document.getElementById('order-modal-success');
        const errorBox = document.getElementById('order-modal-error');

        document.getElementById('modal-product-id').value = btn.dataset.productId;
        document.getElementById('modal-product-sku').textContent = btn.dataset.productSku;
        document.getElementById('modal-product-name').textContent = btn.dataset.productName;
        document.getElementById('modal-product-size').textContent = 'Size ' + btn.dataset.productSize;
        document.getElementById('modal-product-price').textContent = btn.dataset.productPrice;

        form.classList.remove('hidden');
        successBox.classList.add('hidden');
        successBox.classList.remove('flex');
        errorBox.classList.add('hidden');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeOrderModal() {
        const modal = document.getElementById('vault-wa-order-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('vault-wa-order-modal')?.addEventListener('click', function (e) {
        if (e.target === this) closeOrderModal();
    });

    document.getElementById('vault-wa-order-form')?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = this;
        const submitBtn = document.getElementById('order-submit-btn');
        const errorBox = document.getElementById('order-modal-error');
        const successBox = document.getElementById('order-modal-success');

        errorBox.classList.add('hidden');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-60');

        try {
            const formData = new FormData(form);
            const res = await fetch('{{ route("order.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await res.json();
            if (!res.ok) {
                const msg = data.message || (data.errors ? Object.values(data.errors).flat()[0] : 'Gagal memproses pesanan.');
                errorBox.textContent = msg;
                errorBox.classList.remove('hidden');
                return;
            }

            document.getElementById('success-order-no').textContent = data.order_no;
            document.getElementById('success-wa-preview').textContent = data.wa_message;
            document.getElementById('success-wa-link').href = data.wa_url;

            form.classList.add('hidden');
            successBox.classList.remove('hidden');
            successBox.classList.add('flex');

            window.open(data.wa_url, '_blank', 'noopener,noreferrer');
        } catch (err) {
            errorBox.textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
            errorBox.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-60');
        }
    });
</script>

@stack('scripts')
</body>
</html>

