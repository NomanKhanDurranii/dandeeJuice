<x-storefront
    :navCategories="[]"
    title="Refund Policy – DandeeJuice"
    description="Learn about DandeeJuice's refund and return policy. We're committed to your satisfaction – find out how to request a refund or report an issue with your order."
>

    <section class="relative w-full overflow-hidden" style="height:280px;">
        <img src="/images/refund-policy.jpg" alt="Refund Policy"
             class="absolute inset-0 w-full h-full object-cover object-center">
        <div class="absolute inset-0" style="background:rgba(0,0,0,0.65);"></div>
        <div class="relative z-10 h-full flex items-center justify-center px-4 text-center text-white">
            <div>
                <h1 class="text-4xl font-extrabold mb-2 drop-shadow-lg">Refund Policy</h1>
                <p class="text-blue-100 drop-shadow">Last updated: {{ date('d F Y') }}</p>
            </div>
        </div>
    </section>

    <div class="max-w-3xl mx-auto px-4 py-14">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-6 text-gray-600 leading-relaxed text-sm">

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Our Commitment</h2>
                <p>At DandeeJuice, your satisfaction is our priority. Because we deal in freshly made food and beverages, our refund policy is designed to be fair while accounting for the perishable nature of our products.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Eligible Refund Situations</h2>
                <p>We will offer a full refund or replacement in the following situations:</p>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>You received the wrong item(s).</li>
                    <li>The product was damaged, spilled, or tampered with upon delivery.</li>
                    <li>Your order was never delivered and was marked as delivered.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Non-Refundable Situations</h2>
                <p>Refunds will not be issued in the following cases:</p>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Change of mind after the order has been prepared.</li>
                    <li>Incorrect delivery address provided by the customer.</li>
                    <li>The customer was unavailable to receive the order after multiple attempts.</li>
                    <li>Customisation requests that were fulfilled as instructed.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-3">How to Request a Refund</h2>
                <p>To request a refund, please contact us within <strong>2 hours</strong> of delivery via:</p>
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li><a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '923001234567') }}" target="_blank" class="text-blue-700 hover:underline">WhatsApp</a> — fastest response</li>
                    <li><a href="{{ route('contact') }}" class="text-blue-700 hover:underline">Contact form</a> — for detailed inquiries</li>
                </ul>
                <p class="mt-2">Please include your order number and a brief description of the issue. Photos help us resolve issues faster.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Refund Processing</h2>
                <p>Approved refunds for Cash on Delivery orders are returned via EasyPaisa, JazzCash, or bank transfer within <strong>1–3 business days</strong>. We will contact you to confirm your preferred method.</p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Questions?</h2>
                <p>If you have any questions about this policy, please <a href="{{ route('contact') }}" class="text-blue-700 hover:underline">contact us</a> or reach us on WhatsApp.</p>
            </section>

        </div>
    </div>

</x-storefront>
