<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request, OrderService $orderService)
    {
        $q = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', 'all'));
        $urut = trim((string) $request->query('urut', 'newest'));

        $monthlyCount = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalOrders = Order::count();

        $pendingCount = Order::where('status', Order::STATUS_PENDING)->count();
        $pendingValue = (int) Order::where('status', Order::STATUS_PENDING)->sum('price_snapshot');

        $readyCount = Order::where('status', Order::STATUS_PAID)->count();
        $readyValue = (int) Order::where('status', Order::STATUS_PAID)->sum('price_snapshot');

        $shippingCount = Order::where('status', Order::STATUS_SHIPPING)->count();
        $doneCount = Order::where('status', Order::STATUS_DONE)->count();
        $doneValue = (int) Order::where('status', Order::STATUS_DONE)->sum('price_snapshot');
        $cancelledCount = Order::where('status', Order::STATUS_CANCELLED)->count();

        $query = Order::with(['product.images', 'product.category']);

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('order_no', 'like', "%{$q}%")
                    ->orWhere('buyer_name', 'like', "%{$q}%")
                    ->orWhere('buyer_phone', 'like', "%{$q}%")
                    ->orWhereHas('product', fn ($pq) => $pq->where('sku', 'like', "%{$q}%")->orWhere('name', 'like', "%{$q}%"));
            });
        }

        if ($status !== '' && $status !== 'all') {
            $query->where('status', $status);
        }

        match ($urut) {
            'price_desc' => $query->orderBy('price_snapshot', 'desc'),
            'pending_first' => $query->orderByRaw("CASE WHEN status = 'menunggu_konfirmasi' THEN 0 ELSE 1 END")->orderByDesc('id'),
            default => $query->orderByDesc('id'),
        };

        $orders = $query->paginate(10)->withQueryString();

        $selectedId = $request->query('selected');
        $selectedOrder = null;

        if ($selectedId) {
            $selectedOrder = Order::with(['product.images', 'statusLogs'])->find($selectedId);
        }
        if (!$selectedOrder && $orders->count() > 0) {
            $selectedOrder = Order::with(['product.images', 'statusLogs'])->find($orders->first()->id);
        }

        $availableProducts = Product::available()->orderBy('sku')->get();

        $buyerWaUrl = $selectedOrder ? $orderService->getBuyerWhatsAppUrl($selectedOrder) : null;
        $trackingWaUrl = $selectedOrder
            ? $orderService->getBuyerWhatsAppUrl($selectedOrder, $orderService->formatTrackingMessage($selectedOrder))
            : null;

        return view('admin.orders.index', compact(
            'orders',
            'selectedOrder',
            'availableProducts',
            'buyerWaUrl',
            'trackingWaUrl',
            'monthlyCount',
            'totalOrders',
            'pendingCount',
            'pendingValue',
            'readyCount',
            'readyValue',
            'shippingCount',
            'doneCount',
            'doneValue',
            'cancelledCount',
            'q',
            'status',
            'urut'
        ));
    }

    public function poll()
    {
        return response()->json([
            'total' => Order::count(),
            'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'latest_id' => Order::max('id') ?? 0,
            'checked_at' => now()->format('H:i:s'),
        ]);
    }

    public function storeManual(Request $request, OrderService $orderService)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'buyer_name' => ['required', 'string', 'max:120'],
            'buyer_phone' => ['required', 'string', 'min:8', 'max:30'],
            'buyer_address' => ['required', 'string', 'max:500'],
            'buyer_city' => ['nullable', 'string', 'max:120'],
            'payment_method' => ['required', 'in:BCA,Mandiri,BNI,QRIS'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        try {
            $order = $orderService->createOrder($product, $validated);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.orders.index', ['selected' => $order->id])
            ->with('success', "Pesanan manual {$order->order_no} berhasil dicatat.");
    }

    public function confirmPaid(Order $order, OrderService $orderService)
    {
        try {
            $cancelledOthers = $orderService->confirmPaid($order);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $extra = $cancelledOthers > 0
            ? " {$cancelledOthers} pesanan menunggu lain untuk item ini otomatis dibatalkan."
            : '';

        return redirect()
            ->route('admin.orders.index', array_filter([
                'selected' => $order->id,
                'status' => request('status'),
            ]))
            ->with('success', "Pembayaran {$order->order_no} dikonfirmasi LUNAS. Produk otomatis berstatus HABIS.{$extra}");
    }

    public function updateStatus(Request $request, Order $order, OrderService $orderService)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_konfirmasi,lunas,dalam_pengiriman,selesai,batal'],
            'courier' => ['nullable', 'string', 'max:60'],
            'tracking_no' => ['nullable', 'string', 'max:100'],
            'note' => ['nullable', 'string', 'max:250'],
        ]);

        if ($validated['status'] === Order::STATUS_PAID && $order->status === Order::STATUS_PENDING) {
            return $this->confirmPaid($order, $orderService);
        }

        $orderService->updateStatus(
            $order,
            $validated['status'],
            $validated['courier'] ?? null,
            $validated['tracking_no'] ?? null,
            $validated['note'] ?? null
        );

        return redirect()
            ->route('admin.orders.index', ['selected' => $order->id])
            ->with('success', "Status pesanan {$order->order_no} diperbarui menjadi " . (Order::STATUS_LABELS[$validated['status']] ?? $validated['status']) . '.');
    }

    public function invoice(Order $order)
    {
        $order->load(['product.category', 'statusLogs']);
        return view('admin.orders.invoice', compact('order'));
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'vault-pesanan-' . date('Ymd-His') . '.csv';
        $orders = Order::with('product')->orderByDesc('id')->get();

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No Order', 'Waktu', 'Pembeli', 'No WA', 'Kota', 'Alamat', 'SKU', 'Artikel', 'Nominal (IDR)', 'Metode Bayar', 'Status', 'Kurir', 'No Resi']);

            foreach ($orders as $o) {
                fputcsv($handle, [
                    $o->order_no,
                    $o->created_at?->format('Y-m-d H:i'),
                    $o->buyer_name,
                    $o->buyer_phone,
                    $o->buyer_city ?? '-',
                    $o->buyer_address,
                    $o->product?->sku ?? '-',
                    $o->product?->name ?? '-',
                    $o->price_snapshot,
                    $o->payment_method,
                    $o->status_label,
                    $o->courier ?? '-',
                    $o->tracking_no ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

