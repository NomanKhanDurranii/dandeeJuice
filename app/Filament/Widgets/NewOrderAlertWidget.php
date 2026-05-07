<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;

class NewOrderAlertWidget extends Widget
{
    protected string $view = 'filament.widgets.new-order-alert';

    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    // Timestamp of the most recent order when the widget last polled
    public ?string $lastOrderAt = null;

    public int $newOrderCount = 0;

    public function mount(): void
    {
        $latest = Order::latest()->first();
        $this->lastOrderAt = $latest?->created_at?->toDateTimeString();
        $this->newOrderCount = 0;
    }

    // Livewire polls every 30 seconds via wire:poll
    public function checkForNewOrders(): void
    {
        $query = Order::where('status', 'pending');

        if ($this->lastOrderAt) {
            $query->where('created_at', '>', $this->lastOrderAt);
        }

        $newOrders = $query->count();

        if ($newOrders > 0) {
            $this->newOrderCount = $newOrders;
            $latest = Order::latest()->first();
            $this->lastOrderAt = $latest?->created_at?->toDateTimeString();
            $this->dispatch('new-orders-detected', count: $newOrders);
        } else {
            $this->newOrderCount = 0;
        }
    }

    public function dismiss(): void
    {
        $this->newOrderCount = 0;
    }
}
