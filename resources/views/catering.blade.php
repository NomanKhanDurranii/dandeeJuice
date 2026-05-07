<x-storefront :navCategories="$categories">

@php
    $whatsapp = \App\Models\Setting::get('whatsapp_number', '923001234567');

    $features = [
        ['bg' => 'bg-red-50',    'color' => 'text-red-600',    'title' => 'Pressed Fresh On-Site',      'desc' => 'We bring our setup to your venue and press juices fresh in front of your guests — a spectacle in itself.'],
        ['bg' => 'bg-blue-50',   'color' => 'text-blue-700',   'title' => 'Fully Customisable Menu',     'desc' => 'Choose from dozens of seasonal juice, shake, and mocktail options. We tailor the menu to your theme.'],
        ['bg' => 'bg-green-50',  'color' => 'text-green-600',  'title' => '100% Natural Ingredients',   'desc' => 'No syrups, no powders, no shortcuts. Every glass is made from fresh fruit and pure ingredients.'],
        ['bg' => 'bg-amber-50',  'color' => 'text-amber-600',  'title' => 'Any Scale',                  'desc' => 'We cater for 10-person private dinners all the way up to 500+ guest weddings and corporate events.'],
        ['bg' => 'bg-purple-50', 'color' => 'text-purple-600', 'title' => 'Branded Presentation',       'desc' => 'Elegant serving stations, branded cups, and beautiful garnishes that match your event\'s aesthetic.'],
        ['bg' => 'bg-pink-50',   'color' => 'text-pink-600',   'title' => 'Dedicated Event Manager',    'desc' => 'A dedicated point of contact manages your catering from planning through to the last glass served.'],
    ];

    $eventTypes = ['Weddings', 'Birthday Parties', 'Corporate Events', 'Graduations', 'Family Gatherings', 'Dawats & Mehndis'];

    $steps = [
        ['num' => '01', 'title' => 'Submit a Request',      'desc' => 'Fill in the enquiry form below or chat with us on WhatsApp with your event details.'],
        ['num' => '02', 'title' => 'Get a Custom Quote',    'desc' => 'We will send you a tailored menu and pricing proposal within 24 hours.'],
        ['num' => '03', 'title' => 'Confirm & Plan',        'desc' => 'Finalise the menu, set-up details, and timing. We handle everything.'],
        ['num' => '04', 'title' => 'We Show Up & Deliver',  'desc' => 'Sit back and enjoy your event. We will handle the drinks, setup, and cleanup.'],
    ];
@endphp

{{-- ===== HERO ===== --}}
<section class="relative overflow-hidden text-white" style="min-height:480px;">
    <img src="/images/about.jpg" alt="DandeeJuice Catering"
         class="absolute inset-0 w-full h-full object-cover object-center">
    <div class="absolute inset-0" style="background:rgba(0,0,0,0.65);"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 py-24 text-center">
        <span class="inline-block text-xs font-bold tracking-widest text-red-400 uppercase mb-4 bg-red-400/10 px-3 py-1 rounded-full border border-red-400/20">
            Catering Service
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
            Elevate Your Event with<br>
            <span class="text-red-400">Fresh, Artisan Beverages</span>
        </h1>
        <p class="text-blue-200 text-lg sm:text-xl max-w-2xl mx-auto mb-10">
            From intimate gatherings to grand weddings — DandeeJuice delivers a premium fresh-juice experience that leaves your guests talking long after the event.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/{{ $whatsapp }}?text=Hi%20DandeeJuice!%20I%20am%20interested%20in%20your%20catering%20service."
               target="_blank"
               class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-400 text-white font-bold px-8 py-4 rounded-2xl text-base transition shadow-lg shadow-green-900/30">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                Chat on WhatsApp Now
            </a>
            <a href="#catering-form"
               class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold px-8 py-4 rounded-2xl text-base transition border border-white/20">
                Get a Quote
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- WhatsApp info bar --}}
<div class="bg-green-600 text-white py-3 px-4 text-center text-sm font-semibold">
    <span class="opacity-80">Need a quick answer?</span>
    &nbsp;
    <a href="https://wa.me/{{ $whatsapp }}?text=Hi%20DandeeJuice!%20Catering%20inquiry."
       target="_blank"
       class="underline underline-offset-2 hover:opacity-80 transition">
        Message us on WhatsApp for an instant response →
    </a>
</div>

{{-- ===== WHY CHOOSE US ===== --}}
<section class="max-w-6xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-800">Why DandeeJuice for Your Event?</h2>
        <p class="text-gray-500 mt-2 max-w-xl mx-auto">We go beyond just drinks. We deliver a complete fresh-beverage experience your guests will love.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($features as $f)
        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 {{ $f['bg'] }} rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 {{ $f['color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800 mb-2">{{ $f['title'] }}</h3>
            <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== EVENT TYPES ===== --}}
<section class="bg-blue-900 text-white py-16 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold">Events We Cater For</h2>
            <p class="text-blue-300 mt-2">No event is too big or too small.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
            @foreach ($eventTypes as $evt)
            <div class="bg-blue-800/60 border border-blue-700 rounded-2xl py-5 px-3">
                <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-blue-100">{{ $evt }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="max-w-5xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-gray-800">How It Works</h2>
        <p class="text-gray-500 mt-2">Simple, seamless, stress-free.</p>
    </div>
    <div class="relative">
        <div class="hidden lg:block absolute top-8 left-[12.5%] right-[12.5%] h-0.5 bg-gray-100 z-0"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
            @foreach ($steps as $step)
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-900 text-white rounded-full flex items-center justify-center text-xl font-extrabold mx-auto mb-4 shadow-lg">
                    {{ $step['num'] }}
                </div>
                <h3 class="font-bold text-gray-800 mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== WHATSAPP BANNER ===== --}}
<section class="max-w-6xl mx-auto px-4 pb-8">
    <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-lg shadow-green-200">
        <div>
            <p class="text-xs font-bold tracking-widest text-green-100 uppercase mb-1">Fastest Response</p>
            <h3 class="text-2xl font-extrabold text-white">Prefer to chat directly?</h3>
            <p class="text-green-100 text-sm mt-1">Get an instant quote and availability check via WhatsApp.</p>
        </div>
        <a href="https://wa.me/{{ $whatsapp }}?text=Hi%20DandeeJuice!%20I%27d%20like%20to%20discuss%20catering%20for%20my%20event."
           target="_blank"
           class="shrink-0 inline-flex items-center gap-3 bg-white text-green-700 font-bold px-7 py-4 rounded-2xl hover:bg-green-50 transition text-sm shadow-md">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
            WhatsApp Us Now
        </a>
    </div>
</section>

{{-- ===== CONTACT FORM ===== --}}
<section id="catering-form" class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

        {{-- Info sidebar --}}
        <div class="lg:col-span-2 space-y-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Request a Quote</h2>
                <p class="text-gray-500 text-sm leading-relaxed">Fill in the form and we will get back to you with a personalised catering proposal within 24 hours.</p>
            </div>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 text-sm">Response Time</p>
                        <p class="text-gray-400 text-xs">Within 24 hours by email, or instantly via WhatsApp</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 text-sm">WhatsApp</p>
                        <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="text-green-600 text-xs hover:underline">+{{ $whatsapp }}</a>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 text-sm">Free Consultation</p>
                        <p class="text-gray-400 text-xs">No commitment required to get a quote</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Event Details</h3>
            @livewire('catering-form')
        </div>

    </div>
</section>

</x-storefront>
