<x-storefront :navCategories="$categories">

    {{-- =========== HERO CAROUSEL =========== --}}
    <x-hero-carousel :slides="$slides" />

    {{-- =========== CATEGORY JUMP NAV + SEARCH =========== --}}
    <div
        id="menu"
        x-data="{
            search: '',
            searchOpen: false,
            activeId: null,
            canLeft: false,
            canRight: false,
            stickyH: 140,
            init() {
                this.$nextTick(() => {
                    this.sync();
                    new ResizeObserver(() => this.sync()).observe(this.$refs.rail);
                    document.querySelectorAll('[data-category-section]').forEach(el => {
                        el.dataset.catId = el.id.replace('cat-', '');
                    });
                    const onScroll = () => {
                        const sections = [...document.querySelectorAll('[data-category-section]')];
                        let cur = null;
                        for (const s of sections) {
                            if (s.getBoundingClientRect().top <= this.stickyH + 10) cur = s;
                            else break;
                        }
                        if (cur) this.activate(parseInt(cur.dataset.catId));
                    };
                    window.addEventListener('scroll', onScroll, { passive: true });
                    onScroll();
                });
            },
            sync() {
                const el = this.$refs.rail;
                this.canLeft  = el.scrollLeft > 4;
                this.canRight = el.scrollLeft + el.clientWidth < el.scrollWidth - 4;
            },
            activate(id) {
                if (this.activeId === id) return;
                this.activeId = id;
                const pill = this.$refs.rail.querySelector('[data-pill-id=\'' + id + '\']');
                if (!pill) return;
                const rail = this.$refs.rail;
                const target = pill.offsetLeft - rail.clientWidth / 2 + pill.offsetWidth / 2;
                rail.scrollTo({ left: Math.max(0, target), behavior: 'smooth' });
            },
            goTo(id) {
                const el = document.getElementById('cat-' + id);
                if (!el) return;
                const top = el.getBoundingClientRect().top + window.pageYOffset - this.stickyH;
                window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
                this.activate(id);
            },
            openSearch() {
                this.searchOpen = true;
                this.$nextTick(() => this.$refs.searchInput && this.$refs.searchInput.focus());
            },
            closeSearch() {
                this.searchOpen = false;
                this.search = '';
                document.querySelectorAll('[data-product-card]').forEach(c => c.style.display = '');
                document.querySelectorAll('[data-category-section]').forEach(s => s.style.display = '');
            },
            filterProducts() {
                const q = this.search.toLowerCase().trim();
                document.querySelectorAll('[data-product-card]').forEach(card => {
                    card.style.display = (!q || card.dataset.name.toLowerCase().includes(q)) ? '' : 'none';
                });
                document.querySelectorAll('[data-category-section]').forEach(section => {
                    const visible = [...section.querySelectorAll('[data-product-card]')].some(c => c.style.display !== 'none');
                    section.style.display = visible ? '' : 'none';
                });
            },
            nudgeLeft()  { this.$refs.rail.scrollBy({ left: -260, behavior: 'smooth' }); },
            nudgeRight() { this.$refs.rail.scrollBy({ left:  260, behavior: 'smooth' }); },
        }"
        class="bg-white sticky top-[5.5rem] z-20 shadow-sm border-b border-gray-100"
    >

        {{-- Category row --}}
        <div class="flex items-center gap-1 h-12 px-2">

            {{-- Left arrow --}}
            <button
                @click="canLeft && nudgeLeft()"
                :class="canLeft ? 'text-blue-900 border-blue-200 hover:bg-blue-50 cursor-pointer' : 'text-gray-300 border-gray-100 cursor-default'"
                class="shrink-0 w-8 h-8 rounded-full border bg-white flex items-center justify-center transition-colors shadow-sm"
            >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>

            {{-- Pill rail --}}
            <div
                x-ref="rail"
                @scroll="sync"
                class="flex items-center gap-2 overflow-x-auto flex-1 min-w-0 h-full [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden scroll-smooth"
            >
                @foreach ($categories as $cat)
                    <button
                        type="button"
                        data-pill-id="{{ $cat->id }}"
                        @click="goTo({{ $cat->id }})"
                        :class="activeId === {{ $cat->id }}
                            ? 'bg-brand-gradient text-white border-transparent'
                            : 'bg-white text-gray-700 border-gray-200'"
                        class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap uppercase tracking-wider border shadow-sm transition-all duration-150 hover:bg-brand-gradient hover:text-white hover:border-transparent cursor-pointer"
                    >
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            {{-- Right arrow --}}
            <button
                @click="canRight && nudgeRight()"
                :class="canRight ? 'text-blue-900 border-blue-200 hover:bg-blue-50 cursor-pointer' : 'text-gray-300 border-gray-100 cursor-default'"
                class="shrink-0 w-8 h-8 rounded-full border bg-white flex items-center justify-center transition-colors shadow-sm"
            >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </button>

            {{-- Divider --}}
            <div class="w-px bg-gray-100 self-stretch my-2 mx-1 shrink-0"></div>

            {{-- Search toggle icon --}}
            <button
                @click="searchOpen ? closeSearch() : openSearch()"
                :class="searchOpen ? 'bg-blue-900 text-white border-blue-900' : 'bg-white text-gray-500 border-gray-200 hover:text-blue-900 hover:border-blue-300 hover:bg-blue-50'"
                class="shrink-0 w-8 h-8 rounded-full border flex items-center justify-center transition-all shadow-sm"
                title="Search menu"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </button>

        </div>

        {{-- Expandable search panel --}}
        <div
            x-show="searchOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="border-t border-gray-100 bg-blue-950/[0.03] px-4 sm:px-10 py-3"
            style="display:none"
        >
            <div class="max-w-3xl mx-auto flex items-center gap-3 bg-white rounded-2xl shadow-md border border-gray-200 px-5 py-3 group focus-within:border-blue-300 focus-within:shadow-blue-100 focus-within:shadow-lg transition-all">

                {{-- Search icon --}}
                <svg class="w-5 h-5 text-blue-900 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>

                {{-- Input --}}
                <input
                    x-ref="searchInput"
                    x-model="search"
                    @input="filterProducts"
                    @keydown.escape="closeSearch"
                    type="search"
                    placeholder="Search for anything in our menu…"
                    class="flex-1 min-w-0 text-sm text-gray-700 placeholder-gray-400 bg-transparent"
                    style="outline:none;box-shadow:none;border:none;"
                />

                {{-- Divider --}}
                <div class="w-px h-5 bg-gray-200 shrink-0"></div>

                {{-- Close --}}
                <button
                    @click="closeSearch"
                    class="shrink-0 text-gray-400 hover:text-red-500 transition-colors p-1 rounded-lg hover:bg-red-50"
                    title="Close search"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>

    </div>

    {{-- =========== PRODUCT GRID =========== --}}
    {{-- Static background image; each category gets its own max-w container so the
         mid-section video can bleed full-width naturally between them. --}}
    <div id="products-scroll-section"
         style="background-image: url('/images/background.png'); background-size: cover; background-position: center; background-attachment: fixed;">

        @php $renderedCatCount = 0; @endphp

        @forelse ($categories as $category)
            @if ($category->activeProducts->isNotEmpty())
                @php $renderedCatCount++; @endphp

                {{-- Each category in its own constrained wrapper --}}
                <div class="max-w-6xl mx-auto px-4 {{ $renderedCatCount === 1 ? 'pt-10' : 'pt-14' }}">
                    <section
                        id="cat-{{ $category->id }}"
                        data-category-section
                        style="scroll-margin-top: 9rem"
                    >
                        {{-- Category header --}}
                        <div class="flex items-stretch mb-8 rounded-2xl overflow-hidden shadow-2xl">
                            <div class="bg-brand-gradient flex items-center justify-center px-3 shrink-0">
                                <span class="text-white text-[9px] font-black uppercase tracking-[0.2em]"
                                      style="writing-mode:vertical-rl;transform:rotate(180deg);">MENU</span>
                            </div>
                            <div class="bg-white flex-1 min-w-0 px-5 py-4">
                                <p class="text-[9px] font-extrabold text-red-500 uppercase tracking-[0.35em] mb-1">Our Menu</p>
                                <h2 class="leading-tight font-bold text-gray-900 truncate"
                                    style="font-family:'Playfair Display',Georgia,serif; font-style:italic; font-size:1.6rem; letter-spacing:-0.01em;">
                                    {{ $category->name }}
                                </h2>
                            </div>
                            <div class="bg-gray-900 flex flex-col items-center justify-center px-6 shrink-0 gap-0.5">
                                <span class="text-3xl font-black text-white leading-none">{{ $category->activeProducts->count() }}</span>
                                <span class="text-[9px] uppercase tracking-widest text-gray-300 font-bold">items</span>
                            </div>
                        </div>

                        {{-- Product grid --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($category->activeProducts as $product)
                                @php $thumb = $product->getFirstMediaUrl('images'); @endphp

                                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col"
                                     data-product-card
                                     data-name="{{ $product->name }}">

                                    {{-- Image area with name overlay --}}
                                    <a href="{{ route('product.show', $product->slug) }}" class="relative block overflow-hidden">

                                        <div class="absolute top-0 left-0 right-0 z-10 px-3 pt-3 pb-6 bg-gradient-to-b from-white/80 to-transparent">
                                            <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2">{{ $product->name }}</h3>
                                        </div>

                                        <div class="aspect-square bg-gray-100 overflow-hidden">
                                            @if ($thumb)
                                                <img src="{{ $thumb }}" alt="{{ $product->name }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                     loading="lazy"
                                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                                <div style="display:none" class="w-full h-full items-center justify-center bg-amber-50">
                                                    <svg class="w-12 h-12 text-amber-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/></svg>
                                                </div>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                                    <svg class="w-12 h-12 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    {{-- Bottom: price + CTA --}}
                                    <div class="p-3 flex flex-col gap-2 mt-auto">
                                        @if (($product->active_variants_count ?? 0) > 0)
                                            <p class="text-[11px] text-gray-400 font-medium text-center">{{ $product->active_variants_count }} options available</p>
                                            <a href="{{ route('product.show', $product->slug) }}"
                                               class="w-full bg-brand-gradient bg-brand-gradient-hover text-white text-xs font-bold py-2.5 rounded-xl flex items-center justify-center gap-1.5 shadow-sm active:scale-95 transition-all duration-200">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                                Select Option
                                            </a>
                                        @else
                                            <p class="text-sm font-extrabold text-gray-800 text-center">PKR {{ number_format($product->price) }}</p>
                                            <button
                                                x-data
                                                @click.prevent.stop="Livewire.dispatch('add-to-cart', { id: {{ $product->id }}, qty: 1, variantId: 0 }); $el.classList.add('scale-95'); setTimeout(() => $el.classList.remove('scale-95'), 150)"
                                                class="w-full bg-brand-gradient bg-brand-gradient-hover active:scale-95 text-white text-xs font-bold py-2.5 rounded-xl flex items-center justify-center gap-1.5 shadow-sm hover:shadow-md transition-all duration-200"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                                                Add to Cart
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                {{-- ── Full-width looping video break after the 3rd visible category ── --}}
                @if ($renderedCatCount === 3)
                    <div class="mt-14 overflow-hidden" style="max-height: 340px;">
                        <video
                            autoplay
                            loop
                            muted
                            playsinline
                            class="w-full object-cover"
                            style="height: 34vw; max-height: 340px; min-height: 200px; display: block;"
                        >
                            <source src="/videos/b_final_videomp_.mp4" type="video/mp4">
                        </video>
                    </div>
                @endif

            @endif
        @empty
            <div class="max-w-6xl mx-auto px-4 py-20 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/>
                </svg>
                <p class="text-gray-500 text-lg">Menu is being prepared. Check back soon!</p>
            </div>
        @endforelse

        <div class="pb-14"></div>

    </div>{{-- end #products-scroll-section --}}

    {{-- =========== INFO STRIP =========== --}}
    <section class="mt-10 bg-gray-100">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px">

            <div class="bg-white flex items-center gap-5 px-8 py-8">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-base">Fresh Daily</p>
                    <p class="text-gray-400 text-sm mt-1">100% natural ingredients</p>
                </div>
            </div>

            <div class="bg-white flex items-center gap-5 px-8 py-8">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-base">Fast Delivery</p>
                    <p class="text-gray-400 text-sm mt-1">30–45 min to your door</p>
                </div>
            </div>

            <div class="bg-white flex items-center gap-5 px-8 py-8">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-base">Cash on Delivery</p>
                    <p class="text-gray-400 text-sm mt-1">Pay when it arrives</p>
                </div>
            </div>

            <div class="bg-white flex items-center gap-5 px-8 py-8">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.113 1.523 5.848L.057 23.428a.5.5 0 00.515.572l5.736-1.505A11.96 11.96 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.852 0-3.595-.5-5.104-1.375l-.367-.215-3.803.997.998-3.868-.232-.378A9.936 9.936 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-base">WhatsApp Order</p>
                    <p class="text-gray-400 text-sm mt-1">Chat with us anytime</p>
                </div>
            </div>

        </div>
    </section>

</x-storefront>
