<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::with(['category', 'images'])
            ->available()
            ->where('category_id', '!=', $product->category_id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        if ($relatedProducts->count() < 4) {
            $excludeIds = $relatedProducts->pluck('id')->push($product->id)->all();
            $fallback = Product::with(['category', 'images'])
                ->available()
                ->whereNotIn('id', $excludeIds)
                ->latest('id')
                ->take(4 - $relatedProducts->count())
                ->get();
            $relatedProducts = $relatedProducts->concat($fallback);
        }

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }
}

