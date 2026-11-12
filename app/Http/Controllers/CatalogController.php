<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $kategori = trim((string) $request->query('kategori', ''));
        $ukuran = strtoupper(trim((string) $request->query('ukuran', '')));
        $status = trim((string) $request->query('status', 'all'));
        $harga = trim((string) $request->query('harga', 'all'));
        $urut = trim((string) $request->query('urut', 'newest'));

        $categories = Category::withCount('products')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $totalAllProducts = Product::count();

        $query = Product::with(['category', 'images']);

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('era', 'like', "%{$q}%")
                    ->orWhere('condition_tag', 'like', "%{$q}%");
            });
        }

        if ($kategori !== '' && $kategori !== 'all') {
            $query->whereHas('category', fn ($catQ) => $catQ->where('slug', $kategori));
        }

        if ($ukuran !== '' && $ukuran !== 'ALL') {
            if ($ukuran === '28-36') {
                $query->whereIn('size_label', ['28', '29', '30', '31', '32', '33', '34', '35', '36']);
            } elseif ($ukuran === '40-44') {
                $query->whereIn('size_label', ['39', '40', '40.5', '41', '42', '42.5', '43', '44', '45']);
            } else {
                $query->where('size_label', $ukuran);
            }
        }

        if ($status === 'available') {
            $query->where('status', Product::STATUS_AVAILABLE);
        } elseif ($status === 'sold') {
            $query->where('status', Product::STATUS_SOLD);
        }

        if ($harga === 'under-500') {
            $query->where('price', '<', 500000);
        } elseif ($harga === '500-1500') {
            $query->whereBetween('price', [500000, 1500000]);
        } elseif ($harga === 'over-1500') {
            $query->where('price', '>', 1500000);
        }

        match ($urut) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'grade_desc' => $query->orderBy('condition_grade', 'desc')->orderByDesc('id'),
            default => $query->orderByDesc('id'),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('pages.catalog', compact(
            'products',
            'categories',
            'totalAllProducts',
            'q',
            'kategori',
            'ukuran',
            'status',
            'harga',
            'urut'
        ));
    }
}

