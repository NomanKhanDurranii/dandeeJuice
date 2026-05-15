<x-storefront
    :navCategories="[]"
    :title="$product->name . ' – DandeeJuice'"
    :description="$product->description ? Str::limit(strip_tags($product->description), 155) : 'Order ' . $product->name . ' from DandeeJuice. Fresh, natural, and made daily. Available for home delivery and pickup across Pakistan.'"
>

@php
    use Illuminate\Support\Str;
    $allImages = $product->getMedia('images');
    $primaryImg = $allImages->first()?->getUrl('detail') ?? null;
    $thumbImgs  = $allImages->map(fn ($m) => ['card' => $m->getUrl('detail'), 'thumb' => $m->getUrl('thumb')])->values();
@endphp

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-2 text-xs text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-blue-900 transition">Home</a>
        <span>/</span>
        @if ($product->category)
            <a href="{{ route('home') }}#cat-{{ $product->category->id }}" class="hover:text-blue-900 transition">{{ $product->category->name }}</a>
            <span>/</span>
        @endif
        <span class="text-gray-600 font-medium">{{ $product->name }}</span>
    </div>
</div>

{{-- ===== MAIN PRODUCT SECTION ===== --}}
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

        {{-- ---- LEFT: Image gallery ---- --}}
        <div
            x-data="{
                active: 0,
                images: {{ $thumbImgs->toJson() }}
            }"
            class="lg:sticky top-[5.5rem]"
        >
            {{-- Main image --}}
            <div class="w-full aspect-square bg-blue-50 rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                <template x-if="images.length > 0">
                    <img :src="images[active].card" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </template>
                <template x-if="images.length === 0">
                    <div class="w-full h-full flex items-center justify-center text-blue-200">
                        <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/>
                        </svg>
                    </div>
                </template>
            </div>

            {{-- Thumbnails --}}
            <template x-if="images.length > 1">
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    <template x-for="(img, i) in images" :key="i">
                        <button
                            @click="active = i"
                            :class="active === i ? 'ring-2 ring-blue-900 ring-offset-1' : 'opacity-60 hover:opacity-100'"
                            class="w-16 h-16 rounded-xl overflow-hidden shrink-0 border border-gray-100 transition"
                        >
                            <img :src="img.thumb" alt="" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </template>
        </div>

        {{-- ---- RIGHT: Product info ---- --}}
        @php
            $activeVariants = $product->activeVariants;
            $firstVariant   = $activeVariants->first();
            $variantsJson   = $activeVariants->map(fn($v) => [
                'id'    => $v->id,
                'name'  => $v->name,
                'price' => (float) $v->price,
            ])->toJson();
        @endphp
        <div class="space-y-5" x-data="{
            qty: 1,
            basePrice: {{ (float) $product->price }},
            hasVariants: {{ $activeVariants->isNotEmpty() ? 'true' : 'false' }},
            variants: {{ $variantsJson }},
            selectedVariantId: {{ $firstVariant?->id ?? 0 }},
            get selectedVariant() {
                return this.variants.find(v => v.id === this.selectedVariantId) ?? null;
            },
            get displayPrice() {
                return this.selectedVariant ? this.selectedVariant.price : this.basePrice;
            }
        }">

            {{-- Category + badges --}}
            <div class="flex items-center gap-2 flex-wrap">
                @if ($product->category)
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
                        {{ $product->category->name }}
                    </span>
                @endif
                <span class="text-xs font-semibold text-green-700 bg-green-50 border border-green-100 px-3 py-1 rounded-full">
                    In Stock
                </span>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">{{ $product->name }}</h1>

            {{-- Star rating summary --}}
            @if ($reviewCount > 0)
                <a href="#reviews" class="flex items-center gap-2 w-fit group">
                    <div class="flex">
                        @for ($s = 1; $s <= 5; $s++)
                            @if ($s <= floor($avgRating))
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @elseif ($s - $avgRating < 1)
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><defs><linearGradient id="half{{ $s }}"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs><path fill="url(#half{{ $s }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ $avgRating }}</span>
                    <span class="text-sm text-gray-400 group-hover:text-blue-700 transition">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</span>
                </a>
            @else
                <p class="text-sm text-gray-400">No reviews yet — be the first!</p>
            @endif

            {{-- Price — dynamic when variants exist --}}
            <div class="flex items-baseline gap-3">
                <span class="text-4xl font-extrabold text-red-600">
                    PKR <span x-text="displayPrice.toLocaleString()"></span>
                </span>
            </div>

            <hr class="border-gray-100">

            {{-- Description --}}
            @if ($product->description)
                <div class="prose prose-sm prose-gray max-w-none text-gray-600 leading-relaxed">
                    {!! $product->description !!}
                </div>
            @endif

            {{-- Size Variant Selector (only shown when product has variants) --}}
            <template x-if="hasVariants">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-700">Choose Size</p>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="v in variants" :key="v.id">
                            <button
                                @click="selectedVariantId = v.id"
                                :class="selectedVariantId === v.id
                                    ? 'bg-blue-900 text-white border-blue-900 shadow-md scale-105'
                                    : 'bg-white text-gray-700 border-gray-200 hover:border-blue-300 hover:bg-blue-50'"
                                class="flex flex-col items-center px-5 py-3 rounded-2xl border-2 transition-all duration-150 font-semibold min-w-[90px]"
                            >
                                <span class="text-sm" x-text="v.name"></span>
                                <span
                                    class="text-xs font-bold mt-0.5"
                                    :class="selectedVariantId === v.id ? 'text-blue-200' : 'text-red-600'"
                                    x-text="'PKR ' + Number(v.price).toLocaleString()"
                                ></span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>

            <hr class="border-gray-100">

            {{-- Qty + Add to Cart --}}
            <div class="space-y-3">
                <p class="text-sm font-medium text-gray-700">Quantity</p>

                <div class="flex items-center gap-4">
                    {{-- Qty controls --}}
                    <div class="flex items-center gap-1 border border-gray-200 rounded-xl px-1 py-1">
                        <button
                            @click="qty = Math.max(1, qty - 1)"
                            class="w-9 h-9 rounded-lg hover:bg-gray-100 transition flex items-center justify-center text-gray-600 font-bold"
                            :disabled="qty <= 1"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                        </button>
                        <span class="w-10 text-center font-bold text-gray-800" x-text="qty"></span>
                        <button
                            @click="qty = Math.min(20, qty + 1)"
                            class="w-9 h-9 rounded-lg hover:bg-gray-100 transition flex items-center justify-center text-gray-600 font-bold"
                            :disabled="qty >= 20"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>

                    {{-- Add to cart --}}
                    <button
                        @click="Livewire.dispatch('add-to-cart', {
                            id: {{ $product->id }},
                            qty: qty,
                            variantId: hasVariants ? selectedVariantId : 0
                        })"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded-xl transition active:scale-95 flex items-center justify-center gap-2 shadow-sm"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                        </svg>
                        Add to Cart
                    </button>
                </div>

                {{-- Running total --}}
                <p class="text-xs text-gray-400 text-center">
                    Total: <span class="font-semibold text-gray-600">PKR <span x-text="(displayPrice * qty).toLocaleString()"></span></span>
                </p>
            </div>

            {{-- Info chips --}}
            <div class="flex flex-wrap gap-2 pt-2">
                <div class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-full">
                    <svg class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Fresh daily
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-full">
                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    30–45 min delivery
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-full">
                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                    Cash on delivery
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ===== REVIEWS SECTION ===== --}}
<div id="reviews" class="bg-white border-t border-gray-100 mt-4">
    <div class="max-w-6xl mx-auto px-4 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Rating overview --}}
            <div class="lg:col-span-1">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Customer Reviews</h2>

                @if ($reviewCount > 0)
                    <div class="text-center mb-6">
                        <div class="text-6xl font-extrabold text-gray-900">{{ $avgRating }}</div>
                        <div class="flex justify-center gap-0.5 my-2">
                            @for ($s = 1; $s <= 5; $s++)
                                <svg class="w-6 h-6 {{ $s <= round($avgRating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500">Based on {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
                    </div>

                    {{-- Bar chart --}}
                    <div class="space-y-2">
                        @foreach ($ratingDistribution as $star => $count)
                        @php $pct = $reviewCount > 0 ? round($count / $reviewCount * 100) : 0; @endphp
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-4 text-right text-gray-500 shrink-0">{{ $star }}</span>
                            <svg class="w-3 h-3 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-amber-400 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="w-7 text-gray-400 shrink-0">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="flex justify-center gap-0.5 mb-3">
                            @for ($s = 1; $s <= 5; $s++)
                                <svg class="w-8 h-8 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-500 font-medium">No reviews yet</p>
                        <p class="text-gray-400 text-sm mt-1">Be the first to share your experience!</p>
                    </div>
                @endif
            </div>

            {{-- Review list --}}
            <div class="lg:col-span-2 space-y-5">
                @forelse ($product->approvedReviews as $review)
                    <div class="border border-gray-100 rounded-2xl p-5 bg-gray-50">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-900 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $review->reviewer_name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $review->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-0.5 shrink-0">
                                @for ($s = 1; $s <= 5; $s++)
                                    <svg class="w-4 h-4 {{ $s <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $review->body }}</p>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400 text-sm">
                        No approved reviews yet. Reviews appear here once approved by our team.
                    </div>
                @endforelse
            </div>

        </div>

        {{-- ===== WRITE A REVIEW ===== --}}
        <div class="mt-12 border-t border-gray-100 pt-10">
            <div class="max-w-2xl">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Write a Review</h2>
                <p class="text-gray-400 text-sm mb-6">Reviews are moderated and will appear after approval.</p>
                @livewire('review-form', ['productId' => $product->id])
            </div>
        </div>

    </div>
</div>

{{-- ===== RELATED PRODUCTS ===== --}}
@if ($relatedProducts->isNotEmpty())
<div class="max-w-6xl mx-auto px-4 py-12">
    <h2 class="text-xl font-bold text-gray-800 mb-6">You Might Also Like</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($relatedProducts as $rp)
        @php $rpThumb = $rp->getFirstMediaUrl('images', 'thumb'); @endphp
        <a
            href="{{ route('product.show', $rp->slug) }}"
            class="group bg-white rounded-2xl border border-gray-100 hover:border-blue-200 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col"
        >
            <div class="aspect-square bg-blue-50 overflow-hidden">
                @if ($rpThumb)
                    <img src="{{ $rpThumb }}" alt="{{ $rp->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                @else
                    <div class="w-full h-full flex items-center justify-center text-blue-200">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1 1 .316 2.702-1.067 2.702H4.865c-1.383 0-2.067-1.702-1.067-2.702L5 14.5"/></svg>
                    </div>
                @endif
            </div>
            <div class="p-3 flex flex-col flex-1">
                <p class="font-semibold text-gray-800 text-sm leading-snug line-clamp-2 mb-1">{{ $rp->name }}</p>
                <p class="font-bold text-red-600 text-sm mt-auto">PKR {{ number_format($rp->price) }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

</x-storefront>
