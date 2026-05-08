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

    /**
     * Add a product (optionally with a specific variant) to the cart.
     * Cart key format: "{productId}" or "{productId}:{variantId}"
     */
    public function add(int $productId, int $qty = 1, int $variantId = 0): void
    {
        $cart    = session(self::SESSION_KEY, []);
        $product = Product::find($productId);

        if (! $product || ! $product->is_active) {
            return;
        }

        $price       = (float) $product->price;
        $variantName = null;
        $cartKey     = (string) $productId;

        if ($variantId) {
            $variant = $product->variants()->where('id', $variantId)->where('is_active', true)->first();
            if (! $variant) {
                return;
            }
            $price       = (float) $variant->price;
            $variantName = $variant->name;
            $cartKey     = "{$productId}:{$variantId}";
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] += $qty;
        } else {
            $cart[$cartKey] = [
                'cart_key'    => $cartKey,
                'id'          => $productId,
                'variant_id'  => $variantId ?: null,
                'variant_name'=> $variantName,
                'name'        => $product->name,
                'price'       => $price,
                'qty'         => $qty,
                'image'       => $product->getFirstMediaUrl('images'),
            ];
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function remove(string $cartKey): void
    {
        $cart = session(self::SESSION_KEY, []);
        unset($cart[$cartKey]);
        session([self::SESSION_KEY => $cart]);
    }

    public function updateQty(string $cartKey, int $qty): void
    {
        $cart = session(self::SESSION_KEY, []);

        if ($qty < 1) {
            $this->remove($cartKey);
            return;
        }

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['qty'] = $qty;
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
