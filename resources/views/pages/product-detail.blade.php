@extends('layouts.app')

@section('title', $product->name . ' (' . $product->sku . ') — VAULT Curated Thrift')
@section('meta_description', $product->description ?: ($product->name . ' - Size ' . $product->size_label . ' - Grade ' . number_format($product->condition_grade, 1) . '/10'))

@section('content')
@php
    $isSold = $product->isSold();
    $images = $product->images;
    $measurementLabels = [
        'panjang' => 'Panjang Badan / Total',
        'lebar_dada' => 'Lebar Dada (P2P)',
        'lengan' => 'Panjang Lengan',
        'bahu' => 'Lebar Bahu',
        'pinggang' => 'Lingkar Pinggang',
        'open_leg' => 'Lebar Ujung Kaki',
        'insole' => 'Panjang Insole',
        'outsole' => 'Panjang Outsole',
    ];
@endphp

<div class="flex flex-col w-full pb-20 lg:pb-0">
    <!-- Top Utility Bar: Breadcrumbs & Return -->
    <section class="w-full bg-surface-container-low border-b border-outline-variant py-space-sm">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-wrap items-center justify-between gap-space-sm">
            <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md uppercase tracking-wider overflow-x-auto whitespace-nowrap">
                <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Beranda</a>
                <span class="text-outline">/</span>
                <a class="hover:text-primary transition-colors" href="{{ route('catalog') }}">Katalog Produk</a>
                <span class="text-outline">/</span>
                @if($product->category)
                    <a class="hover:text-primary transition-colors" href="{{ route('catalog', ['kategori' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                    <span class="text-outline">/</span>
                @endif
                <span class="text-primary font-bold">{{ $product->name }}</span>
            </nav>
            <a class="inline-flex items-center gap-space-xs bg-surface-container-lowest border border-primary text-primary px-space-md py-space-xs hover:bg-secondary-container font-label-md text-label-md uppercase tracking-wider transition-colors" href="{{ route('catalog') }}">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Kembali ke Katalog
            </a>
        </div>
    </section>

    <!-- Main Product Detail Canvas -->
    <section class="w-full py-space-md md:py-space-lg lg:py-space-xl">
        <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg lg:gap-space-xl items-start">

                <!-- LEFT COLUMN: Multi-Photo Gallery (7 cols) -->
                <div class="lg:col-span-7 flex flex-col gap-space-md">
                    <div class="relative w-full aspect-[4/5] bg-surface-container border border-outline-variant overflow-hidden group">
                        <img
                            id="main-product-display"
                            src="{{ $product->primary_image_url }}"
                            alt="{{ $product->name }}"
                            onclick="openZoomModal()"
                            class="w-full h-full object-cover cursor-zoom-in transition-transform duration-500 {{ $isSold ? 'grayscale contrast-125' : 'group-hover:scale-105' }}"
                        />

                        <!-- Floating Archival Badges -->
                        <div class="absolute top-space-md left-space-md flex flex-col gap-space-xs items-start pointer-events-none">
                            <span class="bg-primary text-on-primary font-label-sm text-label-sm uppercase tracking-widest px-space-sm py-space-xs">
                                ARCHIVE PIECE • 1-OF-1 • {{ $product->sku }}
                            </span>
                            <span class="bg-surface-container-lowest border border-primary text-primary font-label-sm text-label-sm uppercase tracking-wider px-space-sm py-space-xs flex items-center gap-space-xs font-bold">
                                <span class="material-symbols-outlined text-[14px] text-secondary">verified</span>
                                100% Authentic Tag Verified
                            </span>
                        </div>

                        @if($isSold)
                            <div class="absolute inset-0 bg-primary/40 flex items-center justify-center pointer-events-none">
                                <span class="border-2 border-surface text-surface font-headline-lg text-headline-lg uppercase tracking-widest px-6 py-2 -rotate-12 bg-primary/85 font-bold">
                                    [ HABIS TERJUAL / ARCHIVED ]
                                </span>
                            </div>
                        @endif

                        <button type="button" onclick="openZoomModal()" class="absolute bottom-space-md right-space-md bg-primary/85 text-surface px-space-sm py-space-xs font-label-sm text-label-sm uppercase flex items-center gap-space-xs hover:bg-secondary-container hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[16px]">zoom_in</span>
                            Klik untuk Zoom
                        </button>
                    </div>

                    <!-- Thumbnail Gallery Row -->
                    @if($images->count() > 0)
                        <div class="grid grid-cols-4 sm:grid-cols-5 gap-space-xs sm:gap-space-sm">
                            @foreach($images as $idx => $img)
                                <button
                                    type="button"
                                    onclick="selectThumbnail(this, '{{ $img->url }}')"
                                    class="thumbnail-btn relative aspect-square bg-surface-container border overflow-hidden transition-all {{ $idx === 0 ? 'border-primary ring-2 ring-primary opacity-100' : 'border-outline-variant opacity-75 hover:opacity-100 hover:border-primary' }}"
                                >
                                    <img src="{{ $img->url }}" alt="{{ $product->name }} - {{ $img->label }}" class="w-full h-full object-cover"/>
                                    <span class="absolute bottom-0 inset-x-0 bg-primary/85 text-on-primary font-label-sm text-[9px] uppercase text-center py-[2px]">
                                        {{ $img->label }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Authentication Strip -->
                    <div class="bg-surface-container-low border border-outline-variant p-space-md flex items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-sm">
                            <div class="w-10 h-10 bg-secondary-container border border-primary flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-[24px]">verified_user</span>
                            </div>
                            <div>
                                <p class="font-label-md text-label-md uppercase tracking-wider text-primary font-bold">VAULT Physical Authentication Protocol</p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Nomor Registri: #{{ $product->sku }} • Terverifikasi oleh Master Archivist</p>
                            </div>
                        </div>
                        <span class="hidden sm:inline-block font-label-sm text-label-sm uppercase bg-surface-container-lowest border border-primary px-space-sm py-space-xs text-secondary font-bold">
                            LULUS KURASI
                        </span>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Specs, Pricing, Stock, CTA (5 cols) -->
                <div class="lg:col-span-5 flex flex-col gap-space-md">
                    <!-- Category & Status Badge -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm">
                        <span class="font-label-sm text-label-sm uppercase tracking-widest bg-surface-container-high border border-outline-variant text-primary px-space-sm py-space-xs font-bold">
                            Kategori: {{ $product->category?->name ?? 'Arsip' }}
                        </span>

                        @if($isSold)
                            <div class="flex items-center gap-space-xs bg-tertiary text-on-primary px-space-sm py-space-xs font-label-sm text-label-sm uppercase font-bold">
                                <span class="w-2 h-2 rounded-full bg-surface"></span>
                                HABIS TERJUAL (ARCHIVED)
                            </div>
                        @else
                            <div class="flex items-center gap-space-xs bg-secondary-container border border-primary text-primary px-space-sm py-space-xs font-label-sm text-label-sm uppercase font-bold">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                                </span>
                                TERSEDIA (HANYA 1 PCS)
                            </div>
                        @endif
                    </div>

                    <!-- Title, Brand/Era & Price -->
                    <div class="flex flex-col gap-space-xs pb-space-sm border-b border-outline-variant">
                        <div class="flex items-center justify-between gap-2 font-label-sm text-label-sm uppercase tracking-widest text-on-surface-variant">
                            <span>{{ $product->brand ?: 'VAULT ARCHIVE' }}{{ $product->era ? ' • ' . $product->era : '' }}</span>
                            @if($product->drop_batch)
                                <span class="text-primary font-bold">{{ $product->drop_batch }}</span>
                            @endif
                        </div>
                        <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase text-primary leading-tight">
                            {{ $product->name }}
                        </h1>
                        @if($product->description)
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                                {{ $product->description }}
                            </p>
                        @endif
                        <div class="mt-space-sm flex flex-wrap items-baseline gap-space-sm">
                            <span class="font-display-lg text-display-lg-mobile md:text-[42px] md:leading-[48px] font-bold tracking-tight tabular-nums {{ $isSold ? 'text-outline line-through' : 'text-primary' }}">
                                {{ $product->formatted_price }}
                            </span>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">
                                {{ $isSold ? 'Status: Terjual' : 'Nett / Fixed Price' }}
                            </span>
                        </div>
                    </div>

                    <!-- 1-of-1 Scarcity Notice -->
                    <div class="bg-surface-container border border-outline-variant p-space-sm flex items-start gap-space-sm">
                        <span class="material-symbols-outlined text-tertiary text-[20px] shrink-0 mt-0.5">notification_important</span>
                        <p class="font-body-sm text-body-sm text-on-surface leading-snug">
                            <strong>Catatan Arsip 1-of-1:</strong> Produk pre-loved vintage unik (stok hanya 1 pcs). Pemesanan via WhatsApp dicatat sebagai <em>Menunggu Konfirmasi</em>; stok resmi terkunci setelah pembayaran lunas diverifikasi admin.
                        </p>
                    </div>

                    <!-- Primary Action: WhatsApp Order Modal Trigger + Bookmark -->
                    <div class="flex flex-col gap-space-xs">
                        <div class="flex gap-2">
                            @if($isSold)
                                <button type="button" disabled class="flex-1 bg-surface-container border border-outline-variant text-outline p-space-md flex items-center justify-between cursor-not-allowed">
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-[24px]">block</span>
                                        <div class="flex flex-col text-left">
                                            <span class="font-headline-md text-headline-md uppercase tracking-tight leading-none">Item Sudah Terjual</span>
                                            <span class="font-label-sm text-[10px] uppercase tracking-wider mt-1">Ditampilkan sebagai arsip katalog</span>
                                        </div>
                                    </div>
                                </button>
                            @else
                                <button
                                    type="button"
                                    onclick="openOrderModal(this)"
                                    data-product-id="{{ $product->id }}"
                                    data-product-sku="{{ $product->sku }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-size="{{ $product->size_label }}"
                                    data-product-price="{{ $product->formatted_price }}"
                                    class="flex-1 bg-primary hover:bg-secondary-container text-on-primary hover:text-primary border border-primary p-space-md flex items-center justify-between transition-colors group hard-shadow"
                                >
                                    <div class="flex items-center gap-space-sm">
                                        <span class="material-symbols-outlined text-[28px]">chat</span>
                                        <div class="flex flex-col text-left">
                                            <span class="font-headline-md text-headline-md uppercase tracking-tight leading-none font-bold">Pesan Cepat via WhatsApp</span>
                                            <span class="font-label-sm text-[10px] uppercase tracking-wider mt-1 opacity-85">Catat Order &amp; Kirim Pesan Otomatis</span>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined text-[24px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </button>
                            @endif

                            <button
                                type="button"
                                data-bookmark-id="{{ $product->id }}"
                                onclick="toggleSaveProduct({{ $product->id }}, this)"
                                class="w-14 border border-primary bg-surface-container-lowest hover:bg-secondary-container text-primary flex items-center justify-center transition-colors shrink-0"
                                title="Simpan ke Daftar Favorit"
                            >
                                <span class="material-symbols-outlined text-[24px]">bookmark_border</span>
                            </button>
                        </div>

                        @if(!$isSold)
                            <p class="font-body-sm text-[11px] text-on-surface-variant text-center">
                                Format pemesanan &amp; SKU artikel terisi otomatis ke WhatsApp admin resmi.
                            </p>
                        @endif
                    </div>

                    <!-- Kondisi & Grading + Measurements Table (FR-25) -->
                    <div class="bg-surface-container-low border border-outline-variant p-space-md flex flex-col gap-space-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-label-lg text-label-lg uppercase text-primary">Kondisi &amp; Grading</span>
                            <span class="bg-surface-container-lowest border border-primary px-space-sm py-space-xs font-label-md text-label-md uppercase text-primary font-bold tabular-nums">
                                GRADE {{ number_format($product->condition_grade, 1) }} / 10
                            </span>
                        </div>

                        @if($product->condition_tag)
                            <span class="inline-block self-start bg-primary text-secondary-container font-label-sm text-label-sm px-2 py-0.5 uppercase tracking-wider">
                                {{ $product->condition_tag }}
                            </span>
                        @endif

                        <!-- Measurement Data Sheet -->
                        <div class="bg-surface-container-lowest border border-outline-variant p-space-sm flex flex-col gap-space-xs font-body-sm text-body-sm">
                            <div class="flex items-center justify-between pb-space-xs border-b border-outline-variant">
                                <span class="text-on-surface-variant">Ukuran Tag (Original):</span>
                                <span class="font-label-md text-label-md text-primary font-bold">SIZE {{ $product->size_label }}</span>
                            </div>

                            @if(!empty($product->measurements))
                                <div class="grid grid-cols-2 gap-x-space-md gap-y-space-xs pt-space-xs">
                                    @foreach($product->measurements as $mKey => $mVal)
                                        <div class="flex justify-between items-center border-b border-outline-variant/40 pb-1">
                                            <span class="text-on-surface-variant text-[12px]">{{ $measurementLabels[$mKey] ?? ucfirst(str_replace('_', ' ', $mKey)) }}:</span>
                                            <strong class="font-label-md text-label-md text-primary tabular-nums">{{ $mVal }} cm</strong>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Material, Flaws & Sanitation (FR-26) -->
                    <div class="bg-surface-container-low border border-outline-variant p-space-md flex flex-col gap-space-sm">
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold block mb-1">Detail Material &amp; Konstruksi</span>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                {{ $product->material ?: 'Material original era terkait telah diverifikasi oleh kurator studio VAULT.' }}
                            </p>
                        </div>
                        <div class="pt-2 border-t border-outline-variant/60">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold block mb-1">Catatan Minus / Karakter Vintage</span>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                {{ $product->flaws ?: 'Tidak ditemukan cacat struktural; kondisi terawat sesuai grade penilaian.' }}
                            </p>
                        </div>
                        <div class="bg-surface-container border border-outline-variant p-space-sm flex items-start gap-space-sm">
                            <span class="material-symbols-outlined text-secondary text-[22px] shrink-0">clean_hands</span>
                            <div>
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold block">Sanitasi &amp; Sterilisasi Siap Pakai</span>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    {{ $product->sanitation_note ?: 'Telah melalui dry cleaning profesional & ozone steaming 100°C.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment, Guarantee & Logistics -->
                    <div class="bg-surface-container-high border border-outline-variant p-space-md flex flex-col gap-space-sm">
                        <div class="flex items-center gap-space-xs font-label-md text-label-md uppercase tracking-wider text-primary font-bold">
                            <span class="material-symbols-outlined text-[18px]">account_balance_wallet</span>
                            Opsi Pembayaran Resmi &amp; Pengiriman
                        </div>
                        <div class="flex flex-wrap gap-space-xs">
                            <span class="bg-surface-container-lowest border border-outline-variant text-primary font-label-sm text-label-sm px-space-sm py-1 font-bold">BCA TRANSFER</span>
                            <span class="bg-surface-container-lowest border border-outline-variant text-primary font-label-sm text-label-sm px-space-sm py-1 font-bold">MANDIRI</span>
                            <span class="bg-surface-container-lowest border border-outline-variant text-primary font-label-sm text-label-sm px-space-sm py-1 font-bold">BNI</span>
                            <span class="bg-surface-container-lowest border border-outline-variant text-primary font-label-sm text-label-sm px-space-sm py-1 font-bold">QRIS ALL-PAY</span>
                        </div>
                        <div class="pt-space-xs flex flex-col gap-space-xs font-body-sm text-[12px] text-on-surface-variant">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-[16px] text-primary">local_shipping</span>
                                <span>Dikirim dari {{ $storeSettings['studio_address'] }} via JNE YES / SiCepat / Gosend.</span>
                            </div>
                            <div class="flex items-center gap-space-xs text-primary font-bold">
                                <span class="material-symbols-outlined text-[16px] text-secondary">security</span>
                                <span>100% Money-Back Guarantee jika terbukti tidak otentik.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPLEMENTARY ARCHIVE SECTION: Padukan dengan Koleksi Ini (FR-27) -->
    @if($relatedProducts->count() > 0)
        <section class="w-full bg-surface-container-low border-t border-outline-variant py-space-xl mt-space-md">
            <div class="max-w-[1440px] mx-auto px-margin md:px-margin-tablet lg:px-margin-desktop flex flex-col gap-space-lg">
                <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-space-sm pb-space-sm border-b border-outline-variant">
                    <div>
                        <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container bg-primary px-space-sm py-space-xs font-bold inline-block mb-space-xs">
                            STYLING RECOMMENDATION
                        </span>
                        <h2 class="font-headline-lg text-headline-lg uppercase text-primary">
                            Padukan dengan Koleksi Ini
                        </h2>
                    </div>
                    <a class="font-label-md text-label-md uppercase tracking-wider text-primary hover:underline flex items-center gap-space-xs font-bold" href="{{ route('catalog') }}">
                        Lihat Seluruh Koleksi
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm md:gap-space-md">
                    @foreach($relatedProducts as $rel)
                        <x-product-card :product="$rel"/>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

<!-- Sticky Mobile Bottom Checkout Bar (FR-34) -->
<div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-surface-container-lowest/95 backdrop-blur-md border-t border-primary p-space-sm flex items-center justify-between gap-space-sm">
    <div class="flex flex-col">
        <span class="font-label-sm text-[10px] uppercase text-on-surface-variant leading-none">{{ $isSold ? 'Terjual' : 'Harga Nett' }}</span>
        <span class="font-headline-md text-headline-md font-bold tabular-nums {{ $isSold ? 'text-outline line-through' : 'text-primary' }}">{{ $product->formatted_price }}</span>
    </div>
    @if($isSold)
        <button type="button" disabled class="bg-surface-container border border-outline-variant text-outline font-label-md text-label-md uppercase tracking-wider px-space-md py-2.5 cursor-not-allowed">
            Habis Terjual
        </button>
    @else
        <button
            type="button"
            onclick="openOrderModal(this)"
            data-product-id="{{ $product->id }}"
            data-product-sku="{{ $product->sku }}"
            data-product-name="{{ $product->name }}"
            data-product-size="{{ $product->size_label }}"
            data-product-price="{{ $product->formatted_price }}"
            class="bg-secondary-container border border-primary text-primary font-label-md text-label-md uppercase tracking-wider px-space-md py-2.5 flex items-center gap-space-xs font-bold"
        >
            <span class="material-symbols-outlined text-[18px]">chat</span>
            Order WA
        </button>
    @endif
</div>

<!-- Image Zoom Modal -->
<div id="zoom-modal" class="fixed inset-0 z-[75] hidden items-center justify-center bg-primary/90 p-4" onclick="closeZoomModal()">
    <div class="relative max-w-3xl w-full bg-surface-container-lowest border border-primary p-2" onclick="event.stopPropagation()">
        <button type="button" onclick="closeZoomModal()" class="absolute top-3 right-3 z-10 bg-primary text-on-primary p-1.5 hover:bg-secondary-container hover:text-primary">
            <span class="material-symbols-outlined">close</span>
        </button>
        <img id="zoom-modal-img" src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-full max-h-[85vh] object-contain bg-surface-container"/>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectThumbnail(btn, url) {
        const mainImg = document.getElementById('main-product-display');
        const zoomImg = document.getElementById('zoom-modal-img');
        if (mainImg) mainImg.src = url;
        if (zoomImg) zoomImg.src = url;

        document.querySelectorAll('.thumbnail-btn').forEach(el => {
            el.classList.remove('border-primary', 'ring-2', 'ring-primary', 'opacity-100');
            el.classList.add('border-outline-variant', 'opacity-75');
        });
        btn.classList.remove('border-outline-variant', 'opacity-75');
        btn.classList.add('border-primary', 'ring-2', 'ring-primary', 'opacity-100');
    }

    function openZoomModal() {
        const modal = document.getElementById('zoom-modal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeZoomModal() {
        const modal = document.getElementById('zoom-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>
@endpush

