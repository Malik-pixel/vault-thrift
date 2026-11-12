@extends('layouts.admin')

@section('title', 'Pesanan & WhatsApp Log — VAULT Admin')

@section('content')
<div class="flex flex-col w-full pb-space-xl">
    <!-- Top Context & Polling Bar -->
    <div class="px-space-md md:px-space-lg py-space-md bg-surface-container-low border-b border-outline-variant flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">
                <span>Konsol Kurator</span>
                <span>/</span>
                <span class="text-primary font-bold">Pesanan &amp; Log WhatsApp Transaksi</span>
            </div>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 pt-0.5">
                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-surface-container-lowest border border-outline-variant">
                    <span class="w-2 h-2 rounded-full bg-secondary-container border border-primary animate-pulse"></span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface">WA Order Log: Aktif</span>
                </div>
                <div class="inline-flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant">
                    <span class="material-symbols-outlined text-[14px] text-secondary">sync</span>
                    <span>Polling Sinkronisasi: <strong id="poll-status">5s Realtime</strong></span>
                </div>
                <div class="inline-flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant">
                    <span class="material-symbols-outlined text-[14px]">inbox</span>
                    <span>Total Transaksi Masuk: <strong>{{ $totalOrders }} Pesanan</strong></span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-space-sm">
            <a href="{{ route('admin.orders.export') }}" class="inline-flex items-center gap-1.5 px-space-md py-2 bg-surface-container-lowest border border-primary text-on-surface hover:bg-surface-container transition-colors font-label-md text-label-md uppercase font-bold">
                <span class="material-symbols-outlined text-[16px]">file_download</span>
                <span>Export Rekap CSV</span>
            </a>
            <button type="button" onclick="openManualOrderModal()" class="inline-flex items-center gap-1.5 px-space-md py-2 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary transition-colors font-label-md text-label-md uppercase font-bold">
                <span class="material-symbols-outlined text-[16px]">point_of_sale</span>
                <span>+ Pesanan Manual / Studio</span>
            </button>
        </div>
    </div>

    <!-- New Order Live Poll Alert -->
    <div id="new-order-banner" class="hidden mx-space-md md:mx-space-lg mt-space-md bg-secondary-container border border-primary p-3 flex items-center justify-between">
        <div class="flex items-center gap-2 font-label-md text-label-md uppercase font-bold text-primary">
            <span class="material-symbols-outlined text-[20px]">notifications_active</span>
            <span>Pesanan WhatsApp baru terdeteksi masuk!</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="px-3 py-1 bg-primary text-on-primary font-label-sm text-label-sm uppercase font-bold">Muat Ulang Daftar</a>
    </div>

    <div class="p-space-md md:p-space-lg flex flex-col gap-space-lg">
        <!-- 4 KPI Cards (FR-70) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
            <div class="p-space-md bg-surface-container-lowest border border-outline-variant flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Total Pesanan Bulan Ini</span>
                    <span class="material-symbols-outlined text-[20px] text-on-surface-variant">chat_bubble</span>
                </div>
                <div class="mt-space-md flex items-baseline gap-2">
                    <span class="font-display-lg text-headline-lg text-primary font-bold tabular-nums">{{ $monthlyCount }}</span>
                    <span class="font-label-md text-label-md uppercase text-secondary font-bold">Pesanan</span>
                </div>
            </div>

            <div class="p-space-md bg-surface-container-lowest border border-primary border-r-4 border-r-secondary-container flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Menunggu Konfirmasi</span>
                    <span class="px-1.5 py-0.5 bg-surface-container-high border border-outline-variant text-on-surface font-label-sm text-label-sm uppercase font-bold">{{ $pendingCount }} Pending</span>
                </div>
                <div class="mt-space-md">
                    <span class="font-headline-md text-headline-md text-primary font-bold tabular-nums">{{ \App\Models\Product::formatRupiah($pendingValue) }}</span>
                </div>
            </div>

            <div class="p-space-md bg-surface-container-lowest border border-outline-variant flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Lunas &amp; Siap Kirim</span>
                    <span class="px-1.5 py-0.5 bg-secondary-container border border-primary text-primary font-label-sm text-label-sm uppercase font-bold">{{ $readyCount }} Order</span>
                </div>
                <div class="mt-space-md">
                    <span class="font-headline-md text-headline-md text-primary font-bold tabular-nums">{{ \App\Models\Product::formatRupiah($readyValue) }}</span>
                </div>
            </div>

            <div class="p-space-md bg-surface-container-lowest border border-outline-variant flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant">Selesai / Closed Archive</span>
                    <span class="px-1.5 py-0.5 bg-surface-container-high border border-outline-variant text-on-surface font-label-sm text-label-sm uppercase font-bold">{{ $doneCount }} Order</span>
                </div>
                <div class="mt-space-md">
                    <span class="font-headline-md text-headline-md text-primary font-bold tabular-nums">{{ \App\Models\Product::formatRupiah($doneValue) }}</span>
                </div>
            </div>
        </div>

        <!-- Master-Detail 2-Column Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
            <!-- LEFT COLUMN (8 cols): Search, Status Tabs, Table -->
            <div class="lg:col-span-8 flex flex-col gap-space-md">
                <form action="{{ route('admin.orders.index') }}" method="GET" class="p-space-md bg-surface-container-lowest border border-outline-variant flex flex-col gap-space-md">
                    <input type="hidden" name="status" id="order-filter-status" value="{{ $status }}"/>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-space-sm">
                        <div class="relative flex-1 flex">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant">search</span>
                            <input name="q" value="{{ $q }}" class="w-full bg-surface-container-low border border-outline-variant focus:border-primary text-on-surface font-body-sm text-body-sm pl-9 pr-3 py-2 focus:outline-none placeholder:text-on-surface-variant" placeholder="Cari No. Order (ORD-), Nama Pembeli, No. WA, atau SKU..." type="text"/>
                            <button type="submit" class="bg-primary text-on-primary px-4 font-label-sm text-label-sm uppercase font-bold">Cari</button>
                        </div>
                        <select name="urut" onchange="this.form.submit()" class="bg-surface-container-low border border-outline-variant text-on-surface font-label-sm text-label-sm uppercase px-3 py-2 focus:outline-none cursor-pointer">
                            <option value="newest" {{ $urut === 'newest' ? 'selected' : '' }}>Terbaru Masuk</option>
                            <option value="pending_first" {{ $urut === 'pending_first' ? 'selected' : '' }}>Menunggu Konfirmasi Dulu</option>
                            <option value="price_desc" {{ $urut === 'price_desc' ? 'selected' : '' }}>Nominal Tertinggi</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-nowrap">
                        @foreach([
                            'all' => "Semua ({$totalOrders})",
                            'menunggu_konfirmasi' => "Menunggu Konfirmasi ({$pendingCount})",
                            'lunas' => "Lunas / Siap Kirim ({$readyCount})",
                            'dalam_pengiriman' => "Dalam Pengiriman ({$shippingCount})",
                            'selesai' => "Selesai ({$doneCount})",
                            'batal' => "Batal ({$cancelledCount})",
                        ] as $stKey => $stText)
                            <button type="button" onclick="document.getElementById('order-filter-status').value='{{ $stKey }}'; this.form.submit();"
                                    class="px-3 py-1.5 border font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ $status === $stKey ? 'bg-primary text-on-primary border-primary font-bold' : 'bg-surface-container-low border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary' }}">
                                {{ $stText }}
                            </button>
                        @endforeach
                    </div>
                </form>

                <!-- Orders Table -->
                <div class="bg-surface-container-lowest border border-outline-variant overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low border-b border-outline-variant font-label-sm text-label-sm uppercase text-on-surface-variant tracking-wider">
                                    <th class="py-3 px-4">Order / Waktu</th>
                                    <th class="py-3 px-4">Pembeli &amp; Kontak</th>
                                    <th class="py-3 px-4">Artikel 1-of-1</th>
                                    <th class="py-3 px-4">Nominal</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-right">Inspeksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/60 font-body-sm text-body-sm text-on-surface">
                                @forelse($orders as $order)
                                    @php
                                        $isSelected = $selectedOrder && $selectedOrder->id === $order->id;
                                        $badgeStyle = match($order->status) {
                                            'menunggu_konfirmasi' => 'bg-secondary-container border border-primary text-primary font-bold',
                                            'lunas' => 'bg-primary text-secondary-container font-bold',
                                            'dalam_pengiriman' => 'bg-surface-container-high border border-primary text-primary font-bold',
                                            'selesai' => 'bg-surface-container border border-outline-variant text-on-surface font-semibold',
                                            'batal' => 'bg-error-container border border-error text-on-error-container font-semibold',
                                            default => 'bg-surface-container',
                                        };
                                    @endphp
                                    <tr class="transition-colors {{ $isSelected ? 'bg-surface-container-high' : 'hover:bg-surface-container-low' }}">
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-label-md text-label-md text-primary font-bold">{{ $order->order_no }}</span>
                                                <span class="font-label-sm text-[10px] text-on-surface-variant uppercase">{{ $order->created_at?->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-primary">{{ $order->buyer_name }}</span>
                                                <span class="font-label-sm text-[11px] text-on-surface-variant">{{ $order->buyer_phone }}</span>
                                                @if($order->buyer_city)
                                                    <span class="text-[11px] text-outline">{{ $order->buyer_city }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2.5 min-w-[180px]">
                                                <div class="w-10 h-12 bg-surface-container border border-outline-variant shrink-0 overflow-hidden">
                                                    <img src="{{ $order->product?->primary_image_url ?? asset('images/demo/placeholder-archive.svg') }}" class="w-full h-full object-cover"/>
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <span class="font-label-sm text-[10px] text-secondary uppercase font-bold">{{ $order->product?->sku ?? '-' }}</span>
                                                    <span class="font-label-md text-label-md text-primary truncate max-w-[140px] font-semibold">{{ $order->product?->name ?? 'Artikel Dihapus' }}</span>
                                                    <span class="font-label-sm text-[10px] text-on-surface-variant">Size {{ $order->product?->size_label ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-label-md text-label-md font-bold text-primary tabular-nums">{{ $order->formatted_price }}</span>
                                                <span class="font-label-sm text-[10px] text-on-surface-variant uppercase">{{ $order->payment_method }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 font-label-sm text-[10px] uppercase {{ $badgeStyle }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right whitespace-nowrap">
                                            <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['selected' => $order->id])) }}"
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 border border-primary font-label-sm text-label-sm uppercase font-bold {{ $isSelected ? 'bg-primary text-secondary-container' : 'bg-surface-container-lowest text-primary hover:bg-secondary-container' }}">
                                                <span>Pilih</span>
                                                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-10 text-center text-on-surface-variant">Belum ada pesanan yang cocok dengan pencarian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($orders->hasPages())
                        <div class="p-space-md border-t border-outline-variant flex items-center justify-between">
                            <span class="font-label-sm text-label-sm uppercase text-on-surface-variant">
                                Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} Log
                            </span>
                            <div>{{ $orders->links() }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN (4 cols): LIVE INSPECTOR (FR-73, FR-74) -->
            <div class="lg:col-span-4 flex flex-col gap-space-md sticky top-20">
                @if($selectedOrder)
                    <div class="bg-surface-container-lowest border border-primary hard-shadow overflow-hidden flex flex-col">
                        <!-- Header -->
                        <div class="p-space-md bg-primary text-on-primary flex items-center justify-between gap-2">
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm uppercase text-secondary-container tracking-wider">Live Inspector</span>
                                <span class="font-headline-md text-headline-md font-bold tracking-tight uppercase">{{ $selectedOrder->order_no }}</span>
                            </div>
                            <a href="{{ $buyerWaUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 font-label-sm text-label-sm uppercase px-2.5 py-1.5 bg-secondary-container text-primary hover:bg-surface-container-lowest font-bold transition-colors">
                                <span>Buka WA</span>
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                            </a>
                        </div>

                        <!-- Buyer & Product Summary -->
                        <div class="p-space-md bg-surface-container-low border-b border-outline-variant flex flex-col gap-space-sm">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md uppercase text-primary font-bold">{{ $selectedOrder->buyer_name }}</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $selectedOrder->buyer_phone }}</span>
                                    <span class="font-body-sm text-[12px] text-on-surface-variant mt-0.5">
                                        {{ $selectedOrder->buyer_address }}{{ $selectedOrder->buyer_city ? ', ' . $selectedOrder->buyer_city : '' }}
                                    </span>
                                </div>
                                <span class="px-2 py-0.5 bg-surface-container-lowest border border-primary font-label-sm text-[10px] uppercase font-bold shrink-0">
                                    {{ $selectedOrder->status_label }}
                                </span>
                            </div>

                            @if($selectedOrder->product)
                                <div class="p-space-sm bg-surface-container-lowest border border-outline-variant flex items-center gap-3">
                                    <div class="w-12 h-14 bg-surface-container border border-outline-variant shrink-0 overflow-hidden">
                                        <img src="{{ $selectedOrder->product->primary_image_url }}" class="w-full h-full object-cover"/>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-label-sm text-[10px] text-secondary uppercase font-bold">
                                            {{ $selectedOrder->product->sku }} • {{ $selectedOrder->product->isSold() ? 'HABIS' : 'TERSEDIA' }}
                                        </span>
                                        <a href="{{ route('product.show', $selectedOrder->product->slug) }}" target="_blank" class="font-label-md text-label-md text-primary font-bold truncate hover:underline">
                                            {{ $selectedOrder->product->name }}
                                        </a>
                                        <span class="font-label-sm text-[11px] text-on-surface-variant">Size {{ $selectedOrder->product->size_label }} • Grade {{ number_format($selectedOrder->product->condition_grade, 1) }}/10</span>
                                        <span class="font-label-md text-label-md font-bold text-primary tabular-nums mt-0.5">{{ $selectedOrder->formatted_price }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- WA Message Transcript -->
                        <div class="p-space-md border-b border-outline-variant bg-surface">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-label-sm text-[10px] uppercase text-secondary font-bold">[ PESAN WHATSAPP OTOMATIS ]</span>
                                <span class="font-label-sm text-[10px] text-outline">{{ $selectedOrder->created_at?->format('d M H:i') }}</span>
                            </div>
                            <pre class="bg-surface-container-lowest border border-outline-variant p-3 text-[12px] font-body-sm whitespace-pre-wrap text-on-surface max-h-44 overflow-y-auto">{{ $selectedOrder->wa_message }}</pre>
                        </div>

                        <!-- Workflow Quick Actions -->
                        <div class="p-space-md bg-surface-container-low flex flex-col gap-space-sm">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-bold">Alur Kerja Cepat Kurator:</span>

                            @if($selectedOrder->status === \App\Models\Order::STATUS_PENDING)
                                <form action="{{ route('admin.orders.confirm-paid', $selectedOrder) }}" method="POST" onsubmit="return confirm('Konfirmasi LUNAS untuk {{ $selectedOrder->order_no }}? Produk otomatis menjadi HABIS dan pesanan menunggu lain untuk item ini akan otomatis BATAL.')">
                                    @csrf
                                    <button type="submit" class="w-full py-2.5 px-space-md bg-secondary-container border border-primary text-primary hover:bg-primary hover:text-secondary-container transition-colors font-label-md text-label-md uppercase font-bold flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[18px]">verified</span>
                                        <span>Konfirmasi Lunas &amp; Kunci Stok</span>
                                    </button>
                                </form>
                            @endif

                            <!-- Courier + Tracking + Status Update Form -->
                            <form action="{{ route('admin.orders.update-status', $selectedOrder) }}" method="POST" class="flex flex-col gap-2 pt-1">
                                @csrf
                                @method('PATCH')
                                <div class="flex gap-2">
                                    <select name="courier" class="bg-surface-container-lowest border border-outline-variant text-on-surface font-label-sm text-label-sm uppercase px-2 py-2 w-32 focus:border-primary focus:outline-none">
                                        @foreach(['JNE YES', 'JNE REG', 'SiCepat Best', 'J&T Express', 'Gosend Instant', 'Ambil di Studio'] as $c)
                                            <option value="{{ $c }}" {{ $selectedOrder->courier === $c ? 'selected' : '' }}>{{ $c }}</option>
                                        @endforeach
                                    </select>
                                    <input name="tracking_no" value="{{ $selectedOrder->tracking_no }}" class="flex-1 bg-surface-container-lowest border border-outline-variant px-3 py-2 text-body-sm focus:border-primary focus:outline-none" placeholder="Masukkan Nomor Resi..." type="text"/>
                                </div>
                                <div class="flex gap-2">
                                    <select name="status" class="flex-1 bg-surface-container-lowest border border-outline-variant font-label-sm text-label-sm uppercase px-2.5 py-2 focus:border-primary focus:outline-none">
                                        @foreach(\App\Models\Order::STATUS_LABELS as $sVal => $sLabel)
                                            <option value="{{ $sVal }}" {{ $selectedOrder->status === $sVal ? 'selected' : '' }}>{{ $sLabel }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-sm text-label-sm uppercase font-bold transition-colors">
                                        Simpan
                                    </button>
                                </div>
                            </form>

                            <a href="{{ $trackingWaUrl }}" target="_blank" rel="noopener noreferrer" class="w-full py-2 px-space-md bg-surface-container-lowest border border-outline-variant hover:border-primary text-on-surface transition-colors font-label-sm text-label-sm uppercase font-semibold flex items-center justify-center gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-secondary">send</span>
                                <span>Kirim Template Resi ke WA Pembeli</span>
                            </a>

                            <div class="grid grid-cols-1 pt-1">
                                <a href="{{ route('admin.orders.invoice', $selectedOrder) }}" target="_blank" class="py-2 px-3 bg-surface-container-lowest border border-outline-variant hover:border-primary text-on-surface transition-colors font-label-sm text-label-sm uppercase flex items-center justify-center gap-1.5 font-bold">
                                    <span class="material-symbols-outlined text-[16px]">print</span>
                                    <span>Cetak Invoice &amp; Thermal Label</span>
                                </a>
                            </div>
                        </div>

                        <!-- Audit Status Logs -->
                        <div class="p-space-md border-t border-outline-variant bg-surface-container-lowest">
                            <span class="font-label-sm text-[10px] uppercase tracking-wider text-outline block mb-2">Riwayat Perubahan Status:</span>
                            <div class="flex flex-col gap-1.5">
                                @foreach($selectedOrder->statusLogs as $log)
                                    <div class="text-[11px] flex items-start justify-between gap-2 border-l-2 border-primary pl-2">
                                        <div>
                                            <span class="font-bold uppercase text-primary">{{ \App\Models\Order::STATUS_LABELS[$log->status] ?? $log->status }}</span>
                                            <p class="text-on-surface-variant">{{ $log->note }}</p>
                                        </div>
                                        <span class="text-outline shrink-0">{{ $log->created_at?->format('d/m H:i') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 1-of-1 Reminder -->
                    <div class="p-space-md bg-surface-container-lowest border border-outline-variant flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px] text-secondary mt-0.5">info</span>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm uppercase font-bold text-primary">Aturan 1-of-1 Otomatis</span>
                            <p class="font-body-sm text-[12px] text-on-surface-variant leading-relaxed mt-0.5">
                                Menekan <strong>Konfirmasi Lunas</strong> mengunci stok produk menjadi HABIS secara atomik dan membatalkan pesanan menunggu lain untuk produk yang sama.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-surface-container-lowest border border-outline-variant p-space-xl text-center text-on-surface-variant">
                        Pilih salah satu pesanan pada tabel untuk membuka Live Inspector.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Manual / Studio Order Modal -->
<div id="manual-order-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-primary/75 p-4">
    <div class="bg-surface-container-lowest border border-primary hard-shadow w-full max-w-lg">
        <div class="bg-primary text-on-primary px-space-md py-3 flex items-center justify-between">
            <span class="font-label-md text-label-md uppercase font-bold">+ Catat Pesanan Manual / Studio</span>
            <button type="button" onclick="closeManualOrderModal()" class="text-surface"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form action="{{ route('admin.orders.store') }}" method="POST" class="p-space-md flex flex-col gap-3">
            @csrf
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Pilih Artikel Tersedia <span class="text-error">*</span></label>
                <select name="product_id" required class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm focus:border-primary focus:outline-none">
                    <option value="">-- Pilih Produk Tersedia --</option>
                    @foreach($availableProducts as $ap)
                        <option value="{{ $ap->id }}">{{ $ap->sku }} — {{ $ap->name }} ({{ $ap->formatted_price }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Nama Pembeli <span class="text-error">*</span></label>
                    <input name="buyer_name" required type="text" class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm"/>
                </div>
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">No. WhatsApp <span class="text-error">*</span></label>
                    <input name="buyer_phone" required type="text" placeholder="0812..." class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm"/>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Kota</label>
                    <input name="buyer_city" type="text" class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm"/>
                </div>
                <div>
                    <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Metode Bayar</label>
                    <select name="payment_method" class="w-full bg-surface border border-outline-variant px-3 py-2 text-body-sm">
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BNI">BNI</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-label-sm text-label-sm uppercase font-bold mb-1">Alamat Lengkap <span class="text-error">*</span></label>
                <textarea name="buyer_address" required rows="2" class="w-full bg-surface border border-outline-variant p-2.5 text-body-sm resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeManualOrderModal()" class="px-4 py-2 border border-primary font-label-sm text-label-sm uppercase">Batal</button>
                <button type="submit" class="px-5 py-2 bg-primary text-on-primary hover:bg-secondary-container hover:text-primary border border-primary font-label-sm text-label-sm uppercase font-bold">Simpan Pesanan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openManualOrderModal() {
        const m = document.getElementById('manual-order-modal');
        m.classList.remove('hidden');
        m.classList.add('flex');
    }
    function closeManualOrderModal() {
        const m = document.getElementById('manual-order-modal');
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    // 5-second AJAX polling (FR-76)
    (function startOrderPolling() {
        let baselineTotal = {{ $totalOrders }};
        const statusEl = document.getElementById('poll-status');
        const banner = document.getElementById('new-order-banner');

        setInterval(async () => {
            try {
                const res = await fetch('{{ route("admin.orders.poll") }}', { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const data = await res.json();
                if (statusEl) statusEl.textContent = 'Sync ' + data.checked_at;
                if (data.total > baselineTotal && banner) {
                    banner.classList.remove('hidden');
                }
            } catch (e) {}
        }, 5000);
    })();
</script>
@endpush

