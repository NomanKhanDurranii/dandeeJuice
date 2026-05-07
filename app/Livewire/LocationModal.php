<?php

namespace App\Livewire;

use App\Models\DeliveryZone;
use Illuminate\Support\Collection;
use Livewire\Component;

class LocationModal extends Component
{
    public bool $visible = false;

    public string $selectedZoneId = '';

    public ?string $error = null;

    public Collection $zones;

    public function mount(): void
    {
        $this->visible = ! session()->has('order_type');
        $this->zones = DeliveryZone::activeOrdered()->get();
    }

    #[\Livewire\Attributes\On('location-modal:show')]
    public function show(): void
    {
        $this->error = null;
        $this->visible = true;
    }

    public function choosePickup(): void
    {
        session(['order_type' => 'pickup', 'delivery_zone_id' => null, 'delivery_zone_name' => null, 'delivery_fee' => 0]);
        $this->visible = false;
        $this->dispatch('order-type-selected', type: 'pickup');
    }

    public function chooseDelivery(): void
    {
        $this->error = null;

        if (empty($this->selectedZoneId)) {
            $this->error = 'Please select your delivery area.';
            return;
        }

        $zone = $this->zones->firstWhere('id', (int) $this->selectedZoneId);

        if (! $zone) {
            $this->error = 'Invalid zone selected. Please refresh and try again.';
            return;
        }

        session([
            'order_type' => 'delivery',
            'delivery_zone_id' => $zone->id,
            'delivery_zone_name' => $zone->name,
            'delivery_fee' => (float) $zone->delivery_fee,
        ]);

        $this->visible = false;
        $this->dispatch('order-type-selected', type: 'delivery');
    }

    public function render()
    {
        return view('livewire.location-modal');
    }
}
