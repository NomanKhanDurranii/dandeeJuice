<div>
    {{-- Backdrop --}}
    @if ($open)
    <div
        wire:click="$set('open', false)"
        class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm"
        x-data
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>
    @endif

    {{-- Slide-over panel --}}
    <div
        class="fixed top-0 right-0 z-50 h-full w-full max-w-sm bg-white shadow-2xl flex flex-col transition-transform duration-300"
        :class="{{ $open ? 'true' : 'false' }} ? 'translate-x-0' : 'translate-x-full'"
        x-data="{ open: @js($open) }"
        x-init="$watch('$wire.open', val => open = val)"
        :class="open ? 'translate-x-0' : 'translate-x-full'"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Your Cart</h2>
                @if ($orderType)
                    <span class="text-xs flex items-center gap-1 {{ $orderType === 'delivery' ? 'text-blue-500' : 'text-green-500' }}">
                        @if ($orderType === 'delivery')
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            Home Delivery
                        @else
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Takeaway
                        @endif
                    </span>
                @endif
            </div>
            <button wire:click="$set('open', false)" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Items --}}
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
            @forelse ($items as $item)
                @php $cartKey = $item['cart_key']; @endphp
                <div class="flex gap-3 items-start" wire:key="cart-item-{{ $cartKey }}">
                    {{-- Thumb --}}
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                        @if ($item['image'])
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-blue-200">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 text-sm truncate">{{ $item['name'] }}</p>
                        @if (!empty($item['variant_name']))
                            <p class="text-xs text-blue-600 font-medium">{{ $item['variant_name'] }}</p>
                        @endif
                        <p class="text-red-600 font-semibold text-sm">PKR {{ number_format($item['price']) }}</p>

                        {{-- Qty controls --}}
                        <div class="flex items-center gap-2 mt-1.5">
                            <button
                                wire:click="decrement('{{ $cartKey }}')"
                                class="w-7 h-7 flex items-center justify-center rounded-full border border-gray-200 hover:border-blue-400 hover:text-blue-700 text-gray-500 text-sm font-bold transition"
                            >−</button>
                            <span class="text-sm font-semibold w-5 text-center">{{ $item['qty'] }}</span>
                            <button
                                wire:click="increment('{{ $cartKey }}')"
                                class="w-7 h-7 flex items-center justify-center rounded-full border border-gray-200 hover:border-blue-400 hover:text-blue-700 text-gray-500 text-sm font-bold transition"
                            >+</button>
                        </div>
                    </div>

                    {{-- Line total + remove --}}
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-gray-700">PKR {{ number_format($item['price'] * $item['qty']) }}</p>
                        <button
                            wire:click="removeItem('{{ $cartKey }}')"
                            class="text-xs text-red-400 hover:text-red-600 mt-1 transition"
                        >Remove</button>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center h-40 text-center">
                    <svg class="w-14 h-14 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Your cart is empty</p>
                    <p class="text-gray-400 text-xs mt-1">Add some delicious items!</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if (count($items) > 0)
        <div class="border-t border-gray-100 px-5 py-4 space-y-3">
            <div class="space-y-1.5 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span>PKR {{ number_format($subtotal) }}</span>
                </div>
                @if ($orderType === 'delivery')
                <div class="flex justify-between text-gray-500">
                    <span>Delivery Fee</span>
                    <span>PKR {{ number_format($deliveryFee) }}</span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-gray-800 text-base pt-1 border-t border-gray-100">
                    <span>Total</span>
                    <span class="text-red-600">PKR {{ number_format($subtotal + $deliveryFee) }}</span>
                </div>
            </div>

            @if ($deliveryZoneName)
            <div class="bg-blue-50 rounded-lg px-3 py-2 text-xs text-blue-600 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                Delivering to: <strong>{{ $deliveryZoneName }}</strong>
            </div>
            @endif

            <button
                wire:click="checkout"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition"
            >
                Proceed to Checkout
            </button>

            <button
                wire:click="clearCart"
                class="w-full text-xs text-gray-400 hover:text-red-500 transition"
            >
                Clear cart
            </button>
        </div>
        @endif
    </div>
</div>
