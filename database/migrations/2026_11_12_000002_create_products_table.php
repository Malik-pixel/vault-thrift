<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('era')->nullable();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->unsignedBigInteger('price');
            $table->string('size_label');
            $table->json('measurements')->nullable();
            $table->decimal('condition_grade', 3, 1)->default(9.0);
            $table->string('condition_tag')->nullable();
            $table->text('material')->nullable();
            $table->text('description')->nullable();
            $table->text('flaws')->nullable();
            $table->text('sanitation_note')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->string('drop_batch')->nullable();
            $table->timestamp('sold_at')->nullable();
            $table->unsignedBigInteger('sold_price')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'category_id']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

