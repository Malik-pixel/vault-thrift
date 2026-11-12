<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer(['layouts.app', 'layouts.admin', 'pages.*', 'admin.*', 'errors.*'], function ($view) {
            static $shared = null;

            if ($shared === null) {
                $settings = [];
                $navCategories = collect();

                try {
                    if (Schema::hasTable('settings')) {
                        $settings = Setting::allMap();
                    }
                    if (Schema::hasTable('categories')) {
                        $navCategories = Category::orderBy('sort_order')->orderBy('id')->get();
                    }
                } catch (\Throwable $e) {
                    // Ignore during early bootstrap/artisan
                }

                $waRaw = preg_replace('/\D+/', '', (string) ($settings['whatsapp_number'] ?? '6281234567890'));
                if (str_starts_with($waRaw, '0')) {
                    $waRaw = '62' . substr($waRaw, 1);
                }

                $shared = [
                    'storeSettings' => array_merge([
                        'ticker_text' => 'DROP BARU SETIAP JUMAT 19.00 WIB • 100% AUTHENTIC & SANITIZED • PENGIRIMAN KE SELURUH INDONESIA • ORDER CEPAT VIA WHATSAPP',
                        'whatsapp_number' => '6281234567890',
                        'whatsapp_clean' => $waRaw,
                        'studio_address' => 'Jl. Kemang Timur No. 42, Mampang Prapatan, Jakarta Selatan 12730',
                        'operating_hours' => 'Senin - Minggu: 10:00 - 22:00 WIB',
                        'drop_schedule' => 'Jumat 19:00 WIB',
                        'bank_accounts' => "BCA 801-0982-119 a/n VAULT ARCHIVE INDONESIA\nMandiri 126-0091-8821 a/n VAULT ARCHIVE\nBNI 0892-1120-44 a/n VAULT ARCHIVE\nQRIS All-Pay Official Store",
                        'instagram_handle' => '@vault.thrift',
                        'total_archived_stat' => '1,200+',
                    ], $settings, ['whatsapp_clean' => $waRaw]),
                    'navCategories' => $navCategories,
                ];
            }

            $view->with($shared);
        });

        View::composer('layouts.admin', function ($view) {
            static $adminCounts = null;

            if ($adminCounts === null) {
                $adminCounts = [
                    'products_total' => 0,
                    'pending_orders' => 0,
                    'categories_total' => 0,
                ];
                try {
                    if (Schema::hasTable('products')) {
                        $adminCounts['products_total'] = Product::count();
                    }
                    if (Schema::hasTable('orders')) {
                        $adminCounts['pending_orders'] = Order::where('status', Order::STATUS_PENDING)->count();
                    }
                    if (Schema::hasTable('categories')) {
                        $adminCounts['categories_total'] = Category::count();
                    }
                } catch (\Throwable $e) {
                    // Ignore
                }
            }

            $view->with('adminCounts', $adminCounts);
        });
    }
}
