<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VaultStorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_render_successfully(): void
    {
        $this->get('/')->assertStatus(200)->assertSee('CURATED THRIFT');
        $this->get('/katalog')->assertStatus(200)->assertSee('KATALOG PRODUK LENGKAP');
        $this->get('/tentang-kami')->assertStatus(200)->assertSee('PROTOKOL KURASI');
        $this->get('/tersimpan')->assertStatus(200)->assertSee('ITEM TERSIMPAN');

        $product = Product::first();
        $this->get('/produk/' . $product->slug)
            ->assertStatus(200)
            ->assertSee($product->name);

        $this->get('/produk/non-existent-archive-slug')->assertStatus(404);
    }

    public function test_catalog_filtering_by_category_status_and_price_ascending(): void
    {
        $response = $this->get('/katalog?kategori=sepatu&status=available&urut=price_asc');
        $response->assertStatus(200);

        $products = $response->viewData('products');
        $this->assertGreaterThan(0, $products->count());

        $sepatuCat = Category::where('slug', 'sepatu')->first();
        $prices = [];
        foreach ($products as $p) {
            $this->assertEquals($sepatuCat->id, $p->category_id);
            $this->assertEquals(Product::STATUS_AVAILABLE, $p->status);
            $prices[] = $p->price;
        }

        $sorted = $prices;
        sort($sorted);
        $this->assertSame($sorted, $prices);
    }

    public function test_buyer_can_create_whatsapp_order_without_locking_stock(): void
    {
        $product = Product::available()->first();

        $res1 = $this->postJson('/order', [
            'product_id' => $product->id,
            'buyer_name' => 'Budi Santoso',
            'buyer_phone' => '081234567891',
            'buyer_address' => 'Jl. Sudirman No. 10',
            'buyer_city' => 'Jakarta Pusat',
            'payment_method' => 'BCA',
        ]);

        $res1->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('product_sku', $product->sku);

        $order = Order::where('buyer_name', 'Budi Santoso')->first();
        $this->assertNotNull($order);
        $this->assertEquals(Order::STATUS_PENDING, $order->status);
        $this->assertStringContainsString($product->sku, $order->wa_message);
        $this->assertStringContainsString('Budi Santoso', $order->wa_message);

        // Second buyer can also inquire on the same 1-of-1 product before payment is confirmed
        $res2 = $this->postJson('/order', [
            'product_id' => $product->id,
            'buyer_name' => 'Andi Wijaya',
            'buyer_phone' => '081987654321',
            'buyer_address' => 'Jl. Braga No. 5',
            'buyer_city' => 'Bandung',
            'payment_method' => 'QRIS',
        ]);

        $res2->assertStatus(201);
        $this->assertEquals(Product::STATUS_AVAILABLE, $product->fresh()->status);
    }

    public function test_sold_out_product_cannot_be_ordered(): void
    {
        $soldProduct = Product::sold()->first();

        $res = $this->postJson('/order', [
            'product_id' => $soldProduct->id,
            'buyer_name' => 'Test Buyer',
            'buyer_phone' => '081234567890',
            'buyer_address' => 'Jl. Test 123',
        ]);

        $res->assertStatus(422);
    }
}

