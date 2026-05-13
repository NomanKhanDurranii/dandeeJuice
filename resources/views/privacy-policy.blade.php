<x-storefront
    :navCategories="[]"
    title="Privacy Policy – DandeeJuice"
    description="Read DandeeJuice's privacy policy to understand how we collect, use, and protect your personal information when you use our website and services."
>

    <section class="relative w-full overflow-hidden" style="height:280px;">
        <img src="/images/privacy-policy.jpg" alt="Privacy Policy"
             class="absolute inset-0 w-full h-full object-cover object-center">
        <div class="absolute inset-0" style="background:rgba(0,0,0,0.65);"></div>
        <div class="relative z-10 h-full flex items-center justify-center px-4 text-center text-white">
            <div>
                <h1 class="text-4xl font-extrabold mb-2 drop-shadow-lg">Privacy Policy</h1>
                <p class="text-blue-100 drop-shadow">Last updated: {{ date('d F Y') }}</p>
            </div>
        </div>
    </section>

    <div class="max-w-3xl mx-auto px-4 py-14">
        <div class="prose prose-gray max-w-none space-y-8 text-gray-600 leading-relaxed">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-6">

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">1. Information We Collect</h2>
                    <p>When you use DandeeJuice, we collect the following types of information:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                        <li><strong>Account information:</strong> your name, email address, and phone number when you register or complete your profile.</li>
                        <li><strong>Order information:</strong> items ordered, delivery address, payment method, and contact number.</li>
                        <li><strong>Usage data:</strong> pages visited, time spent, and browser/device type for improving our service.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">2. How We Use Your Information</h2>
                    <p class="text-sm">We use your information to:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1 text-sm">
                        <li>Process and deliver your orders.</li>
                        <li>Send you order confirmations and status updates via WhatsApp or email.</li>
                        <li>Respond to your support inquiries.</li>
                        <li>Improve our website, menu, and overall experience.</li>
                        <li>Prevent fraud and ensure platform security.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">3. Data Sharing</h2>
                    <p class="text-sm">We do not sell or rent your personal information to third parties. We only share data with service providers necessary to operate our platform (e.g., email delivery services), and only to the extent required to perform their functions.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">4. Cookies</h2>
                    <p class="text-sm">We use essential session cookies to keep you logged in and maintain your cart. We do not use tracking or advertising cookies.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">5. Data Retention</h2>
                    <p class="text-sm">We retain your account and order data for as long as your account is active, or as required by applicable law. You may request deletion of your data by contacting us.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">6. Your Rights</h2>
                    <p class="text-sm">You have the right to access, correct, or delete your personal data. To exercise these rights, please <a href="{{ route('contact') }}" class="text-blue-700 hover:underline">contact us</a>.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-800 mb-3">7. Contact</h2>
                    <p class="text-sm">For any privacy-related questions, please reach out via our <a href="{{ route('contact') }}" class="text-blue-700 hover:underline">contact page</a> or WhatsApp.</p>
                </section>

            </div>

        </div>
    </div>

</x-storefront>
