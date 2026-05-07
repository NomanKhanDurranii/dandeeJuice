<div>
    @if ($submitted)
        <div class="text-center py-10">
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Review Submitted!</h3>
            <p class="text-gray-500 text-sm">Thank you. Your review will appear after it's approved by our team.</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5" novalidate>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Your Name <span class="text-red-400">*</span>
                    </label>
                    <input
                        wire:model.blur="reviewerName"
                        type="text"
                        placeholder="Full name"
                        {{ auth()->check() ? 'readonly' : '' }}
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                               {{ $errors->has('reviewerName') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}
                               {{ auth()->check() ? 'bg-gray-50 text-gray-500' : '' }}"
                    />
                    @error('reviewerName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input
                        wire:model.blur="reviewerEmail"
                        type="email"
                        placeholder="you@example.com"
                        {{ auth()->check() ? 'readonly' : '' }}
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition
                               {{ $errors->has('reviewerEmail') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}
                               {{ auth()->check() ? 'bg-gray-50 text-gray-500' : '' }}"
                    />
                    @error('reviewerEmail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Star rating picker --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Rating <span class="text-red-400">*</span>
                </label>
                <div
                    x-data="{ hovered: 0, selected: @entangle('rating') }"
                    class="flex gap-1"
                >
                    @foreach (range(1, 5) as $star)
                    <button
                        type="button"
                        @mouseenter="hovered = {{ $star }}"
                        @mouseleave="hovered = 0"
                        @click="selected = {{ $star }}"
                        class="text-3xl leading-none transition focus:outline-none"
                        :class="(hovered || selected) >= {{ $star }} ? 'text-amber-400' : 'text-gray-300'"
                    >★</button>
                    @endforeach
                    <span class="self-center text-xs text-gray-400 ml-2" x-show="selected > 0" x-text="['','Poor','Fair','Good','Very Good','Excellent'][selected]"></span>
                </div>
                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Your Review <span class="text-red-400">*</span>
                </label>
                <textarea
                    wire:model.blur="body"
                    rows="4"
                    placeholder="Tell others what you think about this product…"
                    class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-none
                           {{ $errors->has('body') ? 'border-red-300 bg-red-50' : 'border-gray-300' }}"
                ></textarea>
                <div class="flex justify-between mt-1">
                    @error('body')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @else
                        <span class="text-xs text-gray-400">Minimum 10 characters</span>
                    @enderror
                    <span class="text-xs text-gray-400">{{ strlen($body) }}/1000</span>
                </div>
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="bg-blue-900 hover:bg-blue-800 disabled:opacity-60 text-white font-semibold px-8 py-3 rounded-xl transition active:scale-95"
            >
                <span wire:loading.remove wire:target="submit">Submit Review</span>
                <span wire:loading wire:target="submit">Submitting…</span>
            </button>

        </form>
    @endif
</div>
