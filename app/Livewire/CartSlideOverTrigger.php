<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartSlideOverTrigger extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->count = app(CartService::class)->count();
    }

    #[On('cart-updated')]
    #[On('add-to-cart')]
    public function refresh(): void
    {
        $this->count = app(CartService::class)->count();
    }

    public function openCart(): void
    {
        $this->dispatch('open-cart');
    }

    public function render()
    {
        return view('livewire.cart-slide-over-trigger');
    }
}
