<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    protected $fillable = ['name', 'delivery_fee', 'is_active', 'order_column'];

    protected function casts(): array
    {
        return [
            'delivery_fee' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public static function activeOrdered()
    {
        return static::where('is_active', true)->orderBy('order_column')->orderBy('name');
    }
}
