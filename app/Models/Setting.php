<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        static $cache = null;
        if ($cache === null) {
            try {
                $cache = self::query()->pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return $default;
            }
        }

        return $cache[$key] ?? $default;
    }

    public static function setValue(string $key, ?string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function allMap(): array
    {
        return self::query()->pluck('value', 'key')->toArray();
    }
}

