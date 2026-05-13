<x-storefront
    :navCategories="$categories"
    title="About Us – DandeeJuice | Our Story & Mission"
    description="Learn about DandeeJuice – our passion for fresh, natural juices and shakes. We use 100% real fruits with no artificial flavours or preservatives. Taste the difference."
>

    {{-- Hero Banner --}}
    <section class="relative w-full overflow-hidden" style="height:380px;">
        <img src="/images/about.jpg" alt="About DandeeJuice"
             class="absolute inset-0 w-full h-full object-cover object-center">
        <div class="absolute inset-0" style="background:rgba(0,0,0,0.65);"></div>
        <div class="relative z-10 h-full flex items-center justify-center px-4 text-center text-white">
            <div>
                <span class="inline-block text-xs font-bold tracking-widest text-blue-300 uppercase mb-4">Our Story</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold mb-5 leading-tight drop-shadow-lg">Made Fresh.<br>Served with Love.</h1>
                <p class="text-blue-100 text-lg max-w-xl mx-auto drop-shadow">DandeeJuice started with a simple belief — everyone deserves a refreshing, healthy drink made from real fruit, not concentrates.</p>
            </div>
        </div>
    </section>

    {{-- Story section --}}
    <section class="max-w-5xl mx-auto px-4 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <div class="w-full rounded-2xl overflow-hidden shadow-lg">
                <img src="/images/dandeeStory.jpg" alt="How DandeeJuice started"
                     class="w-full h-full object-cover object-center"
                     style="aspect-ratio:4/3;">
            </div>
        </div>
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">How it started</h2>
            <p class="text-gray-500 leading-relaxed mb-4">DandeeJuice was born out of a passion for wholesome, natural food. We noticed that the market was flooded with sugary, artificial drinks that did more harm than good. So we decided to change that.</p>
            <p class="text-gray-500 leading-relaxed mb-4">We source the freshest seasonal fruit every single morning, and every glass is pressed to order — no pre-made bottles, no concentrates, no shortcuts.</p>
            <p class="text-gray-500 leading-relaxed">Today, we serve hundreds of happy customers daily through home delivery and pickup, and we continue to grow — one fresh glass at a time.</p>
        </div>
    </section>

    {{-- Values --}}
    <section class="bg-blue-900 text-white py-14 px-4">
        @php
            $values = [
                ['icon' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5', 'title' => '100% Natural', 'desc' => 'No concentrates, no artificial flavours. Just real fruit, real taste.'],
                ['icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Quality First', 'desc' => 'Every order is checked before it leaves our kitchen. No compromises.'],
                ['icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12', 'title' => 'Fast Delivery', 'desc' => 'Your order arrives fresh and cold within 30–45 minutes.'],
                ['icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z', 'title' => 'Community Love', 'desc' => 'We give back to our community through partnerships and fresh donations.'],
                ['icon' => 'M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z', 'title' => 'Fresh Daily', 'desc' => 'We start every morning with freshly sourced ingredients. No leftovers.'],
                ['icon' => 'M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155', 'title' => 'Always Reachable', 'desc' => 'Our WhatsApp support is available throughout business hours.'],
            ];
        @endphp
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold">Our Values</h2>
                <p class="text-blue-300 mt-2">What we stand for, every single day.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($values as $v)
                <div class="bg-blue-800/50 border border-blue-700 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $v['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-white mb-1.5">{{ $v['title'] }}</h3>
                    <p class="text-blue-300 text-sm">{{ $v['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 px-4 text-center">
        <div class="max-w-xl mx-auto">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Ready to taste the difference?</h2>
            <p class="text-gray-500 mb-8">Browse our full menu and have fresh juice delivered to your doorstep in under an hour.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('home') }}#menu"
                   class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-xl transition">
                    Browse Menu
                </a>
                <a href="{{ route('contact') }}"
                   class="border-2 border-blue-900 text-blue-900 hover:bg-blue-900 hover:text-white font-bold px-8 py-3.5 rounded-xl transition">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

</x-storefront>
