<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_SOLD = 'sold';

    protected $fillable = [
        'sku',
        'slug',
        'name',
        'brand',
        'era',
        'category_id',
        'price',
        'size_label',
        'measurements',
        'condition_grade',
        'condition_tag',
        'material',
        'description',
        'flaws',
        'sanitation_note',
        'is_featured',
        'status',
        'drop_batch',
        'sold_at',
        'sold_price',
    ];

    protected $casts = [
        'measurements' => 'array',
        'condition_grade' => 'float',
        'is_featured' => 'boolean',
        'sold_at' => 'datetime',
        'price' => 'integer',
        'sold_price' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeSold(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SOLD);
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isSold(): bool
    {
        return $this->status === self::STATUS_SOLD;
    }

    public function getFormattedPriceAttribute(): string
    {
        return self::formatRupiah($this->price);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $first = $this->images->first();
        if ($first) {
            return $first->url;
        }

        return asset('images/demo/placeholder-archive.svg');
    }

    public function getShortMeasurementSummaryAttribute(): string
    {
        $m = $this->measurements ?? [];
        $parts = [];
        if (!empty($m['panjang'])) {
            $parts[] = 'P: ' . $m['panjang'] . ' cm';
        }
        if (!empty($m['lebar_dada'])) {
            $parts[] = 'L: ' . $m['lebar_dada'] . ' cm';
        } elseif (!empty($m['pinggang'])) {
            $parts[] = 'LP: ' . $m['pinggang'] . ' cm';
        } elseif (!empty($m['insole'])) {
            $parts[] = 'Insole: ' . $m['insole'] . ' cm';
        }

        return implode(' • ', $parts);
    }

    public static function formatRupiah(int|float $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }

    public static function generateNextSku(): string
    {
        $maxNum = 0;
        $skus = self::withTrashed()->pluck('sku');
        foreach ($skus as $sku) {
            if (preg_match('/VLT-(\d+)/', (string) $sku, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }

        return sprintf('VLT-%04d', $maxNum + 1);
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'archive-piece';
        $slug = $base;
        $counter = 2;

        while (
            self::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

