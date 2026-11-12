@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan — VAULT Admin')

@section('content')
<div class="p-space-md md:p-space-lg flex flex-col gap-space-lg">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md pb-space-sm border-b border-outline-variant">
        <div>
            <span class="px-2 py-0.5 bg-primary text-on-primary font-label-sm text-label-sm uppercase tracking-widest">OVERVIEW CONSOLE</span>
            <h1 class="font-headline-lg text-headline-lg text-primary uppercase mt-1">DASHBOARD RINGKASAN VAULT</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Ringkasan inventaris 1-of-1, nilai arsip tersedia, dan aktivitas pesanan WhatsApp.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-md text-label-md uppercase font-bold inline-flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Produk Baru
            </a>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-surface-container-lowest border border-primary text-primary hover:bg-surface-container font-label-md text-label-md uppercase font-bold inline-flex items-center gap-1 transition-colors">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                Buka WA Log
            </a>
        </div>
    </div>

    <!-- Product KPIs -->
    <div>
        <h2 class="font-label-sm text-label-sm uppercase tracking-widest text-outline mb-2">METRIK INVENTARIS ARSIP</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">TOTAL PRODUK</span>
                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant">archive</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $totalProducts }}</span>
                    <span class="font-label-sm text-label-sm px-1.5 py-0.5 bg-surface-container text-on-surface uppercase">{{ $categories->count() }} Kategori</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">STOK TERSEDIA</span>
                    <span class="material-symbols-outlined text-[18px] text-secondary">check_circle</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $availableProducts }}</span>
                    <span class="font-label-sm text-label-sm px-2 py-0.5 bg-secondary-container border border-primary text-primary uppercase font-bold">Siap Jual</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">TERJUAL / ARCHIVED</span>
                    <span class="material-symbols-outlined text-[18px] text-tertiary">remove_shopping_cart</span>
                </div>
                <div class="mt-space-sm flex items-baseline justify-between">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $soldProducts }}</span>
                    <span class="font-label-sm text-label-sm px-2 py-0.5 bg-surface-container-high text-on-surface-variant uppercase">Sold Out</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-space-md flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">NILAI STOK TERSEDIA</span>
                    <span class="material-symbols-outlined text-[18px] text-primary">payments</span>
                </div>
                <div class="mt-space-sm">
                    <span class="font-headline-md text-headline-md text-primary font-bold tabular-nums">{{ \App\Models\Product::formatRupiah($inventoryValue) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order KPIs -->
    <div>
        <h2 class="font-label-sm text-label-sm uppercase tracking-widest text-outline mb-2">METRIK PESANAN WHATSAPP</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div class="bg-surface-container-lowest border border-outline-variant p-space-md">
                <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">PESANAN BULAN INI</span>
                <div class="mt-2 font-headline-lg text-headline-lg font-bold text-primary tabular-nums">{{ $monthlyOrdersCount }}</div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Leads masuk via form WA</span>
            </div>
            <div class="bg-surface-container-lowest border border-primary p-space-md border-l-4 border-l-secondary-container">
                <div class="flex justify-between items-center">
                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">MENUNGGU KONFIRMASI</span>
                    <span class="bg-secondary-container border border-primary px-1.5 py-0.5 font-label-sm text-[10px] font-bold">{{ $pendingOrdersCount }}</span>
                </div>
                <div class="mt-2 font-headline-md text-headline-md font-bold text-primary tabular-nums">{{ \App\Models\Product::formatRupiah($pendingOrdersValue) }}</div>
                <a href="{{ route('admin.orders.index', ['status' => 'menunggu_konfirmasi']) }}" class="text-[11px] font-label-sm uppercase text-secondary hover:underline mt-1 inline-block font-bold">Proses Sekarang →</a>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant p-space-md">
                <div class="flex justify-between items-center">
                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">LUNAS / SIAP KIRIM</span>
                    <span class="bg-surface-container-high px-1.5 py-0.5 font-label-sm text-[10px] font-bold">{{ $readyOrdersCount }}</span>
                </div>
                <div class="mt-2 font-headline-md text-headline-md font-bold text-primary tabular-nums">{{ \App\Models\Product::formatRupiah($readyOrdersValue) }}</div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Menunggu input resi kurir</span>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant p-space-md">
                <div class="flex justify-between items-center">
                    <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">OMZET TERKONFIRMASI</span>
                    <span class="bg-primary text-on-primary px-1.5 py-0.5 font-label-sm text-[10px]">{{ $completedOrdersCount }} Kirim/Selesai</span>
                </div>
                <div class="mt-2 font-headline-md text-headline-md font-bold text-primary tabular-nums">{{ \App\Models\Product::formatRupiah($completedRevenue) }}</div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Total transaksi lunas</span>
            </div>
        </div>
    </div>

    <!-- Bottom 2-Column Activity Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
        <!-- Recent Orders -->
        <div class="lg:col-span-7 bg-surface-container-lowest border border-outline-variant">
            <div class="px-space-md py-3 bg-surface-container-low border-b border-outline-variant flex items-center justify-between">
                <span class="font-label-md text-label-md uppercase font-bold text-primary">PESANAN WHATSAPP TERBARU</span>
                <a href="{{ route('admin.orders.index') }}" class="font-label-sm text-label-sm uppercase text-secondary hover:underline font-bold">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-outline-variant/60">
                @forelse($recentOrders as $ro)
                    <a href="{{ route('admin.orders.index', ['selected' => $ro->id]) }}" class="p-space-md flex items-center justify-between gap-3 hover:bg-surface-container-low transition-colors">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-label-md text-label-md font-bold text-primary">{{ $ro->order_no }}</span>
                                <span class="font-label-sm text-[10px] uppercase px-1.5 py-0.5 bg-surface-container border border-outline-variant">{{ $ro->status_label }}</span>
                            </div>
                            <p class="text-body-sm text-on-surface truncate mt-0.5">{{ $ro->buyer_name }} — {{ $ro->product?->name ?? '-' }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="font-label-md text-label-md font-bold text-primary tabular-nums block">{{ $ro->formatted_price }}</span>
                            <span class="font-label-sm text-[10px] text-outline">{{ $ro->created_at?->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-space-lg text-center text-on-surface-variant text-body-sm">Belum ada pesanan masuk.</div>
                @endforelse
            </div>
        </div>

        <!-- Category Stock Breakdown -->
        <div class="lg:col-span-5 bg-surface-container-lowest border border-outline-variant flex flex-col justify-between">
            <div>
                <div class="px-space-md py-3 bg-surface-container-low border-b border-outline-variant flex items-center justify-between">
                    <span class="font-label-md text-label-md uppercase font-bold text-primary">STOK PER KATEGORI</span>
                    <a href="{{ route('admin.categories.index') }}" class="font-label-sm text-label-sm uppercase text-secondary hover:underline font-bold">Kelola →</a>
                </div>
                <div class="divide-y divide-outline-variant/60">
                    @foreach($categories as $cat)
                        <div class="p-space-md flex items-center justify-between">
                            <div>
                                <span class="font-label-md text-label-md uppercase font-bold text-primary block">{{ $cat->name }}</span>
                                <span class="font-body-sm text-[11px] text-on-surface-variant">Slug: {{ $cat->slug }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-secondary-container border border-primary font-label-sm text-label-sm font-bold text-primary">{{ $cat->available_count }} Ready</span>
                                <span class="px-2 py-0.5 bg-surface-container border border-outline-variant font-label-sm text-label-sm text-on-surface-variant">{{ $cat->products_count }} Total</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="p-space-md bg-surface-container-low border-t border-outline-variant">
                <a href="{{ route('admin.products.index') }}" class="w-full block text-center py-2.5 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary font-label-md text-label-md uppercase font-bold transition-colors">
                    Buka Repository Produk Lengkap
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

