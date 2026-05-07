<x-storefront :navCategories="[]">
    <div class="max-w-4xl mx-auto px-4 py-16 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-500">Your orders and account details will appear here.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-block bg-red-600 text-white px-6 py-2.5 rounded-full font-semibold hover:bg-red-700 transition">
            Back to Menu
        </a>
    </div>
</x-storefront>
