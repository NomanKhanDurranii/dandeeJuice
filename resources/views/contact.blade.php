<x-storefront :navCategories="$categories">

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
