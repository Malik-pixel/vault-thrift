<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount([
            'products as available_count' => fn ($q) => $q->where('status', Product::STATUS_AVAILABLE),
        ])->orderBy('sort_order')->orderBy('id')->get();

        $featuredProducts = Product::with(['category', 'images'])
            ->where('is_featured', true)
            ->orderByRaw("CASE WHEN status = 'available' THEN 0 ELSE 1 END")
            ->latest('id')
            ->take(6)
            ->get();

        if ($featuredProducts->count() < 6) {
            $existingIds = $featuredProducts->pluck('id')->all();
            $extra = Product::with(['category', 'images'])
                ->whereNotIn('id', $existingIds)
                ->latest('id')
                ->take(6 - $featuredProducts->count())
                ->get();
            $featuredProducts = $featuredProducts->concat($extra);
        }

        $highlightProduct = $featuredProducts->firstWhere('status', Product::STATUS_AVAILABLE)
            ?? Product::with(['category', 'images'])->available()->latest('id')->first();

        $totalAvailable = Product::available()->count();
        $totalCatalog = Product::count();

        return view('pages.home', compact(
            'categories',
            'featuredProducts',
            'highlightProduct',
            'totalAvailable',
            'totalCatalog'
        ));
    }

    public function about()
    {
        $totalCatalog = Product::count();
        $averageGrade = number_format((float) (Product::avg('condition_grade') ?? 9.4), 1);

        return view('pages.about', compact('totalCatalog', 'averageGrade'));
    }

    public function saved(Request $request)
    {
        return view('pages.saved');
    }

    public function savedLookup(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids', '')))
            ->map(fn ($id) => (int) trim($id))
            ->filter(fn ($id) => $id > 0)
            ->unique()
            ->take(48)
            ->values();

        if ($ids->isEmpty()) {
            return response()->json(['products' => []]);
        }

        $products = Product::with(['category', 'images'])
            ->whereIn('id', $ids)
            ->get()
            ->map(fn (Product $p) => [
                'id' => $p->id,
                'sku' => $p->sku,
                'slug' => $p->slug,
                'name' => $p->name,
                'brand' => $p->brand,
                'category' => $p->category?->name ?? '-',
                'price' => $p->price,
                'formatted_price' => $p->formatted_price,
                'size_label' => $p->size_label,
                'condition_grade' => number_format($p->condition_grade, 1),
                'status' => $p->status,
                'image' => $p->primary_image_url,
                'url' => route('product.show', $p->slug),
            ]);

        return response()->json(['products' => $products]);
    }
}

