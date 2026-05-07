<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome!</h1>
            <p class="text-gray-400 text-sm mt-1">Just one more step — tell us your name.</p>
        </div>

        @if ($error)
            <div class="bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl p-3 mb-4">
                {{ $error }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Your Name <span class="text-red-400">*</span></label>
                <input
                    wire:model="name"
                    type="text"
                    placeholder="e.g. Sara Ahmed"
                    autocomplete="name"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                    autofocus
                />
                @error('name')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Phone Number
                    <span class="text-gray-400 font-normal">(optional — for delivery updates)</span>
                </label>
                <input
                    wire:model="phone"
                    type="tel"
                    placeholder="03001234567"
                    autocomplete="tel"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                />
                @error('phone')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 active:scale-95 text-white font-semibold py-3 rounded-xl transition mt-2"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Let's go!</span>
                <span wire:loading>Saving…</span>
            </button>

        </form>

    </div>
</div>
