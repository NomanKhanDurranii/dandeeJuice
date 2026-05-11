<x-storefront :navCategories="[]">
    <div class="max-w-2xl mx-auto px-4 py-16">

        {{-- Success header --}}
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Order Placed!</h1>
            <p class="text-gray-500">
                Thank you, <strong>{{ auth()->user()->name }}</strong>! We've received your order.
            </p>
        </div>

        {{-- Order card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">

            {{-- Order meta --}}
            <div class="px-6 py-5 border-b border-gray-50 flex flex-wrap gap-4 justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Order ID</p>
                    <p class="text-xl font-bold text-gray-800">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Status</p>
                    <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Type</p>
                    <p class="text-sm font-semibold text-gray-700 flex items-center gap-1">
                        @if ($order->type === 'delivery')
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            Home Delivery
                        @else
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Takeaway
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide">Payment</p>
                    <p class="text-sm font-semibold text-gray-700">
                        {{ match($order->payment_method) {
                            'cod'       => 'Cash on Delivery',
                            'easypaisa' => 'EasyPaisa',
                            'jazzcash'  => 'JazzCash',
                            default     => ucfirst($order->payment_method),
                        } }}
                    </p>
                </div>
            </div>

            {{-- Items --}}
            <div class="divide-y divide-gray-50">
                @foreach ($order->items as $item)
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-400">PKR {{ number_format($item->product_price) }} × {{ $item->quantity }}</p>
                    </div>
                    <p class="font-semibold text-gray-700 text-sm">PKR {{ number_format($item->subtotal) }}</p>
                </div>
                @endforeach
            </div>

            {{-- Totals --}}
            <div class="px-6 py-4 bg-gray-50 space-y-1.5">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Subtotal</span>
                    <span>PKR {{ number_format($order->subtotal) }}</span>
                </div>
                @if ($order->type === 'pickup' && ($order->pickupBranch || $order->delivery_address))
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Pickup Branch</span>
                    <span class="text-gray-700 font-medium">{{ $order->pickupBranch?->name ?? $order->delivery_address }}</span>
                </div>
                @elseif ($order->type === 'delivery' && ($order->deliveryZone || $order->delivery_address))
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Delivery Zone</span>
                    <span class="text-gray-700 font-medium">{{ $order->deliveryZone?->name ?? $order->delivery_address }}</span>
                </div>
                @endif
                @if ($order->delivery_fee > 0)
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Delivery Fee</span>
                    <span>PKR {{ number_format($order->delivery_fee) }}</span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-gray-800 text-base pt-1 border-t border-gray-200">
                    <span>Total</span>
                    <span class="text-red-600">PKR {{ number_format($order->total) }}</span>
                </div>
            </div>

            @if ($order->notes)
            <div class="px-6 py-4 border-t border-gray-50">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Notes</p>
                <p class="text-sm text-gray-600">{{ $order->notes }}</p>
            </div>
            @endif

        </div>

        {{-- Info message --}}
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-8 text-sm text-blue-700 flex gap-3">
            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
            </svg>
            <p>
                @if ($order->type === 'delivery')
                    Our team will contact you shortly to confirm your order and delivery details. You can also reach us on
                @else
                    Your order is being prepared. Please visit our store to collect it. For updates, contact us on
                @endif
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','923001234567') }}" target="_blank" class="font-semibold underline">WhatsApp</a>.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('home') }}"
               class="flex-1 text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                Order More
            </a>
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','923001234567') }}?text=Hi!%20My%20order%20number%20is%20%23{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}"
               target="_blank"
               class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition">
                Track on WhatsApp
            </a>
        </div>

    </div>
</x-storefront>
