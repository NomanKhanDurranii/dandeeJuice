<x-storefront
    :navCategories="$categories"
    title="Contact Us – DandeeJuice | Get in Touch"
    description="Have a question or feedback? Contact DandeeJuice via WhatsApp, phone, or our online form. Find our branch locations and business hours here."
>

    {{-- Hero Banner --}}
    <section class="relative w-full overflow-hidden" style="height:320px;">
        <img src="/images/contact.jpg" alt="Contact DandeeJuice"
             class="absolute inset-0 w-full h-full object-cover object-center">
        <div class="absolute inset-0" style="background:rgba(0,0,0,0.65);"></div>
        <div class="relative z-10 h-full flex items-center justify-center px-4 text-center text-white">
            <div>
                <h1 class="text-4xl font-extrabold mb-3 drop-shadow-lg">Get in Touch</h1>
                <p class="text-blue-100 text-lg drop-shadow">Questions, bulk orders, or just want to say hi — we'd love to hear from you.</p>
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 py-14">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Contact info sidebar --}}
            <div class="space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Contact Info</h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-green-700" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700 text-sm">WhatsApp</p>
                                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '923001234567') }}"
                                   target="_blank"
                                   class="text-sm text-green-600 hover:text-green-700 transition">
                                    +{{ \App\Models\Setting::get('whatsapp_number', '923001234567') }}
                                </a>
                            </div>
                        </div>

                        @if (\App\Models\Setting::get('store_address'))
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700 text-sm">Pickup Location</p>
                                <p class="text-sm text-gray-500">{{ \App\Models\Setting::get('store_address') }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-xl shrink-0">⏰</div>
                            <div>
                                <p class="font-semibold text-gray-700 text-sm">Hours</p>
                                <p class="text-sm text-gray-500">Daily · 10:00 AM – 10:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick WhatsApp CTA --}}
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '923001234567') }}?text=Hi%20DandeeJuice!"
                   target="_blank"
                   class="flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white px-5 py-3.5 rounded-xl transition font-semibold text-sm">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                    </svg>
                    Chat with us now
                </a>
            </div>

            {{-- Contact form --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Send us a Message</h2>
                @livewire('contact-form')
            </div>

        </div>

        {{-- ═══════════════════════════════════════════════════════
             OUR BRANCHES
        ════════════════════════════════════════════════════════ --}}
        @if ($branches->isNotEmpty())

        {{-- Section divider --}}
        <div class="mt-20 mb-16 flex items-center gap-5">
            <div class="flex-1 h-px bg-gray-200"></div>
            <div class="flex items-center gap-2 shrink-0 px-2">
                <div class="w-1.5 h-1.5 rounded-full bg-red-400"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-brand-gradient" style="background: linear-gradient(135deg, #22f24f 0%, #064a01 100%);"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-red-400"></div>
            </div>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <div>

            {{-- Section header --}}
            <div class="text-center mb-12">
                <p class="text-xs font-black uppercase tracking-[0.3em] text-red-500 mb-3">Find Us Near You</p>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4"
                    style="font-family:'Playfair Display',Georgia,serif; font-style:italic; letter-spacing:-0.01em;">
                    Our Locations
                </h2>
                <div class="flex items-center justify-center gap-3">
                    <div class="h-px w-16 bg-gradient-to-r from-transparent to-green-400"></div>
                    <div class="w-2 h-2 rounded-full bg-brand-gradient"></div>
                    <div class="h-px w-16 bg-gradient-to-l from-transparent to-green-400"></div>
                </div>
                <p class="mt-4 text-gray-500 text-sm max-w-md mx-auto leading-relaxed">
                    Visit any of our branches for fresh juices, shakes, and pick-up orders. Each branch has its own direct contact.
                </p>
            </div>

            {{-- Branch cards grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($branches as $index => $branch)
                <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">

                    {{-- Top gradient accent --}}
                    <div class="h-1 bg-brand-gradient"></div>

                    {{-- Card body --}}
                    <div class="p-6 flex flex-col flex-1">

                        {{-- Branch number badge + name --}}
                        <div class="flex items-start gap-4 mb-5">
                            <div class="shrink-0 w-11 h-11 rounded-xl bg-brand-gradient flex items-center justify-center shadow-sm">
                                <span class="text-white font-black text-base leading-none">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="min-w-0 pt-0.5">
                                <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $branch->name }}</h3>
                                <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-bold uppercase tracking-widest text-green-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                    Open Daily
                                </span>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="flex items-start gap-3 mb-4">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center mt-0.5">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $branch->address }}</p>
                        </div>

                        {{-- Phone --}}
                        @if ($branch->phone)
                        <div class="flex items-center gap-3 mb-5">
                            <div class="shrink-0 w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                            </div>
                            <a href="tel:{{ preg_replace('/\s+/', '', $branch->phone) }}"
                               class="text-sm font-semibold text-gray-700 hover:text-green-700 transition">
                                {{ $branch->phone }}
                            </a>
                        </div>
                        @else
                        <div class="mb-5"></div>
                        @endif

                        {{-- Spacer to push actions to bottom --}}
                        <div class="flex-1"></div>

                        {{-- Divider --}}
                        <div class="h-px bg-gray-100 mb-4"></div>

                        {{-- Action buttons --}}
                        <div class="flex gap-2">
                            {{-- WhatsApp --}}
                            @if ($branch->phone || $branch->whatsapp)
                            <a href="{{ $branch->waUrl('Hi DandeeJuice! I\'d like to know more about your ' . $branch->name . '.') }}"
                               target="_blank"
                               class="flex-1 flex items-center justify-center gap-1.5 bg-green-50 hover:bg-green-100 text-green-700 font-semibold text-xs py-2.5 rounded-xl transition">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                                </svg>
                                WhatsApp
                            </a>
                            @endif

                            {{-- Get Directions --}}
                            <a href="{{ $branch->mapsUrl() }}"
                               target="_blank"
                               class="flex-1 flex items-center justify-center gap-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 font-semibold text-xs py-2.5 rounded-xl transition">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c-.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                                </svg>
                                Directions
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @endif

        {{-- FAQ Section --}}
        @if ($faqs->isNotEmpty())
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto space-y-3">
                @foreach ($faqs as $faq)
                <div
                    x-data="{ open: false }"
                    class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm"
                >
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-6 py-4 text-left gap-4"
                    >
                        <span class="font-semibold text-gray-800 text-sm">{{ $faq->question }}</span>
                        <svg :class="open ? 'rotate-180' : ''"
                             class="w-5 h-5 text-gray-400 transition-transform shrink-0"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $faq->answer }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</x-storefront>
