<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart';

    public function items(): Collection
    {
        return collect(session(self::SESSION_KEY, []));
    }

    public function add(int $productId, int $qty = 1): void
    {
        $cart = session(self::SESSION_KEY, []);
        $product = Product::find($productId);

        if (! $product || ! $product->is_active) {
            return;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'name' => $product->name,
                'price' => (float) $product->price,
                'qty' => $qty,
                'image' => $product->getFirstMediaUrl('images'),
            ];
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function remove(int $productId): void
    {
        $cart = session(self::SESSION_KEY, []);
        unset($cart[$productId]);
        session([self::SESSION_KEY => $cart]);
    }

    public function updateQty(int $productId, int $qty): void
    {
        $cart = session(self::SESSION_KEY, []);

        if ($qty < 1) {
            $this->remove($productId);
            return;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $qty;
            session([self::SESSION_KEY => $cart]);
        }
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function subtotal(): float
    {
        return $this->items()->sum(fn ($item) => $item['price'] * $item['qty']);
    }

    public function count(): int
    {
        return $this->items()->sum('qty');
    }

    public function isEmpty(): bool
    {
        return $this->items()->isEmpty();
    }
}
