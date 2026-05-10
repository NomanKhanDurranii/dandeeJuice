<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'whatsapp',
        'google_maps_url', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public static function activeOrdered()
    {
        return static::where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function mapsUrl(): string
    {
        return $this->google_maps_url ?: 'https://maps.google.com/?q=' . urlencode($this->address);
    }

    public function waUrl(?string $message = null): string
    {
        $raw = $this->whatsapp ?: $this->phone;
        $number = preg_replace('/\D/', '', $raw ?? '');
        $url = "https://wa.me/{$number}";

        return $message ? $url . '?text=' . urlencode($message) : $url;
    }
}
