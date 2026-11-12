<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->string('buyer_name');
            $table->string('buyer_phone');
            $table->text('buyer_address');
            $table->string('buyer_city')->nullable();
            $table->unsignedBigInteger('price_snapshot');
            $table->string('payment_method')->default('BCA');
            $table->string('status')->default('menunggu_konfirmasi');
            $table->string('courier')->nullable();
            $table->string('tracking_no')->nullable();
            $table->text('wa_message');
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

