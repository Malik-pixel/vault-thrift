@extends('layouts.app')

@section('title', 'VAULT CURATED THRIFT — Curated Thrift & Archive Streetwear')

@section('content')
<div class="flex flex-col w-full">
    <!-- HERO SECTION -->
    <section class="relative w-full bg-surface-container-low border-b border-outline-variant py-space-xl overflow-hidden">
        <div class="relative max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-col gap-space-xl">
            <!-- Top Metadata Pill -->
            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                <div class="inline-flex items-center gap-space-xs bg-primary text-on-primary px-space-md py-space-xs border border-primary">
                    <span class="inline-block w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">VAULT ARCHIVE EDITION {{ date('Y') }}</span>
                </div>
                <div class="hidden sm:flex items-center gap-space-md font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    <span>JAKARTA / EST. 2021</span>
                    <span>•</span>
                    <span>100% VERIFIED AUTHENTIC</span>
                    <span>•</span>
                    <span>DROP: {{ $storeSettings['drop_schedule'] }}</span>
                </div>
            </div>

            <!-- Hero Split -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-center">
                <div class="lg:col-span-7 flex flex-col gap-space-md">
                    <div class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md uppercase tracking-widest">
                        <span>[ ARCHIVAL CURATION ]</span>
                        <span>//</span>
                        <span>ONLY 1 PIECE PER DROP</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary uppercase tracking-tight leading-none">
                        CURATED THRIFT &amp; ARCHIVE STREETWEAR
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl leading-relaxed">
                        Koleksi pakaian pre-loved vintage terpilih, 100% original, telah disanitasi profesional, dan siap pakai. Eksplorasi estetika arsip streetwear era 90-an hingga 2000-an.
                    </p>

                    <!-- Integrated Search Box (FR-10) -->
                    <div class="mt-space-sm flex flex-col gap-space-sm bg-surface-container-lowest p-space-sm border border-primary hard-shadow">
                        <form action="{{ route('catalog') }}" method="GET" class="flex items-center gap-space-sm bg-surface-container-low border border-outline-variant px-space-md py-space-xs focus-within:border-primary">
                            <span class="material-symbols-outlined text-outline">search</span>
                            <input
                                name="q"
                                id="vault-hero-search"
                                class="w-full bg-transparent font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none py-1.5"
                                placeholder="Cari brand, era, atau model (cth: Carhartt, Nirvana, Dunk)..."
                                type="text"
                            />
                            <button type="submit" class="bg-primary text-on-primary px-space-md py-2 font-label-md text-label-md uppercase tracking-wider hover:bg-secondary-container hover:text-primary transition-colors font-bold">
                                CARI
                            </button>
                        </form>

                        <!-- Quick Category Tags (FR-10) -->
                        <div class="flex items-center gap-space-xs overflow-x-auto pb-1 no-scrollbar">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline shrink-0 mr-1">TAG CEPAT:</span>
                            <a href="{{ route('catalog') }}" class="bg-primary text-on-primary px-2.5 py-1 font-label-sm text-label-sm uppercase shrink-0 hover:bg-secondary-container hover:text-primary transition-colors">Semua</a>
                            <a href="{{ route('catalog', ['kategori' => 'baju']) }}" class="bg-surface-container border border-outline-variant text-on-surface hover:bg-secondary-container hover:border-primary px-2.5 py-1 font-label-sm text-label-sm uppercase shrink-0 transition-colors">Vintage Tees</a>
                            <a href="{{ route('catalog', ['kategori' => 'jaket-hoodie']) }}" class="bg-surface-container border border-outline-variant text-on-surface hover:bg-secondary-container hover:border-primary px-2.5 py-1 font-label-sm text-label-sm uppercase shrink-0 transition-colors">Workwear Jacket</a>
                            <a href="{{ route('catalog', ['kategori' => 'celana']) }}" class="bg-surface-container border border-outline-variant text-on-surface hover:bg-secondary-container hover:border-primary px-2.5 py-1 font-label-sm text-label-sm uppercase shrink-0 transition-colors">Baggy Denim</a>
                            <a href="{{ route('catalog', ['kategori' => 'sepatu']) }}" class="bg-surface-container border border-outline-variant text-on-surface hover:bg-secondary-container hover:border-primary px-2.5 py-1 font-label-sm text-label-sm uppercase shrink-0 transition-colors">Retro Sneakers</a>
                        </div>
                    </div>

                    <!-- Hero CTAs -->
                    <div class="flex flex-wrap items-center gap-space-md pt-space-xs">
                        <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center gap-space-xs bg-primary text-on-primary border border-primary px-space-xl py-space-md font-label-lg text-label-lg uppercase tracking-wider hover:bg-secondary-container hover:text-primary hard-shadow transition-colors">
                            <span>Jelajahi Katalog Lengkap</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                        <a href="#curated-drop-section" class="inline-flex items-center justify-center gap-space-xs bg-surface-container-lowest border border-primary text-primary px-space-lg py-space-md font-label-lg text-label-lg uppercase tracking-wider hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-[18px]">local_fire_department</span>
                            <span>Drop Pilihan Kurator</span>
                        </a>
                    </div>
                </div>

                <!-- Hero Highlight Card -->
                <div class="lg:col-span-5 relative">
                    @if($highlightProduct)
                        <a href="{{ route('product.show', $highlightProduct->slug) }}" class="block relative bg-surface-container-lowest border border-primary p-space-sm hard-shadow group">
                            <div class="relative aspect-[4/5] overflow-hidden bg-surface-container border border-outline-variant">
                                <img src="{{ asset('images/stitch/hero-model.jpg') }}" alt="{{ $highlightProduct->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                                <div class="absolute top-space-sm left-space-sm bg-primary text-on-primary font-label-sm text-label-sm px-space-sm py-space-xs uppercase tracking-widest">
                                    ARCHIVE PIECE // {{ $highlightProduct->sku }}
                                </div>
                                <div class="absolute bottom-space-sm left-space-sm right-space-sm bg-surface-container-lowest/95 border border-primary p-space-md flex items-center justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase">CURRENT HIGHLIGHT</p>
                                        <p class="font-headline-md text-headline-md text-primary uppercase font-bold truncate">{{ $highlightProduct->name }}</p>
                                        <p class="font-label-md text-label-md text-secondary uppercase font-bold">
                                            KONDISI {{ number_format($highlightProduct->condition_grade, 1) }}/10 • SIZE {{ $highlightProduct->size_label }} • {{ $highlightProduct->formatted_price }}
                                        </p>
                                    </div>
                                    <div class="bg-secondary-container border border-primary text-primary p-space-xs shrink-0">
                                        <span class="material-symbols-outlined block text-[24px]">verified</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="hidden sm:block absolute -bottom-3 -left-3 bg-primary text-secondary-container font-label-md text-label-md px-space-md py-space-xs uppercase tracking-widest border border-primary">
                            100% ORIGINAL GUARANTEE
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats Strip (FR-13) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm bg-surface-container border border-outline-variant p-space-md">
                <div class="flex items-center gap-space-md p-space-sm bg-surface-container-lowest border border-outline-variant">
                    <div class="w-12 h-12 bg-surface-container-high border border-outline-variant flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[28px]">checkroom</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-lg text-headline-lg text-primary leading-none tabular-nums">{{ $storeSettings['total_archived_stat'] }}</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mt-1">Pakaian Terkurasi ({{ $totalAvailable }} Ready Stok)</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-md p-space-sm bg-surface-container-lowest border border-outline-variant">
                    <div class="w-12 h-12 bg-secondary-container border border-primary flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[28px]">verified_user</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-lg text-headline-lg text-primary leading-none tabular-nums">9/10+</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mt-1">Kondisi Garansi Presisi</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-md p-space-sm bg-surface-container-lowest border border-outline-variant">
                    <div class="w-12 h-12 bg-surface-container-high border border-outline-variant flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[28px]">local_shipping</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-lg text-headline-lg text-primary leading-none">FAST EXP</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mt-1">Pengiriman Cepat Seluruh Indonesia</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KATEGORI PILIHAN UTAMA (FR-11) -->
    <section class="w-full max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-lg pb-space-sm border-b border-outline-variant">
            <div class="flex flex-col gap-space-xs">
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">[ KLASIFIKASI ARSIP ]</span>
                <h2 class="font-headline-lg text-headline-lg text-primary uppercase">Kategori Pilihan Utama</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Kurasi terorganisir per segmen pakaian untuk memudahkan pencarian siluet favoritmu.</p>
            </div>
            <a href="{{ route('catalog') }}" class="font-label-md text-label-md uppercase tracking-wider text-primary hover:bg-secondary-container px-3 py-1.5 border border-primary flex items-center gap-space-xs self-start md:self-auto transition-colors">
                <span>Semua Kategori ({{ $categories->count() }})</span>
                <span class="material-symbols-outlined text-[16px]">arrow_outward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            @foreach($categories as $index => $cat)
                <a href="{{ route('catalog', ['kategori' => $cat->slug]) }}" class="group relative flex flex-col bg-surface-container-lowest border border-outline-variant hover:border-primary transition-colors overflow-hidden">
                    <div class="relative aspect-[3/4] overflow-hidden bg-surface-container border-b border-outline-variant">
                        <img src="{{ asset($cat->image_path ?: 'images/demo/placeholder-archive.svg') }}" alt="{{ $cat->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent"></div>
                        <span class="absolute top-space-sm left-space-sm bg-surface-container-lowest border border-primary text-primary font-label-sm text-label-sm uppercase px-space-sm py-0.5 font-bold">
                            {{ $cat->available_count }} ITEMS TERSEDIA
                        </span>
                        <div class="absolute bottom-space-md left-space-md right-space-md text-surface flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container font-bold">CAT. 0{{ $index + 1 }}</span>
                            <div class="w-8 h-8 bg-secondary-container border border-primary text-primary flex items-center justify-center transform group-hover:translate-x-1 transition-transform">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-space-md flex flex-col gap-space-xs bg-surface-container-lowest">
                        <h3 class="font-headline-md text-headline-md text-primary uppercase font-bold group-hover:underline">{{ $cat->name }}</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $cat->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- KOLEKSI PILIHAN KURATOR (6 ITEMS, FR-12) -->
    <section class="w-full bg-surface-container-low border-y border-outline-variant py-space-xl" id="curated-drop-section">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-col gap-space-xl">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                <div class="flex flex-col gap-space-xs">
                    <div class="flex items-center gap-space-xs">
                        <span class="w-2.5 h-2.5 bg-secondary-container border border-primary inline-block"></span>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">LIVE ARCHIVE DROPS</span>
                    </div>
                    <h2 class="font-headline-lg text-headline-lg text-primary uppercase">Koleksi Pilihan Kurator (Curated Picks)</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Setiap item hanya tersedia 1 pcs (1 of 1). Jangan sampai keduluan oleh sesama kolektor.</p>
                </div>
                <div class="inline-flex items-center gap-space-xs bg-surface-container-lowest border border-primary px-space-md py-space-xs self-start md:self-auto">
                    <span class="material-symbols-outlined text-secondary text-[20px]">schedule</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">UPDATE BERKALA: {{ strtoupper($storeSettings['drop_schedule']) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-space-sm md:gap-space-lg">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product"/>
                @endforeach
            </div>

            <div class="pt-space-sm flex items-center justify-center">
                <a href="{{ route('catalog') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-space-md bg-primary text-on-primary border border-primary px-space-xl py-space-md font-label-lg text-label-lg uppercase tracking-wider hover:bg-secondary-container hover:text-primary hard-shadow transition-colors">
                    <span>Lihat Semua Produk di Katalog ({{ $totalCatalog }} Artikel)</span>
                    <span class="material-symbols-outlined text-[20px]">arrow_right_alt</span>
                </a>
            </div>
        </div>
    </section>

    <!-- MANIFESTO & BENEFIT PILLARS -->
    <section class="w-full max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop py-space-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
            <div class="lg:col-span-6 flex flex-col gap-space-lg bg-primary text-on-primary p-space-lg md:p-space-xl border border-primary hard-shadow">
                <div class="flex flex-col gap-space-xs">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">THE MANIFESTO</span>
                    <h2 class="font-headline-lg text-headline-lg uppercase text-on-primary tracking-tight">STANDAR KURASI VAULT</h2>
                    <p class="font-body-md text-body-md text-inverse-primary leading-relaxed">
                        Thrifting bukan sekadar membeli barang bekas, melainkan mengapresiasi sejarah desain garmen. Kami memberlakukan 3 protokol seleksi tanpa kompromi sebelum setiap pakaian dipajang ke etalase.
                    </p>
                </div>
                <div class="flex flex-col gap-space-md">
                    <div class="flex gap-space-md items-start bg-primary-container border border-outline/40 p-space-md">
                        <span class="font-headline-lg text-headline-lg text-secondary-container font-bold leading-none">01</span>
                        <div class="flex flex-col gap-space-xs">
                            <span class="font-label-lg text-label-lg uppercase text-on-primary tracking-wider">Pengecekan Autentisitas Ketat</span>
                            <p class="font-body-sm text-body-sm text-inverse-primary">Verifikasi wash tag, stitch construction (single/double stitch), zipper hardware (YKK, Talon, Ideal), dan font sablon era terkait.</p>
                        </div>
                    </div>
                    <div class="flex gap-space-md items-start bg-primary-container border border-outline/40 p-space-md">
                        <span class="font-headline-lg text-headline-lg text-secondary-container font-bold leading-none">02</span>
                        <div class="flex flex-col gap-space-xs">
                            <span class="font-label-lg text-label-lg uppercase text-on-primary tracking-wider">Grading Kondisi Objektif</span>
                            <p class="font-body-sm text-body-sm text-inverse-primary">Penilaian skala 1-10 secara jujur. Setiap noda mikro, lubang kecil (pinhole), atau sun-fade dicatat transparan tanpa filter foto berlebih.</p>
                        </div>
                    </div>
                    <div class="flex gap-space-md items-start bg-primary-container border border-outline/40 p-space-md">
                        <span class="font-headline-lg text-headline-lg text-secondary-container font-bold leading-none">03</span>
                        <div class="flex flex-col gap-space-xs">
                            <span class="font-label-lg text-label-lg uppercase text-on-primary tracking-wider">Laundry &amp; Sanitasi Higienis Uap Panas</span>
                            <p class="font-body-sm text-body-sm text-inverse-primary">Pencucian ramah serat kain dilanjutkan treatment steamer suhu tinggi 100°C bebas tungau, debu vintage, dan siap langsung kamu pakai.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 flex flex-col justify-between h-full gap-space-lg">
                <div class="flex flex-col gap-space-xs">
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">[ TRUST &amp; ADVANTAGES ]</span>
                    <h2 class="font-headline-lg text-headline-lg text-primary uppercase">Mengapa Kolektor Memilih VAULT?</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Kami menghilangkan ketidakpastian dalam berbelanja thrift online dengan transparansi data ukuran dan layanan respon kilat.</p>
                </div>
                <div class="grid grid-cols-1 gap-space-md">
                    <div class="bg-surface-container-low border border-outline-variant p-space-lg flex gap-space-md items-start">
                        <div class="w-10 h-10 bg-secondary-container border border-primary text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">fingerprint</span>
                        </div>
                        <div class="flex flex-col gap-space-xs">
                            <h4 class="font-headline-md text-headline-md text-primary uppercase font-bold">1 of 1 Exclusive Archive</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Tidak ada restock massal. Tiap artikel adalah arsip unik dengan jejak waktu, karakter fading, dan aura orisinalitas yang mustahil ditiru fast fashion.</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-low border border-outline-variant p-space-lg flex gap-space-md items-start">
                        <div class="w-10 h-10 bg-primary text-on-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">straighten</span>
                        </div>
                        <div class="flex flex-col gap-space-xs">
                            <h4 class="font-headline-md text-headline-md text-primary uppercase font-bold">Ukuran Akurat Centimeter (P x L)</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Jangan percaya size tag lama karena penyusutan alami vintage! Kami mengukur manual Panjang (cm), Lebar Dada / Pit-to-Pit (cm), dan Lingkar Pinggang.</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-low border border-outline-variant p-space-lg flex gap-space-md items-start">
                        <div class="w-10 h-10 bg-secondary-container border border-primary text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">payments</span>
                        </div>
                        <div class="flex flex-col gap-space-xs">
                            <h4 class="font-headline-md text-headline-md text-primary uppercase font-bold">Order Instan &amp; Garansi Uang Kembali</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Pemesanan direct ke kurator via WhatsApp tanpa registrasi rumit. Jaminan 100% refund penuh jika item terbukti tiruan.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-container border border-outline-variant p-space-md flex items-center justify-between gap-2">
                    <div class="flex items-center gap-space-sm">
                        <span class="material-symbols-outlined text-secondary text-[24px]">storefront</span>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">VISIT STUDIO: {{ strtoupper($storeSettings['studio_address']) }}</span>
                    </div>
                    <a href="{{ route('about') }}" class="font-label-sm text-label-sm uppercase tracking-wider text-primary hover:underline flex items-center gap-1 shrink-0 font-bold">
                        <span>PROFIL LENGKAP</span>
                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- BANNER CTA WHATSAPP -->
    <section class="w-full bg-primary-container text-surface py-space-xl border-t border-primary">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop">
            <div class="relative bg-inverse-surface border border-outline/40 p-space-lg md:p-space-xl flex flex-col lg:flex-row lg:items-center justify-between gap-space-xl">
                <div class="flex flex-col gap-space-sm max-w-2xl">
                    <div class="flex items-center gap-space-xs">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-secondary-container animate-ping"></span>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">HOTLINE KURATOR KAMI AKTIF</span>
                    </div>
                    <h2 class="font-headline-lg text-headline-lg uppercase text-surface tracking-tight">
                        Punya Pertanyaan atau Ingin Konsultasi Size?
                    </h2>
                    <p class="font-body-md text-body-md text-inverse-primary leading-relaxed">
                        Ingin menanyakan detail video serat kain, fitting on model, atau mencari artikel grail tertentu yang belum kami upload? Tim kurator kami siap merespon via WhatsApp.
                    </p>
                    <div class="flex flex-wrap items-center gap-space-md pt-space-xs font-label-sm text-label-sm text-inverse-primary uppercase tracking-wider">
                        <span>• Jam Respon: {{ $storeSettings['operating_hours'] }}</span>
                        <span>• Konsultasi Size Gratis</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row lg:flex-col gap-space-sm shrink-0">
                    @php
                        $ctaWaUrl = 'https://wa.me/' . $storeSettings['whatsapp_clean'] . '?text=' . rawurlencode('Halo Admin VAULT, saya tertarik dengan koleksi thrift kalian.');
                    @endphp
                    <a href="{{ $ctaWaUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-space-sm bg-secondary-container text-primary border border-primary px-space-xl py-space-md font-label-lg text-label-lg uppercase tracking-widest hover:bg-surface transition-colors font-bold">
                        <span class="material-symbols-outlined text-[24px]">chat</span>
                        <span>CHAT WHATSAPP (+{{ $storeSettings['whatsapp_clean'] }})</span>
                    </a>
                    <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center gap-space-sm bg-transparent border border-inverse-primary/40 text-surface hover:bg-surface/10 px-space-lg py-space-md font-label-md text-label-md uppercase tracking-wider transition-colors text-center">
                        <span>Jelajahi Katalog Online Terlebih Dahulu</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

