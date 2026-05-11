<div>
    @if ($visible)
    <div
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:px-4"
        x-data="{ tab: 'delivery' }"
        x-init="document.body.style.overflow = 'hidden'"
    >
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        {{-- Sheet: slides up from bottom on mobile, centered card on sm+ --}}
        <div class="relative z-10 bg-white w-full sm:max-w-sm sm:rounded-2xl rounded-t-2xl shadow-2xl flex flex-col max-h-[92dvh]">

            {{-- Drag handle (mobile only) --}}
            <div class="flex justify-center pt-3 pb-1 sm:hidden">
                <div class="w-10 h-1 rounded-full bg-gray-200"></div>
            </div>

            {{-- Header --}}
            <div class="px-5 pt-4 pb-4 shrink-0">
                <h2 class="text-center text-base font-bold text-gray-800 mb-4">How would you like your order?</h2>

                {{-- DELIVERY / PICK-UP toggle --}}
                <div class="flex bg-gray-100 rounded-full p-1 gap-1">
                    <button
                        @click="tab = 'delivery'"
                        :class="tab === 'delivery' ? 'bg-brand-gradient text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-full text-sm font-bold tracking-wide transition-all"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                        </svg>
                        Delivery
                    </button>
                    <button
                        @click="tab = 'pickup'"
                        :class="tab === 'pickup' ? 'bg-brand-gradient text-white shadow' : 'text-gray-500 hover:text-gray-700'"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-full text-sm font-bold tracking-wide transition-all"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Pick-up
                    </button>
                </div>
            </div>

            {{-- Scrollable body --}}
            <div class="overflow-y-auto flex-1 px-5">

                {{-- Error --}}
                @if ($error)
                    <div class="mb-4 bg-red-50 text-red-600 text-sm rounded-xl px-4 py-3 flex gap-2 items-start border border-red-100">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        {{ $error }}
                    </div>
                @endif

                {{-- ── DELIVERY TAB ── --}}
                <div x-show="tab === 'delivery'" x-cloak class="pb-4">

                    @if ($zones->isEmpty())
                        <div class="bg-amber-50 border border-amber-100 text-amber-700 text-sm rounded-xl px-4 py-3 flex gap-2 items-start">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                            No delivery zones are active yet. Please choose Pick-up.
                        </div>
                    @else
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select your area</label>

                        {{-- Dropdown --}}
                        <div class="relative">
                            <select
                                wire:model.live="selectedZoneId"
                                class="w-full appearance-none border border-gray-300 rounded-xl px-4 py-3 pr-10 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent bg-white cursor-pointer transition"
                            >
                                <option value="">— Choose your area —</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}">
                                        {{ $zone->name }} — {{ $zone->delivery_fee > 0 ? 'PKR '.number_format($zone->delivery_fee) : 'Free delivery' }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- Chevron icon --}}
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Selected zone info card --}}
                        @if ($selectedZoneId)
                            @php $selectedZone = $zones->firstWhere('id', $selectedZoneId); @endphp
                            @if ($selectedZone)
                                <div class="mt-3 bg-red-50 border border-red-100 rounded-xl px-4 py-3 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-gradient flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $selectedZone->name }}</p>
                                        <p class="text-xs text-red-600 font-medium mt-0.5">
                                            {{ $selectedZone->delivery_fee > 0
                                                ? 'Delivery fee: PKR '.number_format($selectedZone->delivery_fee)
                                                : 'Free delivery' }}
                                        </p>
                                    </div>
                                    <svg class="w-5 h-5 text-red-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                {{-- ── PICK-UP TAB ── --}}
                <div x-show="tab === 'pickup'" x-cloak class="pb-4">
                    <p class="text-sm font-medium text-gray-700 mb-3">
                        {{ $branches->count() > 1 ? 'Select a branch for pick-up' : 'Our store location' }}
                    </p>

                    @if ($branches->isNotEmpty())
                    {{-- Branch selection using Alpine for instant visual feedback --}}
                    <div class="space-y-3" x-data="{ picked: '{{ $selectedBranchId }}' }">
                        @foreach ($branches as $branch)
                        <button
                            type="button"
                            @click="picked = '{{ $branch->id }}'; $wire.set('selectedBranchId', '{{ $branch->id }}')"
                            :class="picked === '{{ $branch->id }}'
                                ? 'border-2 border-red-600 bg-red-50 ring-0'
                                : 'border border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50'"
                            class="w-full text-left rounded-xl p-4 flex items-start gap-3 transition-all duration-150 cursor-pointer"
                        >
                            {{-- Icon: checkmark when selected, store icon when not --}}
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 mt-0.5 transition-all duration-150"
                                 :style="picked === '{{ $branch->id }}' ? 'background: linear-gradient(135deg,#22f24f 0%,#064a01 100%)' : 'background: #f3f4f6'">
                                {{-- Store icon (shown when not selected) --}}
                                <svg x-show="picked !== '{{ $branch->id }}'"
                                     class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                                </svg>
                                {{-- Checkmark (shown when selected) --}}
                                <svg x-show="picked === '{{ $branch->id }}'"
                                     class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800 text-sm">{{ $branch->name }}</p>
                                <p class="text-gray-500 text-xs mt-1 leading-relaxed">{{ $branch->address }}</p>

                                @if ($branch->phone)
                                    <span class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-gray-600">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                        </svg>
                                        {{ $branch->phone }}
                                    </span>
                                @endif

                                {{-- Links (stop propagation so they don't select the card) --}}
                                <div class="flex items-center gap-3 mt-2" @click.stop>
                                    <a href="{{ $branch->mapsUrl() }}" target="_blank"
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-red-600 hover:text-red-700 transition">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                                        </svg>
                                        Get Directions
                                    </a>
                                    @if ($branch->phone || $branch->whatsapp)
                                    <a href="{{ $branch->waUrl('Hi DandeeJuice! I want to place a pick-up order.') }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 hover:text-green-800 transition">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Selection indicator dot (right side) --}}
                            <div class="shrink-0 mt-1">
                                <div class="w-4 h-4 rounded-full border-2 transition-all duration-150 flex items-center justify-center"
                                     :class="picked === '{{ $branch->id }}'
                                         ? 'border-red-600 bg-red-600'
                                         : 'border-gray-300 bg-white'">
                                    <svg x-show="picked === '{{ $branch->id }}'"
                                         class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="6"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
                    @else
                    {{-- @empty equivalent: fallback when no branches configured --}}
                        {{-- Fallback to settings if no branches configured --}}
                        @php $fallbackAddress = \App\Models\Setting::get('store_address', '') @endphp
                        @if ($fallbackAddress)
                            <div class="border-2 border-red-600 bg-red-50 rounded-xl p-4 flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-brand-gradient flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">DandeeJuice</p>
                                    <p class="text-gray-500 text-xs mt-1 leading-relaxed">{{ $fallbackAddress }}</p>
                                    <a href="https://maps.google.com/?q={{ urlencode($fallbackAddress) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-red-600 hover:text-red-700 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                                        </svg>
                                        Get Directions
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-amber-50 border border-amber-100 text-amber-700 text-sm rounded-xl px-4 py-3">
                                No branch locations configured yet. Please contact us on WhatsApp for pick-up details.
                            </div>
                        @endif
                    @endif
                </div>

            </div>

            {{-- ── Footer: Select button ── --}}
            <div class="px-5 py-4 border-t border-gray-100 shrink-0">
                <div x-show="tab === 'delivery'">
                    @if (! $zones->isEmpty())
                        <button
                            wire:click="chooseDelivery"
                            wire:loading.attr="disabled"
                            wire:target="chooseDelivery"
                            class="w-full bg-brand-gradient disabled:opacity-60 text-white font-bold py-3.5 rounded-xl text-sm transition active:scale-95"
                        >
                            <span wire:loading.remove wire:target="chooseDelivery">Confirm Delivery Area</span>
                            <span wire:loading wire:target="chooseDelivery">Saving…</span>
                        </button>
                    @endif
                </div>
                <div x-show="tab === 'pickup'">
                    <button
                        wire:click="choosePickup"
                        wire:loading.attr="disabled"
                        class="w-full bg-brand-gradient disabled:opacity-60 text-white font-bold py-3.5 rounded-xl text-sm transition active:scale-95"
                    >
                        <span wire:loading.remove wire:target="choosePickup">Confirm Pick-up</span>
                        <span wire:loading wire:target="choosePickup">Saving…</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
    @else
    <div x-data x-init="document.body.style.overflow = ''"></div>
    @endif
</div>
