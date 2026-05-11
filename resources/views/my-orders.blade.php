<x-storefront :navCategories="[]">

    <div class="max-w-4xl mx-auto px-4 py-12">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">My Orders</h1>
                <p class="text-gray-400 text-sm mt-0.5">{{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('home') }}"
               class="text-sm font-medium text-blue-700 hover:text-blue-900 transition">
                + Order more
            </a>
        </div>

        @if ($orders->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                </svg>
                <p class="text-gray-500 font-medium">No orders yet</p>
                <p class="text-gray-400 text-sm mt-1 mb-6">Your order history will appear here.</p>
                <a href="{{ route('home') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-xl transition">
                    Browse Menu
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- Order header --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-800">
                                #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                {{ match($order->status) {
                                    'pending'          => 'bg-amber-100 text-amber-700',
                                    'confirmed',
                                    'preparing',
                                    'out_for_delivery' => 'bg-blue-100 text-blue-700',
                                    'delivered'        => 'bg-green-100 text-green-700',
                                    'cancelled'        => 'bg-red-100 text-red-700',
                                    default            => 'bg-gray-100 text-gray-600',
                                } }}">
                                {{ match($order->status) {
                                    'pending'          => 'Pending',
                                    'confirmed'        => 'Confirmed',
                                    'preparing'        => 'Preparing',
                                    'out_for_delivery' => 'On the way',
                                    'delivered'        => 'Delivered',
                                    'cancelled'        => 'Cancelled',
                                    default            => ucfirst($order->status),
                                } }}
                            </span>

                            <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                {{ $order->type === 'delivery' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600' }}">
                                {{ $order->type === 'delivery' ? 'Delivery' : 'Pickup' }}
                            </span>
                        </div>
                    </div>

                    {{-- Items preview --}}
                    <div class="px-5 py-3 flex flex-wrap gap-2">
                        @foreach ($order->items as $item)
                            <span class="bg-gray-50 border border-gray-100 text-gray-600 text-xs px-3 py-1.5 rounded-full">
                                {{ $item->product_name }}
                                <span class="text-gray-400">×{{ $item->quantity }}</span>
                            </span>
                        @endforeach
                    </div>

                    {{-- Location strip --}}
                    @php
                        $locationLabel = $order->type === 'pickup' ? 'Pickup' : 'Zone';
                        $locationValue = $order->type === 'pickup'
                            ? ($order->pickupBranch?->name ?? $order->delivery_address)
                            : ($order->deliveryZone?->name ?? $order->delivery_address);
                    @endphp
                    @if ($locationValue)
                    <div class="px-5 py-2 border-t border-gray-50 text-xs text-gray-400">
                        <span class="font-medium text-gray-500">{{ $locationLabel }}:</span> {{ $locationValue }}
                    </div>
                    @endif

                    {{-- Footer --}}
                    <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="text-sm">
                            <span class="text-gray-500">Total: </span>
                            <span class="font-bold text-red-600">PKR {{ number_format($order->total) }}</span>
                            @if ($order->delivery_fee > 0)
                                <span class="text-gray-400 text-xs">(incl. PKR {{ number_format($order->delivery_fee) }} delivery)</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('order.confirmation', $order->id) }}"
                               class="text-xs font-medium text-blue-600 hover:text-blue-800 transition">
                                View details →
                            </a>
                            @if (in_array($order->status, ['pending', 'confirmed', 'preparing', 'out_for_delivery']))
                                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','923001234567') }}?text=Hi!%20Order%20%23{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}%20update?"
                                   target="_blank"
                                   class="text-xs font-medium text-green-600 hover:text-green-700 transition">
                                    Track on WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif

    </div>

</x-storefront>
