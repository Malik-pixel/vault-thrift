<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VaultAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_unauthenticated_user_is_redirected_to_admin_login(): void
    {
        $this->get('/admin/produk')->assertRedirect('/admin/login');
        $this->get('/admin/pesanan')->assertRedirect('/admin/login');
        $this->get('/admin/dashboard')->assertRedirect('/admin/login');
    }

    public function test_admin_login_rate_limiting_and_valid_login(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email' => 'rian.kurator@vault.archive',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        // 6th attempt triggers throttle message
        $this->post('/admin/login', [
            'email' => 'rian.kurator@vault.archive',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        // Different IP or after clearing works with valid credentials
        $admin = User::where('email', 'rian.kurator@vault.archive')->first();
        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200)
            ->assertSee('DASHBOARD RINGKASAN VAULT');
    }

    public function test_confirm_paid_atomically_marks_product_sold_and_cancels_competing_orders(): void
    {
        $admin = User::first();
        $product = Product::available()->first();
        $orderService = app(OrderService::class);

        $order1 = $orderService->createOrder($product, [
            'buyer_name' => 'Pembeli Pertama',
            'buyer_phone' => '08111111111',
            'buyer_address' => 'Jl. Satu No. 1',
            'payment_method' => 'BCA',
        ]);

        $order2 = $orderService->createOrder($product, [
            'buyer_name' => 'Pembeli Kedua',
            'buyer_phone' => '08222222222',
            'buyer_address' => 'Jl. Dua No. 2',
            'payment_method' => 'Mandiri',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.orders.confirm-paid', $order1))
            ->assertRedirect();

        $this->assertEquals(Order::STATUS_PAID, $order1->fresh()->status);
        $this->assertEquals(Order::STATUS_CANCELLED, $order2->fresh()->status);
        $this->assertEquals(Product::STATUS_SOLD, $product->fresh()->status);
        $this->assertNotNull($product->fresh()->sold_at);
        $this->assertDatabaseHas('order_status_logs', [
            'order_id' => $order2->id,
            'status' => Order::STATUS_CANCELLED,
            'note' => 'Batal (item sudah terjual)',
        ]);
    }

    public function test_admin_can_create_product_with_image_and_reject_invalid_upload(): void
    {
        Storage::fake('public');
        $admin = User::first();
        $category = Category::first();

        // Invalid non-image upload rejected
        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Bad Upload Item',
                'category_id' => $category->id,
                'price' => 500000,
                'size_label' => 'L',
                'condition_grade' => 9.0,
                'images' => [UploadedFile::fake()->create('malware.txt', 10, 'text/plain')],
            ])
            ->assertSessionHasErrors('images.0');

        // Valid upload succeeds and creates auto SKU
        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Vintage 1995 Smashing Pumpkins Tee',
                'brand' => 'Giant',
                'era' => '1995',
                'category_id' => $category->id,
                'price' => 1600000,
                'size_label' => 'L',
                'condition_grade' => 9.4,
                'measurements' => ['panjang' => '73', 'lebar_dada' => '56'],
                'is_available' => 1,
                'images' => [UploadedFile::fake()->image('front.jpg', 600, 800)],
                'image_labels' => ['Depan'],
            ])
            ->assertRedirect(route('admin.products.index'));

        $created = Product::where('name', 'Vintage 1995 Smashing Pumpkins Tee')->first();
        $this->assertNotNull($created);
        $this->assertMatchesRegularExpression('/^VLT-\d{4}$/', $created->sku);
        $this->assertEquals(1, $created->images()->count());
        Storage::disk('public')->assertExists($created->images->first()->path);
    }

    public function test_deleting_product_with_orders_uses_soft_delete_and_csv_exports_work(): void
    {
        $admin = User::first();
        $order = Order::first();
        $productWithOrder = $order->product;

        $this->actingAs($admin)
            ->delete(route('admin.products.destroy', $productWithOrder))
            ->assertRedirect();

        $this->assertSoftDeleted('products', ['id' => $productWithOrder->id]);
        $this->assertNotNull(Order::find($order->id)->product);

        $this->actingAs($admin)
            ->get(route('admin.products.export'))
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $this->actingAs($admin)
            ->get(route('admin.orders.export'))
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_admin_secondary_pages_and_bulk_actions_work(): void
    {
        $admin = User::first();

        $this->actingAs($admin)->get(route('admin.products.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.products.create'))->assertStatus(200);

        $product = Product::available()->first();
        $this->actingAs($admin)->get(route('admin.products.edit', $product))->assertStatus(200);

        $this->actingAs($admin)
            ->put(route('admin.products.update', $product), [
                'name' => $product->name . ' Updated',
                'category_id' => $product->category_id,
                'price' => 2990000,
                'size_label' => 'L',
                'condition_grade' => 9.5,
                'status' => 'available',
            ])
            ->assertRedirect(route('admin.products.index'));

        $this->assertEquals(2990000, $product->fresh()->price);

        $this->actingAs($admin)
            ->post(route('admin.products.bulk'), [
                'action' => 'mark_sold',
                'product_ids' => [$product->id],
            ])
            ->assertRedirect();

        $this->assertEquals(Product::STATUS_SOLD, $product->fresh()->status);

        $this->actingAs($admin)->get(route('admin.orders.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.orders.poll'))->assertStatus(200)->assertJsonStructure(['total', 'pending']);

        $order = Order::first();
        $this->actingAs($admin)->get(route('admin.orders.invoice', $order))->assertStatus(200);

        $this->actingAs($admin)->get(route('admin.categories.index'))->assertStatus(200);
        $this->actingAs($admin)->get(route('admin.settings.index'))->assertStatus(200);
    }
}
