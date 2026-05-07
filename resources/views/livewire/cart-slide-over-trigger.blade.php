<button
    wire:click="openCart"
    class="relative flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-900 font-medium px-3 py-1.5 rounded-full transition"
>
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
    </svg>
    <span class="text-sm">Cart</span>
    @if ($count > 0)
        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
            {{ $count > 9 ? '9+' : $count }}
        </span>
    @endif
</button>
