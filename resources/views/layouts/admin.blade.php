<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Admin Console — VAULT Curated Thrift')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
        }
        .tabular-nums { font-variant-numeric: tabular-nums; }
        .hard-shadow { box-shadow: 0px 4px 0px 0px #0F0F11; }
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
                        "surface-container-highest": "#e3e1ec",
                        "surface": "#fbf8ff",
                        "secondary-fixed": "#E6FD52",
                        "surface-container": "#eeedf7",
                        "secondary-container": "#E6FD52",
                        "surface-container-low": "#f4f2fd",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#c8c5ca",
                        "secondary": "#596400",
                        "outline": "#71717A",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "surface-container-high": "#e8e7f1",
                        "primary": "#0F0F11",
                        "on-primary": "#ffffff",
                        "primary-container": "#1b1b1d",
                        "tertiary": "#F97316"
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
                        "space-md": "1rem",
                        "space-sm": "0.5rem",
                        "space-xs": "0.25rem",
                        "space-xl": "2.5rem"
                    },
                    fontFamily: {
                        "body-md": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "label-lg": ["Space Grotesk", "sans-serif"],
                        "label-md": ["Space Grotesk", "sans-serif"],
                        "label-sm": ["Space Grotesk", "sans-serif"],
                        "headline-lg": ["Space Grotesk", "sans-serif"],
                        "headline-md": ["Space Grotesk", "sans-serif"],
                        "display-lg": ["Space Grotesk", "sans-serif"]
                    },
                    fontSize: {
                        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "body-sm": ["12px", { lineHeight: "16px", fontWeight: "400" }],
                        "label-lg": ["13px", { lineHeight: "16px", letterSpacing: "0.06em", fontWeight: "700" }],
                        "label-md": ["11px", { lineHeight: "14px", letterSpacing: "0.08em", fontWeight: "600" }],
                        "label-sm": ["10px", { lineHeight: "12px", letterSpacing: "0.1em", fontWeight: "600" }],
                        "headline-lg": ["28px", { lineHeight: "34px", letterSpacing: "-0.03em", fontWeight: "700" }],
                        "headline-md": ["18px", { lineHeight: "24px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "display-lg": ["42px", { lineHeight: "48px", letterSpacing: "-0.04em", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased overflow-x-hidden">

<!-- Mobile Sidebar Backdrop -->
<div id="admin-sidebar-backdrop" class="fixed inset-0 bg-primary/60 z-40 hidden lg:hidden" onclick="toggleAdminSidebar()"></div>

<!-- LEFT SIDEBAR -->
<aside id="admin-sidebar" class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest border-r border-outline-variant z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
    <div class="flex flex-col overflow-y-auto">
        <div class="p-space-lg border-b border-outline-variant">
            <div class="flex items-center justify-between">
                <div class="flex items-baseline gap-2">
                    <span class="font-headline-lg text-headline-lg tracking-tight uppercase text-primary font-bold">VAULT</span>
                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-surface-container-high border border-outline-variant text-on-surface uppercase">ADMIN v1.0</span>
                </div>
                <button type="button" onclick="toggleAdminSidebar()" class="lg:hidden text-primary p-1">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="mt-space-sm">
                <a class="inline-flex items-center gap-1 font-label-md text-label-md uppercase text-on-surface-variant hover:text-primary transition-colors" href="{{ route('home') }}" target="_blank">
                    <span>Lihat Toko Online</span>
                    <span class="material-symbols-outlined text-[14px]">north_east</span>
                </a>
            </div>
        </div>

        <div class="px-space-md pt-space-md pb-space-xs font-label-sm text-label-sm uppercase tracking-wider text-outline">Navigasi Arsip</div>
        <nav class="flex flex-col px-space-sm gap-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-space-md py-2.5 font-label-md text-label-md uppercase transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-[18px]">grid_view</span>
                    <span>Dashboard Ringkasan</span>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-space-md py-2.5 font-label-md text-label-md uppercase transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-[18px]">styler</span>
                    <span>Katalog &amp; Produk</span>
                </div>
                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-secondary-container text-primary border border-primary uppercase font-bold">{{ $adminCounts['products_total'] }}</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-space-md py-2.5 font-label-md text-label-md uppercase transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span>Pesanan &amp; WA Log</span>
                </div>
                @if($adminCounts['pending_orders'] > 0)
                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-tertiary text-on-primary uppercase font-bold">{{ $adminCounts['pending_orders'] }} Pending</span>
                @endif
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between px-space-md py-2.5 font-label-md text-label-md uppercase transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-[18px]">category</span>
                    <span>Kategori</span>
                </div>
                <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-surface-container-high text-on-surface-variant uppercase">{{ $adminCounts['categories_total'] }}</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center justify-between px-space-md py-2.5 font-label-md text-label-md uppercase transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container hover:text-primary' }}">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                    <span>Pengaturan &amp; Bank</span>
                </div>
            </a>
        </nav>
    </div>

    <!-- Admin User & Logout -->
    <div class="p-space-md bg-surface-container-low m-space-sm border border-outline-variant">
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-space-sm min-w-0">
                <div class="relative shrink-0">
                    <div class="w-8 h-8 bg-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-secondary-container rounded-full border border-primary"></span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-label-md text-label-md uppercase text-primary font-bold truncate">{{ auth()->user()?->name ?? 'Admin' }}</span>
                    <span class="font-body-sm text-[11px] text-on-surface-variant truncate">Super Admin</span>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-on-surface-variant hover:text-error transition-colors p-1" title="Keluar (Logout)">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- MAIN WRAPPER -->
<div class="lg:pl-72 min-h-screen flex flex-col">
    <!-- Top Header -->
    <header class="sticky top-0 h-16 bg-surface/95 backdrop-blur-xl border-b border-outline-variant z-30">
        <div class="h-16 w-full px-space-md md:px-space-lg flex items-center justify-between gap-space-md">
            <div class="flex items-center gap-space-sm flex-1 max-w-xl">
                <button type="button" onclick="toggleAdminSidebar()" class="lg:hidden p-2 border border-outline-variant text-primary">
                    <span class="material-symbols-outlined text-[20px]">menu</span>
                </button>
                <form action="{{ route('admin.products.index') }}" method="GET" class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant">search</span>
                    <input name="q" value="{{ request('q') }}" class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary text-on-surface font-body-sm text-body-sm pl-9 pr-4 py-2 focus:outline-none placeholder:text-on-surface-variant" placeholder="Cari SKU, nama artikel, atau brand..." type="text"/>
                </form>
                <div class="hidden xl:flex items-center gap-1.5 whitespace-nowrap px-space-sm py-1 bg-surface-container-low border border-outline-variant font-label-sm text-label-sm text-on-surface">
                    <span class="w-2 h-2 rounded-full bg-secondary-container border border-primary inline-block"></span>
                    <span>Laragon / MySQL Live</span>
                </div>
            </div>

            <div class="flex items-center gap-space-sm">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1 px-3 md:px-space-md py-2 bg-secondary-container border border-primary text-primary hover:bg-primary hover:text-secondary-container transition-colors font-label-md text-label-md uppercase font-bold whitespace-nowrap">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    <span class="hidden sm:inline">Tambah Produk</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'menunggu_konfirmasi']) }}" class="flex items-center gap-1 px-2.5 py-2 bg-surface-container-low border border-outline-variant font-label-sm text-label-sm text-primary hover:border-primary whitespace-nowrap">
                    <span class="material-symbols-outlined text-[16px] text-secondary">chat</span>
                    <span>{{ $adminCounts['pending_orders'] }} Pending</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 w-full bg-surface">
        <!-- Global Flash Alerts -->
        @if(session('success'))
            <div class="mx-space-md md:mx-space-lg mt-space-md bg-secondary-container border border-primary px-space-md py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2 font-label-md text-label-md uppercase text-primary font-bold">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-primary"><span class="material-symbols-outlined text-[18px]">close</span></button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-space-md md:mx-space-lg mt-space-md bg-error-container border border-error px-space-md py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2 font-label-md text-label-md uppercase text-on-error-container font-bold">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-on-error-container"><span class="material-symbols-outlined text-[18px]">close</span></button>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-space-md md:mx-space-lg mt-space-md bg-error-container border border-error px-space-md py-3 text-on-error-container">
                <div class="font-label-md text-label-md uppercase font-bold mb-1">Periksa Input Form:</div>
                <ul class="list-disc pl-5 text-body-sm">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const backdrop = document.getElementById('admin-sidebar-backdrop');
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
    }
</script>
@stack('scripts')
</body>
</html>

