<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'label',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        if (Str::startsWith($this->path, ['http://', 'https://', '/'])) {
            return $this->path;
        }

        if (Str::startsWith($this->path, 'images/')) {
            return asset($this->path);
        }

        return asset('storage/' . ltrim($this->path, '/'));
    }
}

