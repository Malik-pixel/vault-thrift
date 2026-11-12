<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\Product;
use App\Models\Setting;
use DomainException;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(Product $product, array $data): Order
    {
        if (!$product->isAvailable()) {
            throw new DomainException('Artikel ini sudah habis terjual (1-of-1).');
        }

        return DB::transaction(function () use ($product, $data) {
            $orderNo = Order::generateNextOrderNo();
            $waMessage = $this->formatOrderMessage($product, $orderNo, $data);

            $order = Order::create([
                'order_no' => $orderNo,
                'product_id' => $product->id,
                'buyer_name' => trim($data['buyer_name']),
                'buyer_phone' => trim($data['buyer_phone']),
                'buyer_address' => trim($data['buyer_address']),
                'buyer_city' => isset($data['buyer_city']) ? trim($data['buyer_city']) : null,
                'price_snapshot' => $product->price,
                'payment_method' => $data['payment_method'] ?? 'BCA',
                'status' => Order::STATUS_PENDING,
                'wa_message' => $waMessage,
            ]);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'status' => Order::STATUS_PENDING,
                'note' => 'Pesanan dibuat via form order WhatsApp.',
                'created_at' => now(),
            ]);

            return $order;
        });
    }

    public function confirmPaid(Order $order): int
    {
        return DB::transaction(function () use ($order) {
            /** @var Product $product */
            $product = Product::withTrashed()
                ->where('id', $order->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->isSold()) {
                throw new DomainException("Produk {$product->sku} sudah berstatus HABIS / TERJUAL pada pesanan lain.");
            }

            if ($order->status === Order::STATUS_CANCELLED) {
                throw new DomainException("Pesanan {$order->order_no} sudah berstatus Batal.");
            }

            $product->update([
                'status' => Product::STATUS_SOLD,
                'sold_at' => now(),
                'sold_price' => $order->price_snapshot,
            ]);

            $order->update([
                'status' => Order::STATUS_PAID,
            ]);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'status' => Order::STATUS_PAID,
                'note' => 'Pembayaran dikonfirmasi lunas oleh admin. Stok 1-of-1 dikunci menjadi HABIS.',
                'created_at' => now(),
            ]);

            $competingOrders = Order::where('product_id', $product->id)
                ->where('id', '!=', $order->id)
                ->where('status', Order::STATUS_PENDING)
                ->lockForUpdate()
                ->get();

            foreach ($competingOrders as $competing) {
                $competing->update([
                    'status' => Order::STATUS_CANCELLED,
                ]);

                OrderStatusLog::create([
                    'order_id' => $competing->id,
                    'status' => Order::STATUS_CANCELLED,
                    'note' => 'Batal (item sudah terjual)',
                    'created_at' => now(),
                ]);
            }

            return $competingOrders->count();
        });
    }

    public function updateStatus(Order $order, string $newStatus, ?string $courier = null, ?string $trackingNo = null, ?string $note = null): void
    {
        DB::transaction(function () use ($order, $newStatus, $courier, $trackingNo, $note) {
            $payload = ['status' => $newStatus];
            if ($courier !== null && $courier !== '') {
                $payload['courier'] = $courier;
            }
            if ($trackingNo !== null && $trackingNo !== '') {
                $payload['tracking_no'] = $trackingNo;
            }

            $order->update($payload);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'status' => $newStatus,
                'note' => $note ?: ('Status diubah menjadi ' . (Order::STATUS_LABELS[$newStatus] ?? $newStatus)),
                'created_at' => now(),
            ]);
        });
    }

    public function formatOrderMessage(Product $product, string $orderNo, array $data): string
    {
        $addressLine = trim($data['buyer_address']);
        if (!empty($data['buyer_city'])) {
            $addressLine .= ', ' . trim($data['buyer_city']);
        }

        return implode("\n", [
            'Halo Admin VAULT Curated Thrift!',
            'Saya ingin memesan artikel archive 1-of-1:',
            "• No. Order: {$orderNo}",
            "• Artikel: {$product->name} ({$product->size_label})",
            "• SKU: {$product->sku}",
            "• Harga: {$product->formatted_price}",
            "• Nama: " . trim($data['buyer_name']),
            "• No. WA: " . trim($data['buyer_phone']),
            "• Alamat: {$addressLine}",
            '',
            'Mohon info ketersediaan & nomor rekening transfer. Terima kasih!',
        ]);
    }

    public function formatTrackingMessage(Order $order): string
    {
        $courier = $order->courier ?: 'Kurir Pilihan';
        $resi = $order->tracking_no ?: '-';
        $itemName = $order->product?->name ?? 'Artikel VAULT';
        $sku = $order->product?->sku ?? '-';

        return implode("\n", [
            "Halo Kak {$order->buyer_name}, pesanan VAULT Curated Thrift Anda telah dikirim!",
            "• No. Order: {$order->order_no}",
            "• Artikel: {$itemName} ({$sku})",
            "• Kurir: {$courier}",
            "• No. Resi: {$resi}",
            '',
            'Terima kasih telah mengoleksi arsip bersama VAULT!',
        ]);
    }

    public function getStoreWhatsAppUrl(string $message): string
    {
        $raw = Setting::getValue('whatsapp_number', '6281234567890');
        $phone = preg_replace('/\D+/', '', (string) $raw);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
    }

    public function getBuyerWhatsAppUrl(Order $order, ?string $message = null): string
    {
        $phone = $order->normalized_buyer_phone;
        $url = 'https://wa.me/' . $phone;
        if ($message !== null && $message !== '') {
            $url .= '?text=' . rawurlencode($message);
        }

        return $url;
    }
}

