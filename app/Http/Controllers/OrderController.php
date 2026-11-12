<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, OrderService $orderService)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'buyer_name' => ['required', 'string', 'max:120'],
            'buyer_phone' => ['required', 'string', 'min:8', 'max:30'],
            'buyer_address' => ['required', 'string', 'max:500'],
            'buyer_city' => ['nullable', 'string', 'max:120'],
            'payment_method' => ['nullable', 'string', 'in:BCA,Mandiri,BNI,QRIS'],
        ], [
            'buyer_name.required' => 'Nama lengkap wajib diisi.',
            'buyer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'buyer_phone.min' => 'Nomor WhatsApp minimal 8 digit.',
            'buyer_address.required' => 'Alamat pengiriman wajib diisi.',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        try {
            $order = $orderService->createOrder($product, $validated);
        } catch (DomainException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['product_id' => $e->getMessage()])->withInput();
        }

        $waUrl = $orderService->getStoreWhatsAppUrl($order->wa_message);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'order_no' => $order->order_no,
                'wa_url' => $waUrl,
                'wa_message' => $order->wa_message,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
            ], 201);
        }

        return redirect()->away($waUrl);
    }
}

