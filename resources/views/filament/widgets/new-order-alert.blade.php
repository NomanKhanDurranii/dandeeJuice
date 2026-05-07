<div
    wire:poll.30s="checkForNewOrders"
    x-data="{
        playBeep() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 880;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0.3, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.6);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime + 0.6);
            } catch(e) {}
        }
    }"
    @new-orders-detected.window="playBeep()"
>
    @if ($newOrderCount > 0)
    <div class="rounded-xl bg-amber-50 border-2 border-amber-300 px-5 py-4 flex items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="animate-bounce">
                <svg class="w-7 h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-amber-800">
                    {{ $newOrderCount }} new {{ Str::plural('order', $newOrderCount) }} just came in!
                </p>
                <p class="text-sm text-amber-600">Check the Orders section to confirm them.</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('filament.admin.resources.orders.index') }}"
               class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                View Orders
            </a>
            <button wire:click="dismiss"
                    class="text-amber-400 hover:text-amber-600 p-1 transition" title="Dismiss">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @else
    {{-- Invisible placeholder so the widget stays mounted for polling --}}
    <div class="hidden"></div>
    @endif
</div>
