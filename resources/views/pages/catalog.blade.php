@extends('layouts.app')

@section('title', 'Katalog Produk Lengkap — VAULT Curated Thrift')

@section('content')
<div class="flex flex-col w-full">
    <!-- Top Utility & Breadcrumb Bar -->
    <section class="w-full bg-surface-container-low border-b border-outline-variant py-space-sm">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-wrap items-center justify-between gap-space-xs">
            <nav class="flex items-center gap-space-xs font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">
                <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[15px]">home</span>
                    Beranda
                </a>
                <span class="text-outline text-label-sm">/</span>
                <span class="text-primary font-bold">Katalog Produk</span>
            </nav>
            <div class="flex items-center gap-space-sm font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-secondary-container border border-primary animate-pulse"></span>
                    Vault Live Database
                </span>
                <span class="hidden sm:inline">•</span>
                <span class="hidden sm:inline">SKU Arsip Terverifikasi</span>
            </div>
        </div>
    </section>

    <!-- Editorial Title -->
    <section class="w-full bg-surface pt-space-lg pb-space-md">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-col md:flex-row md:items-end justify-between gap-space-md">
            <div class="flex flex-col max-w-2xl">
                <div class="flex items-center gap-space-xs mb-space-xs">
                    <span class="bg-primary text-on-primary px-space-xs py-0.5 font-label-sm text-label-sm tracking-widest uppercase">CATALOG ARCHIVE</span>
                    <span class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-widest">AUTHENTICATED GRAILS</span>
                </div>
                <h1 class="font-headline-lg text-headline-lg uppercase tracking-tight text-primary leading-none">
                    KATALOG PRODUK LENGKAP
                </h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-space-xs leading-relaxed">
                    Ditemukan <span class="font-bold text-primary">{{ $products->total() }} item terkurasi</span>. Seluruh item adalah barang pre-loved original 1-of-1 yang telah melalui proses kurasi ketat, autentikasi ganda, dan sterilisasi ozon siap pakai.
                </p>
            </div>
            <div class="flex items-center gap-space-md bg-surface-container border border-outline-variant px-space-md py-space-sm self-start md:self-auto">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Grading Presisi</span>
                    <span class="font-headline-md text-headline-md text-primary font-bold">100% ASLI</span>
                </div>
                <div class="w-px h-8 bg-outline-variant"></div>
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Jadwal Drop</span>
                    <span class="font-headline-md text-headline-md text-secondary font-bold">{{ strtoupper($storeSettings['drop_schedule']) }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Multi-Dimensional Filter Form (FR-21, FR-22) -->
    <section class="w-full bg-surface/95 backdrop-blur-md border-y border-outline-variant py-space-sm sticky top-[92px] md:top-[108px] z-30">
        <form id="catalog-filter-form" action="{{ route('catalog') }}" method="GET" class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-col gap-space-sm">
            <input type="hidden" name="kategori" id="filter-kategori" value="{{ $kategori }}"/>
            <input type="hidden" name="ukuran" id="filter-ukuran" value="{{ $ukuran }}"/>
            <input type="hidden" name="status" id="filter-status" value="{{ $status }}"/>

            <!-- Row 1: Search & Category Tabs -->
            <div class="flex flex-col lg:flex-row lg:items-center gap-space-sm">
                <div class="relative flex-1 min-w-[260px] flex border border-outline-variant focus-within:border-primary focus-within:border-[1.5px] bg-surface-container-lowest">
                    <span class="material-symbols-outlined self-center pl-3 text-outline">search</span>
                    <input
                        name="q"
                        value="{{ $q }}"
                        class="w-full bg-transparent px-3 py-2 font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none"
                        placeholder="Cari nama produk, brand, atau SKU (cth: Carhartt, VLT-0001)..."
                        type="text"
                    />
                    <button type="submit" class="bg-primary text-on-primary px-4 font-label-sm text-label-sm uppercase tracking-wider hover:bg-secondary-container hover:text-primary transition-colors">
                        Cari
                    </button>
                </div>

                <!-- Category Tabs -->
                <div class="flex items-center gap-space-xs overflow-x-auto pb-1 lg:pb-0 no-scrollbar">
                    <button type="button" onclick="applyCatalogFilter('kategori', '')"
                            class="font-label-md text-label-md uppercase tracking-wider px-space-md py-2 whitespace-nowrap border transition-colors {{ $kategori === '' || $kategori === 'all' ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container-lowest text-on-surface border-outline-variant hover:border-primary' }}">
                        Semua <span class="opacity-75">({{ $totalAllProducts }})</span>
                    </button>
                    @foreach($categories as $cat)
                        <button type="button" onclick="applyCatalogFilter('kategori', '{{ $cat->slug }}')"
                                class="font-label-md text-label-md uppercase tracking-wider px-space-md py-2 whitespace-nowrap border transition-colors {{ $kategori === $cat->slug ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container-lowest text-on-surface border-outline-variant hover:border-primary' }}">
                            {{ $cat->name }} <span class="opacity-75">({{ $cat->products_count }})</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Row 2: Size, Status, Price, Sort, Reset -->
            <div class="flex flex-wrap items-center justify-between gap-space-xs bg-surface-container-low border border-outline-variant p-space-xs sm:p-space-sm">
                <div class="flex flex-wrap items-center gap-space-sm">
                    <!-- Size Pills -->
                    <div class="flex items-center gap-1 overflow-x-auto">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mr-1">Ukuran:</span>
                        @foreach(['ALL' => '', 'S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '28-36' => '28-36', '40-44' => '40-44'] as $label => $val)
                            @php $activeSize = ($ukuran === '' && $val === '') || ($ukuran === $val && $val !== ''); @endphp
                            <button type="button" onclick="applyCatalogFilter('ukuran', '{{ $val }}')"
                                    class="font-label-sm text-label-sm px-2 py-1 border transition-colors {{ $activeSize ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container-lowest text-on-surface border-outline-variant hover:border-primary' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center gap-1">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mr-1">Status:</span>
                        @foreach(['all' => 'Semua', 'available' => 'Tersedia', 'sold' => 'Habis'] as $stVal => $stLabel)
                            <button type="button" onclick="applyCatalogFilter('status', '{{ $stVal }}')"
                                    class="font-label-sm text-label-sm px-2.5 py-1 border transition-colors {{ $status === $stVal ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container-lowest text-on-surface border-outline-variant hover:border-primary' }}">
                                {{ $stLabel }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Price Range -->
                    <div class="relative">
                        <select name="harga" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant focus:border-primary font-label-sm text-label-sm uppercase tracking-wider text-on-surface px-space-sm py-1.5 pr-7 appearance-none cursor-pointer focus:outline-none">
                            <option value="all" {{ $harga === 'all' ? 'selected' : '' }}>Harga: Semua</option>
                            <option value="under-500" {{ $harga === 'under-500' ? 'selected' : '' }}>&lt; Rp 500.000</option>
                            <option value="500-1500" {{ $harga === '500-1500' ? 'selected' : '' }}>Rp 500rb - Rp 1,5jt</option>
                            <option value="over-1500" {{ $harga === 'over-1500' ? 'selected' : '' }}>&gt; Rp 1.500.000</option>
                        </select>
                        <span class="material-symbols-outlined text-[16px] absolute right-1.5 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                    </div>
                </div>

                <!-- Right: Sort & Reset -->
                <div class="flex items-center gap-space-xs ml-auto">
                    <div class="relative flex items-center">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mr-1.5 hidden sm:inline">Urutkan:</span>
                        <div class="relative">
                            <select name="urut" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant focus:border-primary font-label-sm text-label-sm uppercase tracking-wider text-on-surface px-space-sm py-1.5 pr-7 appearance-none cursor-pointer font-bold focus:outline-none">
                                <option value="newest" {{ $urut === 'newest' ? 'selected' : '' }}>Terbaru Diunggah</option>
                                <option value="price_asc" {{ $urut === 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                                <option value="price_desc" {{ $urut === 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                                <option value="grade_desc" {{ $urut === 'grade_desc' ? 'selected' : '' }}>Grade Tertinggi (10/10)</option>
                            </select>
                            <span class="material-symbols-outlined text-[16px] absolute right-1.5 top-1/2 -translate-y-1/2 pointer-events-none text-outline">unfold_more</span>
                        </div>
                    </div>
                    <a href="{{ route('catalog') }}" class="flex items-center gap-1 font-label-sm text-label-sm uppercase tracking-wider text-error border border-error/40 bg-surface-container-lowest hover:bg-error hover:text-on-error px-2.5 py-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[14px]">refresh</span>
                        <span>Reset</span>
                    </a>
                </div>
            </div>
        </form>
    </section>

    <!-- Result Count Strip -->
    <section class="w-full bg-surface pt-space-md pb-space-xs">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-wrap items-center justify-between gap-2 text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
            <div class="flex items-center gap-2">
                @if($products->total() > 0)
                    <span class="text-primary font-bold">Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                    <span>dari {{ $products->total() }} produk arsip</span>
                @else
                    <span class="text-primary font-bold">0 produk ditemukan</span>
                @endif
            </div>
            <div class="hidden sm:flex items-center gap-space-md">
                <span class="flex items-center gap-1 text-on-surface">
                    <span class="material-symbols-outlined text-[14px] text-secondary">verified</span>
                    Originalitas Dijamin 100%
                </span>
                <span class="flex items-center gap-1 text-on-surface">
                    <span class="material-symbols-outlined text-[14px] text-secondary">local_laundry_service</span>
                    Sterilisasi &amp; Steam Ready
                </span>
            </div>
        </div>
    </section>

    <!-- Main Product Grid (2 cols mobile, 3 cols tablet, 4 cols desktop) -->
    <section class="w-full bg-surface py-space-sm">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-space-sm md:gap-space-md">
                    @foreach($products as $product)
                        <x-product-card :product="$product"/>
                    @endforeach
                </div>
            @else
                <div class="bg-surface-container-low border border-primary p-space-xl text-center flex flex-col items-center gap-space-sm my-space-lg">
                    <span class="material-symbols-outlined text-[48px] text-outline">inventory_2</span>
                    <h2 class="font-headline-md text-headline-md uppercase text-primary font-bold">Tidak Ada Artikel yang Cocok</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md">Coba ubah kata kunci pencarian atau reset filter ukuran dan kategori untuk melihat seluruh koleksi arsip yang tersedia.</p>
                    <a href="{{ route('catalog') }}" class="mt-2 bg-primary text-on-primary px-6 py-2.5 font-label-md text-label-md uppercase tracking-wider hover:bg-secondary-container hover:text-primary transition-colors">
                        Tampilkan Semua Produk
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Pagination -->
    @if($products->hasPages())
        <section class="w-full bg-surface py-space-lg">
            <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-col sm:flex-row items-center justify-between gap-space-md">
                <span class="font-body-md text-body-md text-on-surface-variant">
                    Menampilkan <strong class="text-primary">{{ $products->firstItem() }} - {{ $products->lastItem() }}</strong> dari total <strong class="text-primary">{{ $products->total() }} produk</strong> arsip
                </span>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </section>
    @endif

    <!-- Floating Sizing Consultation Assist Bar -->
    <aside class="max-w-[1440px] mx-auto w-full px-margin md:px-margin-tablet lg:px-margin-desktop pb-space-xl pt-space-md">
        <div class="bg-primary text-on-primary border border-primary hard-shadow p-space-sm md:p-space-md flex flex-col sm:flex-row items-center justify-between gap-space-sm">
            <div class="flex items-center gap-space-sm">
                <span class="material-symbols-outlined text-secondary-container text-2xl hidden sm:inline">straighten</span>
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">ASISTEN UKURAN &amp; ARSIP</span>
                    <p class="font-body-sm text-body-sm text-on-primary leading-tight">
                        Bingung menentukan ukuran (P x L cm)? Cek protokol pengukuran kami atau konsultasikan fitting langsung dengan admin.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-space-xs w-full sm:w-auto">
                <a href="{{ route('about') }}#protokol" class="flex-1 sm:flex-none text-center border border-surface/40 hover:bg-surface/10 text-on-primary font-label-sm text-label-sm uppercase tracking-wider px-space-md py-2 transition-colors">
                    Panduan Ukuran
                </a>
                @php
                    $assistWaUrl = 'https://wa.me/' . $storeSettings['whatsapp_clean'] . '?text=' . rawurlencode('Halo Admin VAULT, saya butuh bantuan konsultasi ukuran/fitting item di katalog.');
                @endphp
                <a href="{{ $assistWaUrl }}" target="_blank" rel="noopener noreferrer" class="flex-1 sm:flex-none flex items-center justify-center gap-1 bg-secondary-container hover:bg-surface text-primary font-label-sm text-label-sm uppercase tracking-wider px-space-md py-2 transition-colors font-bold whitespace-nowrap">
                    <span class="material-symbols-outlined text-[16px]">chat</span>
                    Tanya Admin
                </a>
            </div>
        </div>
    </aside>
</div>
@endsection

@push('scripts')
<script>
    function applyCatalogFilter(field, value) {
        const input = document.getElementById('filter-' + field);
        if (input) {
            input.value = value;
            document.getElementById('catalog-filter-form').submit();
        }
    }
</script>
@endpush

