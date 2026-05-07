<div class="max-w-5xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- ===== LEFT: ITEMS + PAYMENT ===== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Order Items --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50">
                    <h2 class="font-semibold text-gray-700">Your Items</h2>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ($items as $productId => $item)
                    <div class="flex items-center gap-4 px-5 py-4" wire:key="item-{{ $productId }}">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($item['image'])
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-7 h-7 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 text-sm truncate">{{ $item['name'] }}</p>
                            <p class="text-gray-400 text-xs">PKR {{ number_format($item['price']) }} × {{ $item['qty'] }}</p>
                        </div>
                        <p class="font-semibold text-gray-700 text-sm shrink-0">
                            PKR {{ number_format($item['price'] * $item['qty']) }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-700 mb-4">Payment Method</h2>

                @error('paymentMethod')
                    <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
                @enderror

                <div class="space-y-3">

                    {{-- COD --}}
                    <label class="flex items-center gap-4 border-2 rounded-xl p-4 cursor-pointer transition
                        {{ $paymentMethod === 'cod' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" wire:model.live="paymentMethod" value="cod" class="sr-only">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">Cash on Delivery</p>
                            <p class="text-xs text-gray-400">Pay when your order arrives</p>
                        </div>
                        @if ($paymentMethod === 'cod')
                            <div class="w-5 h-5 rounded-full bg-red-600 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        @endif
                    </label>

                    {{-- EasyPaisa --}}
                    <label class="flex items-center gap-4 border-2 rounded-xl p-4 transition
                        {{ $easypaisaEnabled ? 'cursor-pointer ' . ($paymentMethod === 'easypaisa' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300') : 'border-gray-100 bg-gray-50 opacity-60 cursor-not-allowed' }}">
                        <input type="radio" wire:model.live="paymentMethod" value="easypaisa"
                               class="sr-only" {{ ! $easypaisaEnabled ? 'disabled' : '' }}>
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                            <img src="https://upload.wikimedia.org/wikipedia/en/6/69/Easypaisa_logo.png"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                                 class="w-8 h-8 object-contain" alt="EasyPaisa">
                            <span class="hidden"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3"/></svg></span>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">EasyPaisa</p>
                            <p class="text-xs {{ $easypaisaEnabled ? 'text-gray-400' : 'text-amber-500' }}">
                                {{ $easypaisaEnabled ? 'Pay via EasyPaisa mobile account' : 'Coming soon — not active yet' }}
                            </p>
                        </div>
                        @if (! $easypaisaEnabled)
                            <span class="text-xs bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full shrink-0">Soon</span>
                        @elseif ($paymentMethod === 'easypaisa')
                            <div class="w-5 h-5 rounded-full bg-red-600 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        @endif
                    </label>

                    {{-- JazzCash --}}
                    <label class="flex items-center gap-4 border-2 rounded-xl p-4 transition
                        {{ $jazzcashEnabled ? 'cursor-pointer ' . ($paymentMethod === 'jazzcash' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300') : 'border-gray-100 bg-gray-50 opacity-60 cursor-not-allowed' }}">
                        <input type="radio" wire:model.live="paymentMethod" value="jazzcash"
                               class="sr-only" {{ ! $jazzcashEnabled ? 'disabled' : '' }}>
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">JazzCash</p>
                            <p class="text-xs {{ $jazzcashEnabled ? 'text-gray-400' : 'text-amber-500' }}">
                                {{ $jazzcashEnabled ? 'Pay via JazzCash mobile account' : 'Coming soon — not active yet' }}
                            </p>
                        </div>
                        @if (! $jazzcashEnabled)
                            <span class="text-xs bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full shrink-0">Soon</span>
                        @elseif ($paymentMethod === 'jazzcash')
                            <div class="w-5 h-5 rounded-full bg-red-600 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        @endif
                    </label>

                </div>
            </div>

            {{-- Contact phone --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-700 mb-1">Contact Phone <span class="text-red-400 text-sm">*</span></h2>
                <p class="text-gray-400 text-xs mb-3">So we can reach you about your order</p>
                <input
                    wire:model="phone"
                    type="tel"
                    placeholder="03001234567"
                    class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                           {{ $errors->has('phone') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}"
                />
                @error('phone')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notes --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-700 mb-3">Order Notes <span class="text-gray-400 font-normal text-sm">(optional)</span></h2>
                <textarea
                    wire:model="notes"
                    rows="3"
                    placeholder="Any special instructions? e.g. extra cold, less sugar..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none transition"
                ></textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- ===== RIGHT: ORDER SUMMARY ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-[5.5rem]">

                <h2 class="font-semibold text-gray-700 mb-4">Order Summary</h2>

                {{-- Delivery type badge --}}
                <div class="flex items-center gap-2 mb-4 p-3 rounded-xl {{ $orderType === 'delivery' ? 'bg-blue-50' : 'bg-green-50' }}">
                    @if ($orderType === 'delivery')
                        <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    @else
                        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    @endif
                    <div>
                        <p class="text-sm font-semibold {{ $orderType === 'delivery' ? 'text-blue-700' : 'text-green-700' }}">
                            {{ $orderType === 'delivery' ? 'Home Delivery' : 'Takeaway / Pickup' }}
                        </p>
                        @if ($deliveryZoneName)
                            <p class="text-xs {{ $orderType === 'delivery' ? 'text-blue-500' : 'text-green-500' }}">{{ $deliveryZoneName }}</p>
                        @endif
                    </div>
                </div>

                {{-- Totals --}}
                <div class="space-y-2 text-sm mb-5">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span>PKR {{ number_format($subtotal) }}</span>
                    </div>
                    @if ($orderType === 'delivery')
                    <div class="flex justify-between text-gray-500">
                        <span>Delivery Fee</span>
                        <span>{{ $deliveryFee > 0 ? 'PKR '.number_format($deliveryFee) : 'Free' }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold text-gray-800 text-base pt-2 border-t border-gray-100">
                        <span>Total</span>
                        <span class="text-red-600">PKR {{ number_format($this->total()) }}</span>
                    </div>
                </div>

                {{-- Place Order --}}
                <button
                    wire:click="placeOrder"
                    wire:loading.attr="disabled"
                    class="w-full bg-red-600 hover:bg-red-700 disabled:opacity-60 text-white font-bold py-3.5 rounded-xl transition active:scale-95"
                >
                    <span wire:loading.remove wire:target="placeOrder">
                        Place Order
                    </span>
                    <span wire:loading wire:target="placeOrder">
                        Placing order…
                    </span>
                </button>

                <a href="{{ route('home') }}"
                   class="block text-center text-xs text-gray-400 hover:text-gray-600 mt-3 transition">
                    &larr; Continue shopping
                </a>

            </div>
        </div>

    </div>
</div>
