@php
    $whatsapp = \App\Models\Setting::get('whatsapp_number', '923001234567');
    $address  = \App\Models\Setting::get('store_address', '');
    $branches = \App\Models\Branch::activeOrdered()->get();
@endphp

<footer class="bg-brand-gradient text-white">

    {{-- ── Main 4-column grid ── --}}
    <div class="max-w-6xl mx-auto px-4 pt-14 pb-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

        {{-- Brand col --}}
        <div class="lg:col-span-1 space-y-4">
            <a href="{{ route('home') }}" class="inline-block text-2xl font-extrabold tracking-tight text-white">
                DandeeJuice
            </a>
            <p class="text-white/70 text-sm leading-relaxed">
                Fresh juices &amp; shakes made daily with 100% natural ingredients. Delivered to your door or ready for pickup.
            </p>
            <a href="https://wa.me/{{ $whatsapp }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-900 text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-md">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                </svg>
                Chat on WhatsApp
            </a>
        </div>

        {{-- Quick links --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-4">Quick Links</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('home') }}" class="text-white/80 hover:text-white transition">Home</a></li>
                <li><a href="{{ route('about') }}" class="text-white/80 hover:text-white transition">About Us</a></li>
                <li><a href="{{ route('catering') }}" class="text-white/80 hover:text-white transition">Catering Service</a></li>
                <li><a href="{{ route('contact') }}" class="text-white/80 hover:text-white transition">Contact Us</a></li>
            </ul>
        </div>

        {{-- Account & Support --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-4">Account</h3>
            <ul class="space-y-2.5 text-sm">
                @auth
                    <li><a href="{{ route('my-orders') }}" class="text-white/80 hover:text-white transition">My Orders</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="text-white/80 hover:text-white transition">Sign In</a></li>
                @endauth
                <li><a href="{{ route('contact') }}" class="text-white/80 hover:text-white transition">Help &amp; Support</a></li>
                <li>
                    <a href="https://wa.me/{{ $whatsapp }}?text=Hi%20DandeeJuice!%20I%20need%20help."
                       target="_blank" class="text-white/80 hover:text-white transition">WhatsApp Support</a>
                </li>
            </ul>
        </div>

        {{-- Legal --}}
        <div>
            <h3 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-4">Legal</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('privacy-policy') }}" class="text-white/80 hover:text-white transition">Privacy Policy</a></li>
                <li><a href="{{ route('refund-policy') }}" class="text-white/80 hover:text-white transition">Refund Policy</a></li>
            </ul>

            <div class="flex items-center gap-2 text-white/60 text-xs mt-6">
                <svg class="w-4 h-4 shrink-0 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Daily · 10:00 AM – 10:00 PM</span>
            </div>
        </div>

    </div>

    {{-- ── Branches strip (only shown when branches exist) ── --}}
    @if ($branches->isNotEmpty())
    <div class="bg-black/20">

        {{-- Centered divider label --}}
        <div class="flex items-center gap-4 px-6 pt-8">
            <div class="flex-1 h-px bg-white/30"></div>
            <div class="flex items-center gap-2 shrink-0">
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                </svg>
                <span class="text-[10px] font-black uppercase tracking-[0.25em] text-white/70">Our Locations</span>
            </div>
            <div class="flex-1 h-px bg-white/30"></div>
        </div>

        {{-- Branch cards --}}
        <div class="max-w-6xl mx-auto px-4 pb-8 pt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($branches as $branch)
                <div class="rounded-xl border border-white/25 bg-white/[0.07] hover:bg-white/[0.12] hover:border-white/40 transition-all duration-200 flex flex-col overflow-hidden">

                    {{-- Card top: name + address --}}
                    <div class="px-4 pt-4 pb-3 flex-1">
                        <p class="text-white font-bold text-sm leading-snug mb-1.5">{{ $branch->name }}</p>
                        <p class="text-white/55 text-xs leading-relaxed">{{ $branch->address }}</p>

                        @if ($branch->phone)
                            <a href="tel:{{ preg_replace('/\s+/', '', $branch->phone) }}"
                               class="inline-flex items-center gap-1.5 mt-3 text-white/80 hover:text-white text-xs font-semibold transition">
                                <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                                {{ $branch->phone }}
                            </a>
                        @endif
                    </div>

                    {{-- Card bottom: action buttons --}}
                    <div class="flex border-t border-white/20">
                        @if ($branch->phone || $branch->whatsapp)
                            <a href="{{ $branch->waUrl() }}" target="_blank"
                               class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-white/70 hover:text-white hover:bg-white/10 text-xs font-semibold transition border-r border-white/20">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                                </svg>
                                WhatsApp
                            </a>
                        @endif
                        <a href="{{ $branch->mapsUrl() }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-white/70 hover:text-white hover:bg-white/10 text-xs font-semibold transition">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            Directions
                        </a>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
    @elseif ($address)
    {{-- Fallback single-address strip when no branches are configured --}}
    <div class="border-t border-white/10 bg-black/10">
        <div class="max-w-6xl mx-auto px-4 py-5 flex items-center gap-3 text-white/60 text-xs">
            <svg class="w-4 h-4 shrink-0 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
            </svg>
            <span>{{ $address }}</span>
        </div>
    </div>
    @endif

    {{-- ── Bottom bar ── --}}
    <div class="border-t border-white/20">
        <div class="max-w-6xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/60">
            <span>&copy; {{ date('Y') }} DandeeJuice. All rights reserved.</span>
            <span>Made with care in Pakistan</span>
        </div>
    </div>

</footer>
