<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount([
            'products',
            'products as available_count' => fn ($q) => $q->where('status', 'available'),
        ])->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['nullable', 'string', 'max:80', 'unique:categories,slug'],
            'description' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . (Category::count() + 1);
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? (Category::max('sort_order') + 1)),
            'image_path' => 'images/demo/placeholder-archive.svg',
        ]);

        return back()->with('success', "Kategori {$validated['name']} berhasil ditambahkan.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'slug' => ['required', 'string', 'max:80', 'unique:categories,slug,' . $category->id],
            'description' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? $category->sort_order),
        ]);

        return back()->with('success', "Kategori {$category->name} berhasil diperbarui.");
    }

    public function destroy(Category $category)
    {
        if ($category->products()->withTrashed()->exists()) {
            return back()->with('error', "Kategori {$category->name} tidak dapat dihapus karena masih memiliki produk.");
        }

        $category->delete();
        return back()->with('success', "Kategori {$category->name} berhasil dihapus.");
    }
}

