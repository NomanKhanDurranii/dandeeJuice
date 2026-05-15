@props(['slides' => collect()])

@php $count = $slides->count(); @endphp

<div
    x-data="{
        cur: 0,
        count: {{ $count }},
        timer: null,
        paused: false,
        go(n) { this.cur = ((n % this.count) + this.count) % this.count; },
        next() { this.go(this.cur + 1); },
        prev() { this.go(this.cur - 1); },
        startTimer() {
            this.timer = setInterval(() => { if (!this.paused) this.next(); }, 5000);
        }
    }"
    x-init="startTimer()"
    @mouseenter="paused = true"
    @mouseleave="paused = false"
    class="relative w-full overflow-hidden bg-blue-900"
    style="aspect-ratio: 16 / 5; min-height: 220px;"
>

    @if ($count > 0)

        {{-- ── Slides ── --}}
        @foreach ($slides as $i => $slide)
            @php $img = $slide->getFirstMediaUrl('slide', 'banner') ?: $slide->getFirstMediaUrl('slide'); @endphp
            <div
                x-show="cur === {{ $i }}"
                x-transition:enter="transition-opacity duration-700 ease-in-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-700 ease-in-out"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0"
            >
                @if ($img)
                    <img src="{{ $img }}" alt="{{ $slide->title }}"
                         class="w-full h-full object-cover"
                         @if($i === 0) fetchpriority="high" @else loading="lazy" @endif>
                @else
                    {{-- Placeholder gradient if no image uploaded yet --}}
                    <div class="w-full h-full bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700"></div>
                @endif

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/20 to-transparent"></div>

                {{-- Text content --}}
                @if ($slide->title || $slide->subtitle || $slide->button_text)
                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-6xl mx-auto px-6 md:px-10 w-full">
                            <div class="max-w-xl">
                                @if ($slide->title)
                                    <h2 class="text-white text-3xl md:text-5xl font-extrabold leading-tight mb-3 drop-shadow">
                                        {{ $slide->title }}
                                    </h2>
                                @endif
                                @if ($slide->subtitle)
                                    <p class="text-blue-100 text-base md:text-lg mb-6 drop-shadow">
                                        {{ $slide->subtitle }}
                                    </p>
                                @endif
                                @if ($slide->button_text)
                                    <a href="{{ $slide->button_url ?: '#menu' }}"
                                       class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold px-7 py-3 rounded-full transition shadow-lg">
                                        {{ $slide->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        {{-- ── Arrows ── --}}
        @if ($count > 1)
            <button @click="prev()"
                    class="absolute left-3 top-1/2 -translate-y-1/2 z-10 bg-black/30 hover:bg-black/50 text-white rounded-full w-10 h-10 flex items-center justify-center transition backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="next()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 z-10 bg-black/30 hover:bg-black/50 text-white rounded-full w-10 h-10 flex items-center justify-center transition backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- ── Dots ── --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                @foreach ($slides as $i => $slide)
                    <button @click="go({{ $i }})"
                            :class="cur === {{ $i }} ? 'bg-white w-6' : 'bg-white/40 w-2.5'"
                            class="h-2.5 rounded-full transition-all duration-300">
                    </button>
                @endforeach
            </div>
        @endif

    @else

        {{-- ── Fallback when no slides are configured ── --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 flex items-center">
            <div class="max-w-6xl mx-auto px-6 md:px-10 w-full">
                <div class="max-w-2xl">
                    <p class="text-blue-300 font-medium tracking-widest uppercase text-xs mb-3">Fresh Daily · Made with Love</p>
                    <h1 class="text-white text-4xl md:text-6xl font-extrabold leading-tight mb-4">Pure Juices,<br>Pure Joy.</h1>
                    <p class="text-blue-200 text-lg mb-7 max-w-lg">
                        Cold-pressed, freshly made juices and shakes — delivered to your door or ready for pickup.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="#menu" class="bg-red-600 hover:bg-red-700 text-white font-bold px-7 py-3 rounded-full transition shadow-lg">
                            Browse Menu
                        </a>
                        @if (session('order_type') === 'delivery')
                            <span class="bg-white/15 backdrop-blur text-white font-medium px-5 py-3 rounded-full text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                                Delivering to: {{ session('delivery_zone_name', '') }}
                            </span>
                        @elseif (session('order_type') === 'pickup')
                            <span class="bg-white/15 backdrop-blur text-white font-medium px-5 py-3 rounded-full text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Takeaway order
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endif

</div>
