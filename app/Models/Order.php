<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'menunggu_konfirmasi';
    public const STATUS_PAID = 'lunas';
    public const STATUS_SHIPPING = 'dalam_pengiriman';
    public const STATUS_DONE = 'selesai';
    public const STATUS_CANCELLED = 'batal';

    public const STATUS_LABELS = [
        self::STATUS_PENDING => 'Menunggu Konfirmasi',
        self::STATUS_PAID => 'Lunas / Siap Kirim',
        self::STATUS_SHIPPING => 'Dalam Pengiriman',
        self::STATUS_DONE => 'Selesai',
        self::STATUS_CANCELLED => 'Batal',
    ];

    protected $fillable = [
        'order_no',
        'product_id',
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'buyer_city',
        'price_snapshot',
        'payment_method',
        'status',
        'courier',
        'tracking_no',
        'wa_message',
    ];

    protected $casts = [
        'price_snapshot' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class)->orderByDesc('created_at')->orderByDesc('id');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getFormattedPriceAttribute(): string
    {
        return Product::formatRupiah($this->price_snapshot);
    }

    public function getNormalizedBuyerPhoneAttribute(): string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->buyer_phone);
        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }
        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }

    public static function generateNextOrderNo(): string
    {
        $year = date('Y');
        $prefix = "ORD-{$year}-";
        $maxSeq = 0;

        $existing = self::where('order_no', 'like', $prefix . '%')->pluck('order_no');
        foreach ($existing as $no) {
            if (preg_match('/ORD-\d{4}-(\d+)/', (string) $no, $matches)) {
                $seq = (int) $matches[1];
                if ($seq > $maxSeq) {
                    $maxSeq = $seq;
                }
            }
        }

        return sprintf('%s%04d', $prefix, $maxSeq + 1);
    }
}

