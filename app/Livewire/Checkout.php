<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public array $items = [];
    public float $subtotal = 0;
    public float $deliveryFee = 0;
    public string $orderType = '';
    public string $deliveryZoneName = '';
    public ?int $deliveryZoneId = null;

    public string $phone = '';
    public string $paymentMethod = 'cod';
    public string $notes = '';

    public bool $easypaisaEnabled = false;
    public bool $jazzcashEnabled = false;

    public bool $placing = false;

    public function mount(): void
    {
        $cart = app(CartService::class);

        if ($cart->isEmpty()) {
            $this->redirect(route('home'), navigate: false);
            return;
        }

        if (! session()->has('order_type')) {
            $this->redirect(route('home'), navigate: false);
            return;
        }

        $this->items = $cart->items()->all();
        $this->subtotal = $cart->subtotal();
        $this->orderType = session('order_type', 'pickup');
        $this->deliveryZoneName = session('delivery_zone_name') ?? '';
        $this->deliveryZoneId = session('delivery_zone_id') ? (int) session('delivery_zone_id') : null;
        $this->deliveryFee = (float) (session('delivery_fee') ?? 0);

        $this->easypaisaEnabled = Setting::get('easypaisa_enabled', '0') === '1';
        $this->jazzcashEnabled = Setting::get('jazzcash_enabled', '0') === '1';
    }

    public function total(): float
    {
        return $this->subtotal + $this->deliveryFee;
    }

    public function placeOrder(): void
    {
        $this->validate([
            'phone'         => 'required|regex:/^[0-9+\-\s]{7,20}$/',
            'paymentMethod' => 'required|in:cod,easypaisa,jazzcash',
            'notes'         => 'nullable|string|max:500',
        ]);

        if ($this->paymentMethod === 'easypaisa' && ! $this->easypaisaEnabled) {
            $this->addError('paymentMethod', 'EasyPaisa is not available yet.');
            return;
        }

        if ($this->paymentMethod === 'jazzcash' && ! $this->jazzcashEnabled) {
            $this->addError('paymentMethod', 'JazzCash is not available yet.');
            return;
        }

        $this->placing = true;

        $order = DB::transaction(function () {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'phone'            => $this->phone,
                'type'             => $this->orderType,
                'status'           => 'pending',
                'payment_method'   => $this->paymentMethod,
                'subtotal'         => $this->subtotal,
                'delivery_fee'     => $this->deliveryFee,
                'total'            => $this->total(),
                'delivery_address' => $this->deliveryZoneName ?: null,
                'notes'            => $this->notes ?: null,
            ]);

            foreach ($this->items as $productId => $item) {
                $order->items()->create([
                    'product_id'    => $productId,
                    'product_name'  => $item['name'],
                    'product_price' => $item['price'],
                    'quantity'      => $item['qty'],
                    'subtotal'      => round($item['price'] * $item['qty'], 2),
                ]);
            }

            return $order;
        });

        app(CartService::class)->clear();

        $this->redirect(route('order.confirmation', $order->id), navigate: false);
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
