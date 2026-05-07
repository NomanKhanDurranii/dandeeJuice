<x-filament-panels::page>

    <form wire:submit="save" style="max-width:640px; display:flex; flex-direction:column; gap:1.5rem;">

        {{-- Payment Gateways --}}
        <x-filament::section heading="Payment Gateways" description="Enable or disable digital payment options at checkout.">
            <div style="display:flex; flex-direction:column; gap:0.75rem;">

                <label style="display:flex; align-items:center; justify-content:space-between; padding:1rem; border-radius:0.75rem; background:rgba(255,255,255,0.05); cursor:pointer;">
                    <div>
                        <p style="font-size:0.875rem; font-weight:600; margin:0;">EasyPaisa</p>
                        <p style="font-size:0.75rem; color:#94a3b8; margin:0.25rem 0 0;">Customers can pay via EasyPaisa mobile account</p>
                    </div>
                    <input type="checkbox" wire:model.live="easypaisaEnabled"
                           style="width:1.1rem; height:1.1rem; cursor:pointer; accent-color:#3b82f6;">
                </label>

                <label style="display:flex; align-items:center; justify-content:space-between; padding:1rem; border-radius:0.75rem; background:rgba(255,255,255,0.05); cursor:pointer;">
                    <div>
                        <p style="font-size:0.875rem; font-weight:600; margin:0;">JazzCash</p>
                        <p style="font-size:0.75rem; color:#94a3b8; margin:0.25rem 0 0;">Customers can pay via JazzCash mobile account</p>
                    </div>
                    <input type="checkbox" wire:model.live="jazzcashEnabled"
                           style="width:1.1rem; height:1.1rem; cursor:pointer; accent-color:#3b82f6;">
                </label>

            </div>
        </x-filament::section>

        {{-- Contact & Store --}}
        <x-filament::section heading="Contact & Store" description="WhatsApp number shown to customers, and store pickup address.">
            <div style="display:flex; flex-direction:column; gap:1.25rem;">

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.4rem;">
                        WhatsApp Number <span style="color:#f87171;">*</span>
                    </label>
                    <div style="display:flex; border:1px solid rgba(255,255,255,0.15); border-radius:0.5rem; overflow:hidden;">
                        <span style="display:flex; align-items:center; padding:0 0.75rem; font-size:0.875rem; background:rgba(255,255,255,0.05); border-right:1px solid rgba(255,255,255,0.15); color:#94a3b8;">+</span>
                        <input wire:model="whatsappNumber" type="text" placeholder="923001234567"
                               style="flex:1; padding:0.625rem 0.75rem; font-size:0.875rem; background:transparent; border:none; outline:none; color:inherit;" />
                    </div>
                    @error('whatsappNumber') <p style="color:#f87171; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p> @enderror
                    <p style="font-size:0.75rem; color:#64748b; margin-top:0.25rem;">Include country code without +, e.g. 923001234567</p>
                </div>

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.4rem;">
                        Store Name <span style="color:#f87171;">*</span>
                    </label>
                    <input wire:model="storeName" type="text" placeholder="DandeeJuice"
                           style="width:100%; padding:0.625rem 0.75rem; font-size:0.875rem; border:1px solid rgba(255,255,255,0.15); border-radius:0.5rem; background:transparent; outline:none; color:inherit; box-sizing:border-box;" />
                    @error('storeName') <p style="color:#f87171; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; margin-bottom:0.4rem;">Pickup Address</label>
                    <textarea wire:model="storeAddress" rows="2" placeholder="123 Main Street, Lahore"
                              style="width:100%; padding:0.625rem 0.75rem; font-size:0.875rem; border:1px solid rgba(255,255,255,0.15); border-radius:0.5rem; background:transparent; outline:none; color:inherit; resize:none; box-sizing:border-box;"></textarea>
                    @error('storeAddress') <p style="color:#f87171; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p> @enderror
                </div>

            </div>
        </x-filament::section>

        <div>
            <x-filament::button type="submit" size="lg">
                Save Settings
            </x-filament::button>
        </div>

    </form>

</x-filament-panels::page>
