<div>
    @if ($submitted)
        {{-- Success state --}}
        <div class="text-center py-10">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Message Sent!</h3>
            <p class="text-gray-500 mb-6">We'll get back to you within 24 hours. You can also reach us instantly on WhatsApp.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button wire:click="resetForm" class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                    Send another message
                </button>
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '923001234567') }}"
                   target="_blank"
                   class="px-6 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition text-sm font-medium">
                    Chat on WhatsApp
                </a>
            </div>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5" novalidate>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Name <span class="text-red-400">*</span>
                    </label>
                    <input
                        wire:model.blur="name"
                        type="text"
                        placeholder="Your full name"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                               {{ $errors->has('name') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                    />
                    @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input
                        wire:model.blur="email"
                        type="email"
                        placeholder="you@example.com"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                               {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                    />
                    @error('email') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Phone <span class="text-red-400">*</span>
                    </label>
                    <input
                        wire:model.blur="phone"
                        type="tel"
                        placeholder="03001234567"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                               {{ $errors->has('phone') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                    />
                    @error('phone') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Subject <span class="text-red-400">*</span>
                    </label>
                    <input
                        wire:model.blur="subject"
                        type="text"
                        placeholder="e.g. Bulk order inquiry"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                               {{ $errors->has('subject') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                    />
                    @error('subject') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Message <span class="text-red-400">*</span>
                </label>
                <textarea
                    wire:model.blur="message"
                    rows="5"
                    placeholder="Tell us how we can help you..."
                    class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-none
                           {{ $errors->has('message') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                ></textarea>
                <div class="flex justify-between mt-1">
                    @error('message')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @else
                        <span></span>
                    @enderror
                    <span class="text-xs text-gray-400" x-data x-text="($wire.message ?? '').length + '/2000'"></span>
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 active:scale-95 text-white font-semibold py-3.5 rounded-xl transition"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="submit">Send Message</span>
                <span wire:loading wire:target="submit">Sending…</span>
            </button>

        </form>
    @endif
</div>
