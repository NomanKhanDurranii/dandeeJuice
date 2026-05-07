<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    protected string $view = 'filament.pages.manage-settings';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 10;

    public bool $easypaisaEnabled = false;
    public bool $jazzcashEnabled  = false;
    public string $whatsappNumber = '';
    public string $storeName      = '';
    public string $storeAddress   = '';

    public function mount(): void
    {
        $this->easypaisaEnabled = Setting::get('easypaisa_enabled', '0') === '1';
        $this->jazzcashEnabled  = Setting::get('jazzcash_enabled', '0') === '1';
        $this->whatsappNumber   = Setting::get('whatsapp_number', '923001234567');
        $this->storeName        = Setting::get('store_name', 'DandeeJuice');
        $this->storeAddress     = Setting::get('store_address', '');
    }

    public function save(): void
    {
        $this->validate([
            'whatsappNumber' => 'required|min:7|max:20',
            'storeName'      => 'required|max:100',
            'storeAddress'   => 'nullable|max:300',
        ]);

        Setting::set('easypaisa_enabled', $this->easypaisaEnabled ? '1' : '0', 'payments');
        Setting::set('jazzcash_enabled',  $this->jazzcashEnabled  ? '1' : '0', 'payments');
        Setting::set('whatsapp_number',   $this->whatsappNumber,               'contact');
        Setting::set('store_name',        $this->storeName,                    'general');
        Setting::set('store_address',     $this->storeAddress ?? '',           'general');

        Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }
}
