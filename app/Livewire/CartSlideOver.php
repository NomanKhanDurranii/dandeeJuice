<?php

namespace App\Livewire;

use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartSlideOver extends Component
{
    public bool $open = false;

    public array $items = [];

    public float $subtotal = 0;

    public string $orderType = '';

    public string $deliveryZoneName = '';

    public float $deliveryFee = 0;

    public function mount(): void
    {
        $this->syncCart();
    }

    #[On('add-to-cart')]
    public function addToCart(int $id, int $qty = 1): void
    {
        app(CartService::class)->add($id, $qty);
        $this->syncCart();
        $this->open = true;
    }

    #[On('cart-updated')]
    public function onCartUpdated(): void
    {
        $this->syncCart();
    }

    #[On('open-cart')]
    public function openPanel(): void
    {
        $this->open = true;
        $this->syncCart();
    }

    public function removeItem(int $productId): void
    {
        app(CartService::class)->remove($productId);
        $this->syncCart();
    }

    public function increment(int $productId): void
    {
        $cart = app(CartService::class);
        /** @var array{qty: int}|null $item */
        $item = $cart->items()->get($productId);
        if (is_array($item)) {
            $cart->updateQty($productId, $item['qty'] + 1);
        }
        $this->syncCart();
    }

    public function decrement(int $productId): void
    {
        $cart = app(CartService::class);
        /** @var array{qty: int}|null $item */
        $item = $cart->items()->get($productId);
        if (is_array($item)) {
            $cart->updateQty($productId, $item['qty'] - 1);
        }
        $this->syncCart();
    }

    public function clearCart(): void
    {
        app(CartService::class)->clear();
        $this->syncCart();
    }

    public function checkout(): void
    {
        if (! Auth::check()) {
            $this->redirect(route('login'), navigate: false);
            return;
        }

        $this->redirect(route('checkout'), navigate: false);
    }

    private function syncCart(): void
    {
        $cart = app(CartService::class);
        $this->items = $cart->items()->all();
        $this->subtotal = $cart->subtotal();
        $this->orderType = session('order_type') ?? '';
        $this->deliveryZoneName = session('delivery_zone_name') ?? '';
        $this->deliveryFee = (float) (session('delivery_fee') ?? 0);
    }

    public function total(): float
    {
        return $this->subtotal + $this->deliveryFee;
    }

    public function render()
    {
        return view('livewire.cart-slide-over');
    }
}
