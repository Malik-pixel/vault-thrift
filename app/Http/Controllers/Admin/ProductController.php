<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $kategori = trim((string) $request->query('kategori', ''));
        $status = trim((string) $request->query('status', 'all'));
        $urut = trim((string) $request->query('urut', 'newest'));
        $drop = trim((string) $request->query('drop', ''));

        $categories = Category::withCount('products')->orderBy('sort_order')->orderBy('id')->get();

        $totalProducts = Product::count();
        $availableProducts = Product::available()->count();
        $soldProducts = Product::sold()->count();
        $inventoryValue = (int) Product::available()->sum('price');

        $query = Product::with(['category', 'images']);

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        if ($kategori !== '' && $kategori !== 'all') {
            $query->whereHas('category', fn ($catQ) => $catQ->where('slug', $kategori));
        }

        if ($status === 'available') {
            $query->available();
        } elseif ($status === 'sold') {
            $query->sold();
        }

        if ($drop !== '') {
            $query->where('drop_batch', $drop);
        }

        match ($urut) {
            'price_desc' => $query->orderBy('price', 'desc'),
            'price_asc' => $query->orderBy('price', 'asc'),
            'grade_desc' => $query->orderBy('condition_grade', 'desc'),
            default => $query->orderByDesc('id'),
        };

        $products = $query->paginate(10)->withQueryString();
        $dropBatches = Product::whereNotNull('drop_batch')
            ->distinct()
            ->orderByDesc('drop_batch')
            ->pluck('drop_batch');

        return view('admin.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'availableProducts',
            'soldProducts',
            'inventoryValue',
            'dropBatches',
            'q',
            'kategori',
            'status',
            'urut',
            'drop'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'price' => preg_replace('/\D+/', '', (string) $request->input('price')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'brand' => ['nullable', 'string', 'max:120'],
            'era' => ['nullable', 'string', 'max:80'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'price' => ['required', 'integer', 'min:1000'],
            'size_label' => ['required', 'string', 'max:40'],
            'condition_grade' => ['required', 'numeric', 'min:1', 'max:10'],
            'condition_tag' => ['nullable', 'string', 'max:60'],
            'material' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'flaws' => ['nullable', 'string', 'max:1000'],
            'sanitation_note' => ['nullable', 'string', 'max:1000'],
            'drop_batch' => ['nullable', 'string', 'max:40'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['nullable', 'in:available,sold'],
            'measurements' => ['nullable', 'array'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_labels' => ['nullable', 'array'],
            'image_labels.*' => ['nullable', 'string', 'max:40'],
        ], [
            'images.required' => 'Minimal 1 foto produk wajib diunggah.',
            'images.*.image' => 'Semua file harus berupa gambar yang valid.',
            'images.*.mimes' => 'Format foto hanya mendukung JPG, JPEG, PNG, atau WEBP.',
            'images.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'price.required' => 'Harga jual wajib diisi.',
            'size_label.required' => 'Ukuran tag wajib diisi.',
            'condition_grade.required' => 'Grade kondisi wajib diisi (1 - 10).',
        ]);

        $measurements = collect($request->input('measurements', []))
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->toArray();

        $status = $request->boolean('is_available', true)
            ? Product::STATUS_AVAILABLE
            : ($validated['status'] ?? Product::STATUS_AVAILABLE);

        if ($request->has('status_toggle_present')) {
            $status = $request->boolean('is_available') ? Product::STATUS_AVAILABLE : Product::STATUS_SOLD;
        }

        $product = DB::transaction(function () use ($validated, $measurements, $status, $request) {
            $product = Product::create([
                'sku' => Product::generateNextSku(),
                'slug' => Product::generateUniqueSlug($validated['name']),
                'name' => $validated['name'],
                'brand' => $validated['brand'] ?? null,
                'era' => $validated['era'] ?? null,
                'category_id' => $validated['category_id'],
                'price' => (int) $validated['price'],
                'size_label' => strtoupper(trim($validated['size_label'])),
                'measurements' => $measurements,
                'condition_grade' => round((float) $validated['condition_grade'], 1),
                'condition_tag' => $validated['condition_tag'] ?? null,
                'material' => $validated['material'] ?? null,
                'description' => $validated['description'] ?? null,
                'flaws' => $validated['flaws'] ?? null,
                'sanitation_note' => $validated['sanitation_note'] ?? 'Telah melalui dry-cleaning & sterilisasi uap ozone suhu tinggi 100°C.',
                'is_featured' => $request->boolean('is_featured'),
                'status' => $status,
                'drop_batch' => $validated['drop_batch'] ?? 'Drop #14',
                'sold_at' => $status === Product::STATUS_SOLD ? now() : null,
                'sold_price' => $status === Product::STATUS_SOLD ? (int) $validated['price'] : null,
            ]);

            $labels = $request->input('image_labels', []);
            $defaultLabels = ['Depan', 'Belakang', 'Tag Label', 'Patina/Detail'];

            foreach ($request->file('images', []) as $index => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'label' => !empty($labels[$index]) ? $labels[$index] : ($defaultLabels[$index] ?? 'Detail'),
                    'sort_order' => $index,
                ]);
            }

            return $product;
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Artikel {$product->sku} ({$product->name}) berhasil ditambahkan ke katalog.");
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->merge([
            'price' => preg_replace('/\D+/', '', (string) $request->input('price')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'brand' => ['nullable', 'string', 'max:120'],
            'era' => ['nullable', 'string', 'max:80'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'price' => ['required', 'integer', 'min:1000'],
            'size_label' => ['required', 'string', 'max:40'],
            'condition_grade' => ['required', 'numeric', 'min:1', 'max:10'],
            'condition_tag' => ['nullable', 'string', 'max:60'],
            'material' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'flaws' => ['nullable', 'string', 'max:1000'],
            'sanitation_note' => ['nullable', 'string', 'max:1000'],
            'drop_batch' => ['nullable', 'string', 'max:40'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:available,sold'],
            'measurements' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
            'images.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'existing_labels' => ['nullable', 'array'],
            'existing_orders' => ['nullable', 'array'],
            'delete_images' => ['nullable', 'array'],
        ]);

        $measurements = collect($request->input('measurements', []))
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->toArray();

        DB::transaction(function () use ($validated, $measurements, $request, $product) {
            $wasSold = $product->isSold();
            $newStatus = $validated['status'];

            $product->update([
                'slug' => Product::generateUniqueSlug($validated['name'], $product->id),
                'name' => $validated['name'],
                'brand' => $validated['brand'] ?? null,
                'era' => $validated['era'] ?? null,
                'category_id' => $validated['category_id'],
                'price' => (int) $validated['price'],
                'size_label' => strtoupper(trim($validated['size_label'])),
                'measurements' => $measurements,
                'condition_grade' => round((float) $validated['condition_grade'], 1),
                'condition_tag' => $validated['condition_tag'] ?? null,
                'material' => $validated['material'] ?? null,
                'description' => $validated['description'] ?? null,
                'flaws' => $validated['flaws'] ?? null,
                'sanitation_note' => $validated['sanitation_note'] ?? $product->sanitation_note,
                'is_featured' => $request->boolean('is_featured'),
                'status' => $newStatus,
                'drop_batch' => $validated['drop_batch'] ?? $product->drop_batch,
                'sold_at' => $newStatus === Product::STATUS_SOLD ? ($wasSold ? $product->sold_at : now()) : null,
                'sold_price' => $newStatus === Product::STATUS_SOLD ? (int) $validated['price'] : null,
            ]);

            // Update existing image labels & order
            $existingLabels = $request->input('existing_labels', []);
            $existingOrders = $request->input('existing_orders', []);
            foreach ($product->images as $img) {
                $img->update([
                    'label' => $existingLabels[$img->id] ?? $img->label,
                    'sort_order' => (int) ($existingOrders[$img->id] ?? $img->sort_order),
                ]);
            }

            // Delete selected images (keep at least 1 if no new uploads)
            $deleteIds = collect($request->input('delete_images', []))->map(fn ($id) => (int) $id);
            $newFiles = $request->file('images', []);
            $remainingCount = $product->images()->whereNotIn('id', $deleteIds)->count() + count($newFiles);

            if ($deleteIds->isNotEmpty() && $remainingCount >= 1) {
                $toDelete = $product->images()->whereIn('id', $deleteIds)->get();
                foreach ($toDelete as $img) {
                    if (!str_starts_with($img->path, 'images/')) {
                        Storage::disk('public')->delete($img->path);
                    }
                    $img->delete();
                }
            }

            // Upload new images
            $nextSort = ((int) $product->images()->max('sort_order')) + 1;
            $newLabels = $request->input('new_image_labels', []);
            foreach ($newFiles as $idx => $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'label' => !empty($newLabels[$idx]) ? $newLabels[$idx] : 'Detail',
                    'sort_order' => $nextSort + $idx,
                ]);
            }
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', "Perubahan pada {$product->sku} berhasil disimpan.");
    }

    public function toggleStatus(Product $product)
    {
        if ($product->isAvailable()) {
            $product->update([
                'status' => Product::STATUS_SOLD,
                'sold_at' => now(),
                'sold_price' => $product->price,
            ]);
            $msg = "{$product->sku} ditandai HABIS TERJUAL.";
        } else {
            $product->update([
                'status' => Product::STATUS_AVAILABLE,
                'sold_at' => null,
                'sold_price' => null,
            ]);
            $msg = "{$product->sku} dikembalikan ke status TERSEDIA.";
        }

        return back()->with('success', $msg);
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:mark_sold,mark_available,change_category,delete'],
            'product_ids' => ['required', 'array', 'min:1'],
            'product_ids.*' => ['integer', 'exists:products,id'],
            'target_category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ]);

        $products = Product::whereIn('id', $validated['product_ids'])->get();
        $count = $products->count();

        DB::transaction(function () use ($validated, $products) {
            foreach ($products as $product) {
                match ($validated['action']) {
                    'mark_sold' => $product->update([
                        'status' => Product::STATUS_SOLD,
                        'sold_at' => $product->sold_at ?? now(),
                        'sold_price' => $product->sold_price ?? $product->price,
                    ]),
                    'mark_available' => $product->update([
                        'status' => Product::STATUS_AVAILABLE,
                        'sold_at' => null,
                        'sold_price' => null,
                    ]),
                    'change_category' => $validated['target_category_id']
                        ? $product->update(['category_id' => $validated['target_category_id']])
                        : null,
                    'delete' => $this->performDelete($product),
                };
            }
        });

        return back()->with('success', "Aksi massal berhasil diterapkan pada {$count} produk.");
    }

    public function destroy(Product $product)
    {
        $sku = $product->sku;
        $softDeleted = $this->performDelete($product);

        $msg = $softDeleted
            ? "Produk {$sku} diarsipkan (soft delete) karena memiliki riwayat pesanan."
            : "Produk {$sku} berhasil dihapus permanen.";

        return back()->with('success', $msg);
    }

    private function performDelete(Product $product): bool
    {
        if ($product->orders()->exists()) {
            $product->delete();
            return true;
        }

        foreach ($product->images as $img) {
            if (!str_starts_with($img->path, 'images/')) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $product->forceDelete();
        return false;
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'vault-produk-' . date('Ymd-His') . '.csv';
        $products = Product::with('category')->orderBy('sku')->get();

        return response()->streamDownload(function () use ($products) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['SKU', 'Nama Artikel', 'Brand', 'Era', 'Kategori', 'Harga (IDR)', 'Ukuran', 'Grade', 'Status', 'Drop Batch', 'Tanggal Input']);

            foreach ($products as $p) {
                fputcsv($handle, [
                    $p->sku,
                    $p->name,
                    $p->brand ?? '-',
                    $p->era ?? '-',
                    $p->category?->name ?? '-',
                    $p->price,
                    $p->size_label,
                    number_format($p->condition_grade, 1),
                    $p->status === Product::STATUS_AVAILABLE ? 'Tersedia' : 'Habis Terjual',
                    $p->drop_batch ?? '-',
                    $p->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

