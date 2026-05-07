@php
    $whatsapp = \App\Models\Setting::get('whatsapp_number', '923001234567');
    $address  = \App\Models\Setting::get('store_address', '');
@endphp

<footer class="bg-blue-900 text-white">

    {{-- Main footer grid --}}
    <div class="max-w-6xl mx-auto px-4 py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

        {{-- Brand col --}}
        <div class="lg:col-span-1 space-y-4">
            <a href="{{ route('home') }}" class="inline-block text-2xl font-extrabold tracking-tight text-white">
                DandeeJuice
            </a>
            <p class="text-blue-200 text-sm leading-relaxed">
                Fresh juices &amp; shakes made daily with 100% natural ingredients. Delivered to your door or ready for pickup.
            </p>
            {{-- WhatsApp --}}
            <a href="https://wa.me/{{ $whatsapp }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-400 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                </svg>
                Chat on WhatsApp
            </a>
        </div>

        {{-- Quick links --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-blue-300 mb-4">Quick Links</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('home') }}" class="text-blue-100 hover:text-white transition">Home</a></li>
                <li><a href="{{ route('about') }}" class="text-blue-100 hover:text-white transition">About Us</a></li>
                <li><a href="{{ route('catering') }}" class="text-blue-100 hover:text-white transition">Catering Service</a></li>
                <li><a href="{{ route('contact') }}" class="text-blue-100 hover:text-white transition">Contact Us</a></li>
            </ul>
        </div>

        {{-- Account & Support --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-blue-300 mb-4">Account</h3>
            <ul class="space-y-2.5 text-sm">
                @auth
                    <li><a href="{{ route('my-orders') }}" class="text-blue-100 hover:text-white transition">My Orders</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="text-blue-100 hover:text-white transition">Sign In</a></li>
                @endauth
                <li><a href="{{ route('contact') }}" class="text-blue-100 hover:text-white transition">Help &amp; Support</a></li>
                <li>
                    <a href="https://wa.me/{{ $whatsapp }}?text=Hi%20DandeeJuice!%20I%20need%20help."
                       target="_blank" class="text-blue-100 hover:text-white transition">WhatsApp Support</a>
                </li>
            </ul>
        </div>

        {{-- Legal + address --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-blue-300 mb-4">Legal</h3>
            <ul class="space-y-2.5 text-sm mb-6">
                <li><a href="{{ route('privacy-policy') }}" class="text-blue-100 hover:text-white transition">Privacy Policy</a></li>
                <li><a href="{{ route('refund-policy') }}" class="text-blue-100 hover:text-white transition">Refund Policy</a></li>
            </ul>

            @if ($address)
            <div class="flex items-start gap-2 text-blue-200 text-xs leading-relaxed">
                <svg class="w-4 h-4 shrink-0 mt-0.5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <span>{{ $address }}</span>
            </div>
            @endif

            <div class="flex items-center gap-2 text-blue-200 text-xs mt-2">
                <svg class="w-4 h-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Daily · 10:00 AM – 10:00 PM</span>
            </div>
        </div>

    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-blue-800">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-blue-300">
            <span>&copy; {{ date('Y') }} DandeeJuice. All rights reserved.</span>
            <span>Made with care in Pakistan</span>
        </div>
    </div>

</footer>
