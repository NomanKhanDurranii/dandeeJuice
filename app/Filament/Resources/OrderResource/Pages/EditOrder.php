<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Branch;
use App\Models\DeliveryZone;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->type === 'pickup' && ! empty($data['pickup_branch_id'])) {
            $branch = Branch::find($data['pickup_branch_id']);
            $data['delivery_address'] = $branch?->name;
            $data['delivery_zone_id'] = null;
        } elseif ($this->record->type === 'delivery' && ! empty($data['delivery_zone_id'])) {
            $zone = DeliveryZone::find($data['delivery_zone_id']);
            $data['delivery_address'] = $zone?->name;
            $data['pickup_branch_id'] = null;
        }

        return $data;
    }
}
