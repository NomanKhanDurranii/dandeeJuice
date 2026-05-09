@props(['navCategories' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'DandeeJuice – Fresh & Delicious' }}</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-gray-50 antialiased font-sans">

    {{-- Location modal (blocks until Delivery/Pickup chosen) --}}
    @livewire('location-modal')

    {{-- =========== MARQUEE STRIP =========== --}}
    <div class="sticky top-0 z-30">
    <div class="bg-red-600 overflow-hidden py-1.5">
        <style>
            @keyframes marquee-scroll {
                from { transform: translateX(0); }
                to   { transform: translateX(-50%); }
            }
            .marquee-track { display:flex; width:max-content; animation: marquee-scroll 30s linear infinite; }
            .marquee-track:hover { animation-play-state: paused; }
        </style>
        @php
            $marqueeItems = [
                ['icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'text' => 'Freshly Made Every Day'],
                ['icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/></svg>', 'text' => 'Cold-Pressed Juices'],
                ['icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>', 'text' => 'Fast Home Delivery'],
                ['icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>', 'text' => 'Best in Town'],
                ['icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>', 'text' => 'Catering Available — Call Now'],
            ];
        @endphp
        <div class="marquee-track">
            @foreach ([1,2,3] as $_)
                @foreach ($marqueeItems as $item)
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-white tracking-wide whitespace-nowrap px-5">
                        {!! $item['icon'] !!}
                        {{ $item['text'] }}
                    </span>
                    <span class="text-white/50 text-xs select-none">•</span>
                @endforeach
            @endforeach
        </div>
    </div>

    {{-- =========== NAVBAR =========== --}}
    <nav x-data="{ menuOpen: false }" class="bg-white shadow-sm">
        @php
            $orderType    = session('order_type');
            $zoneName     = session('delivery_zone_name', '');
            $whatsapp     = \App\Models\Setting::get('whatsapp_number', '923001234567');
            $displayPhone = '+' . substr($whatsapp, 0, 2) . ' ' . substr($whatsapp, 2, 3) . ' ' . substr($whatsapp, 5, 7);
        @endphp

        {{-- ── Main bar ── --}}
        <div class="max-w-7xl mx-auto px-5 h-[4.75rem] flex items-center gap-4">

            {{-- LEFT: location + divider + contact --}}
            <div class="hidden sm:flex items-center gap-1 flex-1">

                {{-- Location pill --}}
                <button x-data @click="Livewire.dispatch('location-modal:show')"
                        class="group flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-red-50 transition-colors duration-200 cursor-pointer">
                    <div class="w-8 h-8 rounded-lg bg-red-100 group-hover:bg-red-200 flex items-center justify-center transition-colors shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                    </div>
                    <div class="text-left leading-none">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-0.5">
                            {{ $orderType === 'delivery' ? 'Delivering to' : ($orderType === 'pickup' ? 'Pickup' : 'Order Type') }}
                        </p>
                        <p class="text-[13px] font-bold text-gray-800 group-hover:text-red-600 transition-colors truncate max-w-[110px]">
                            {{ $orderType === 'delivery' ? $zoneName : ($orderType === 'pickup' ? 'Our Store' : 'Select Location') }}
                        </p>
                    </div>
                </button>

                {{-- Slim divider --}}
                <div class="hidden md:block w-px h-7 bg-gray-200 mx-1"></div>

                {{-- Contact pill --}}
                <a href="tel:+{{ $whatsapp }}"
                   class="hidden md:flex group items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-green-50 transition-colors duration-200">
                    <div class="w-8 h-8 rounded-lg bg-green-100 group-hover:bg-green-200 flex items-center justify-center transition-colors shrink-0">
                        <svg class="w-4 h-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                    </div>
                    <div class="text-left leading-none">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-0.5">Contact Us</p>
                        <p class="text-[13px] font-bold text-gray-800 group-hover:text-green-700 transition-colors">{{ $displayPhone }}</p>
                    </div>
                </a>
            </div>

            {{-- CENTER: Logo --}}
            <div class="flex-1 flex sm:justify-center">
                <a href="{{ route('home') }}" class="hover:opacity-75 transition-opacity duration-200">
                    <img src="/android-chrome-192x192.png" alt="DandeeJuice" class="h-11 w-auto">
                </a>
            </div>

            {{-- RIGHT: auth links + cart + hamburger --}}
            <div class="flex-1 flex items-center justify-end gap-1.5">

                @auth
                    <a href="{{ route('my-orders') }}"
                       class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="hidden lg:inline">My Orders</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors duration-200">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span class="hidden lg:inline">Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:flex items-center gap-1.5 px-3 py-2 rounded-xl text-[13px] font-semibold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        <span class="hidden lg:inline">Login</span>
                    </a>
                @endauth

                {{-- Slim divider before cart --}}
                <div class="hidden sm:block w-px h-6 bg-gray-200 mx-1"></div>

                @livewire('cart-slide-over-trigger')

                {{-- Hamburger — mobile only --}}
                <button @click="menuOpen = !menuOpen"
                        class="sm:hidden w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-500 hover:border-red-300 hover:text-red-600 hover:bg-red-50 transition-all duration-200"
                        aria-label="Toggle menu">
                    <svg x-show="!menuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="menuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Bottom accent --}}
        <div class="h-px bg-gradient-to-r from-transparent via-red-500 to-transparent"></div>

        {{-- ── Mobile dropdown ── --}}
        <div x-show="menuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="sm:hidden border-t border-gray-100 bg-white">

            {{-- Nav links --}}
            <div class="px-4 pt-3 pb-2 space-y-0.5">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.25em] px-3 pb-1">Navigate</p>
                @foreach ([['route' => 'home','label' => 'Home','path' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'], ['route' => 'about','label' => 'About Us','path' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z'], ['route' => 'catering','label' => 'Catering Service','path' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5'], ['route' => 'contact','label' => 'Contact Us','path' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z']] as $nav)
                    <a href="{{ route($nav['route']) }}" @click="menuOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                        <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $nav['path'] }}"/>
                        </svg>
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Account section --}}
            <div class="px-4 pt-2 pb-4 space-y-0.5 border-t border-gray-100 mt-1">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.25em] px-3 pb-1">Account</p>
                @auth
                    <a href="{{ route('my-orders') }}" @click="menuOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                        <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        My Orders
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" @click="menuOpen = false"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors duration-150">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @click="menuOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-white bg-red-600 hover:bg-red-700 transition-colors duration-150">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        Login / Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </nav>
    </div>{{-- end sticky wrapper --}}

    <main>{{ $slot }}</main>

    <x-footer />

    {{-- WhatsApp FAB --}}
    <a href="https://wa.me/{{ $whatsapp }}?text=Hi%20DandeeJuice!%20I%27d%20like%20to%20order."
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 z-30 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-xl transition hover:scale-110"
       title="Chat on WhatsApp">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
        </svg>
    </a>

    @livewire('cart-slide-over')

    @livewireScripts
    @stack('scripts')
</body>
</html>
