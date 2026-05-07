<div>
    @if ($submitted)
        <div class="text-center py-10">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Request Received!</h3>
            <p class="text-gray-500 mb-6">We'll get back to you within 24 hours with a customised quote. You can also reach us instantly on WhatsApp for faster response.</p>
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '923001234567') }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition font-semibold text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                Chat on WhatsApp
            </a>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5" novalidate>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Name <span class="text-red-400">*</span></label>
                    <input wire:model.blur="name" type="text" placeholder="Your full name"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"/>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone <span class="text-red-400">*</span></label>
                    <input wire:model.blur="phone" type="tel" placeholder="03001234567"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition {{ $errors->has('phone') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"/>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-400">*</span></label>
                    <input wire:model.blur="email" type="email" placeholder="you@example.com"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"/>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Date <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input wire:model.blur="eventDate" type="text" placeholder="e.g. 20 June 2026"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"/>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Type <span class="text-red-400">*</span></label>
                    <select wire:model.live="eventType"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition bg-white {{ $errors->has('eventType') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}">
                        <option value="">— Select event type —</option>
                        <option>Wedding</option>
                        <option>Birthday Party</option>
                        <option>Corporate Event</option>
                        <option>Graduation</option>
                        <option>Family Gathering</option>
                        <option>Other</option>
                    </select>
                    @error('eventType') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Estimated Guests <span class="text-red-400">*</span></label>
                    <select wire:model.live="guestCount"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition bg-white {{ $errors->has('guestCount') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}">
                        <option value="">— Select range —</option>
                        <option>10–25</option>
                        <option>25–50</option>
                        <option>50–100</option>
                        <option>100–200</option>
                        <option>200–500</option>
                        <option>500+</option>
                    </select>
                    @error('guestCount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tell us about your event <span class="text-red-400">*</span></label>
                <textarea wire:model.blur="message" rows="4"
                    placeholder="Describe your event, preferred drinks, any special requirements…"
                    class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-none {{ $errors->has('message') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"></textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white font-bold py-3.5 rounded-xl transition active:scale-95">
                <span wire:loading.remove wire:target="submit">Send Catering Request</span>
                <span wire:loading wire:target="submit">Sending…</span>
            </button>

        </form>
    @endif
</div>
