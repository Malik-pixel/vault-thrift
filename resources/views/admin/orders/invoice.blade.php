<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Invoice &amp; Shipping Label {{ $order->order_no }} — VAULT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
        }
        .tabular-nums { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-zinc-100 text-zinc-900 font-sans p-6">
    <div class="max-w-2xl mx-auto mb-4 flex items-center justify-between no-print">
        <a href="{{ route('admin.orders.index', ['selected' => $order->id]) }}" class="px-4 py-2 border border-black bg-white text-xs font-bold uppercase hover:bg-zinc-200">
            ← Kembali ke Pesanan
        </a>
        <button onclick="window.print()" class="px-5 py-2 bg-black text-lime-300 text-xs font-bold uppercase hover:bg-lime-300 hover:text-black border border-black">
            Cetak Invoice / Thermal Label
        </button>
    </div>

    <!-- Invoice + Thermal Label Sheet -->
    <div class="max-w-2xl mx-auto bg-white border-2 border-black p-6 space-y-6">
        <!-- Header -->
        <div class="flex items-start justify-between border-b-2 border-black pb-4">
            <div>
                <h1 class="text-2xl font-black tracking-tight uppercase">VAULT CURATED THRIFT</h1>
                <p class="text-xs text-zinc-600 mt-1">{{ $storeSettings['studio_address'] }}</p>
                <p class="text-xs text-zinc-600">WhatsApp: +{{ $storeSettings['whatsapp_clean'] }} • {{ $storeSettings['instagram_handle'] }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block bg-black text-lime-300 px-2 py-0.5 text-[11px] font-bold uppercase">OFFICIAL ARCHIVE RECEIPT</span>
                <div class="text-lg font-bold mt-1">{{ $order->order_no }}</div>
                <div class="text-xs text-zinc-500">{{ $order->created_at?->format('d M Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- Thermal Shipping Label Block -->
        <div class="border-2 border-dashed border-black p-4 bg-zinc-50">
            <div class="flex items-center justify-between border-b border-black pb-2 mb-3">
                <span class="text-xs font-bold uppercase tracking-widest">LABEL PENGIRIMAN // 1-OF-1 PARCEL</span>
                <span class="text-xs font-bold uppercase bg-black text-white px-2 py-0.5">{{ $order->courier ?: 'KURIR REGULER' }}</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="font-bold uppercase text-zinc-500 block">KEPADA (PENERIMA):</span>
                    <div class="font-bold text-sm mt-0.5">{{ $order->buyer_name }}</div>
                    <div>{{ $order->buyer_phone }}</div>
                    <div class="mt-1">{{ $order->buyer_address }}{{ $order->buyer_city ? ', ' . $order->buyer_city : '' }}</div>
                </div>
                <div>
                    <span class="font-bold uppercase text-zinc-500 block">DARI (PENGIRIM):</span>
                    <div class="font-bold text-sm mt-0.5">VAULT CURATED THRIFT</div>
                    <div>+{{ $storeSettings['whatsapp_clean'] }}</div>
                    <div class="mt-1">No. Resi: <strong>{{ $order->tracking_no ?: '-' }}</strong></div>
                </div>
            </div>
        </div>

        <!-- Item Table -->
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-y-2 border-black bg-zinc-100 uppercase">
                    <th class="py-2 px-2">SKU</th>
                    <th class="py-2 px-2">Artikel Archive</th>
                    <th class="py-2 px-2">Size / Grade</th>
                    <th class="py-2 px-2 text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-zinc-300">
                    <td class="py-3 px-2 font-bold">{{ $order->product?->sku ?? '-' }}</td>
                    <td class="py-3 px-2">
                        <div class="font-bold uppercase">{{ $order->product?->name ?? '-' }}</div>
                        <div class="text-zinc-500">{{ $order->product?->brand ?? '' }}</div>
                    </td>
                    <td class="py-3 px-2">Size {{ $order->product?->size_label ?? '-' }} ({{ number_format($order->product?->condition_grade ?? 9, 1) }}/10)</td>
                    <td class="py-3 px-2 text-right font-bold tabular-nums">{{ $order->formatted_price }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 pt-2">
            <div class="text-xs text-zinc-600">
                <div>Metode Bayar: <strong>{{ $order->payment_method }}</strong></div>
                <div>Status Pesanan: <strong class="uppercase">{{ $order->status_label }}</strong></div>
                <div class="mt-2 font-semibold text-black">100% Authenticated &amp; Sanitized Archive Garment.</div>
            </div>
            <div class="text-right">
                <span class="text-xs uppercase text-zinc-500 block">TOTAL ARTIKEL</span>
                <span class="text-2xl font-black tabular-nums">{{ $order->formatted_price }}</span>
            </div>
        </div>
    </div>
</body>
</html>

