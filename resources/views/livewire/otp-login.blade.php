<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-8">

        {{-- Brand --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block mb-2 text-3xl font-bold text-blue-900 tracking-tight">
                DandeeJuice
            </a>
            <p class="text-gray-400 text-sm">
                {{ $otpSent ? 'Enter the code we sent you' : 'Sign in or create an account' }}
            </p>
        </div>

        {{-- Error --}}
        @if ($error)
            <div class="bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl p-3 mb-4 flex gap-2 items-start">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <span>{{ $error }}</span>
            </div>
        @endif

        {{-- Success --}}
        @if ($successMessage && ! $devOtp)
            <div class="bg-green-50 border border-green-100 text-green-700 text-sm rounded-xl p-3 mb-4 flex gap-2 items-start">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $successMessage }}</span>
            </div>
        @endif

        {{-- ===== DEV MODE OTP BANNER ===== --}}
        @if ($devOtp)
            <div class="bg-amber-50 border-2 border-dashed border-amber-300 rounded-xl p-4 mb-5 text-center">
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wide mb-1">
                    Dev Mode — SMTP not configured
                </p>
                <p class="text-xs text-amber-500 mb-3">Configure <code class="bg-amber-100 px-1 rounded">MAIL_USERNAME</code> in <code class="bg-amber-100 px-1 rounded">.env</code> to send real emails.</p>
                <div class="bg-white border border-amber-200 rounded-lg py-3 px-6 inline-block">
                    <span class="text-3xl font-black font-mono tracking-[0.4em] text-amber-600">{{ $devOtp }}</span>
                </div>
                <p class="text-xs text-amber-400 mt-2">Use this code below ↓</p>
            </div>
        @endif

        {{-- ===== STEP 1: EMAIL ===== --}}
        @if (! $otpSent)
            <form wire:submit="sendOtp" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input
                        wire:model="email"
                        type="email"
                        placeholder="you@example.com"
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                        autofocus
                    />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 active:scale-95 text-white font-semibold py-3 rounded-xl transition"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="sendOtp">Send Login Code</span>
                    <span wire:loading wire:target="sendOtp">Sending…</span>
                </button>
            </form>

        {{-- ===== STEP 2: OTP + RESEND ===== --}}
        @else
            <form wire:submit="verifyOtp" class="space-y-5">

                <p class="text-sm text-gray-500 text-center">
                    Sent to <strong class="text-gray-700">{{ $email }}</strong>
                </p>

                {{-- 6-digit boxes --}}
                <div>
                    <div
                        x-data="{
                            digits: ['','','','','',''],
                            handleInput(i, e) {
                                const val = e.target.value.replace(/\D/g,'').slice(-1);
                                this.digits[i] = val;
                                $wire.set('otp', this.digits.join(''));
                                if (val && i < 5) $refs['d'+(i+1)].focus();
                            },
                            handleKey(i, e) {
                                if (e.key === 'Backspace') {
                                    if (this.digits[i]) { this.digits[i] = ''; $wire.set('otp', this.digits.join('')); }
                                    else if (i > 0) { $refs['d'+(i-1)].focus(); }
                                }
                            },
                            handlePaste(e) {
                                const text = (e.clipboardData||window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
                                text.split('').forEach((ch,i) => { this.digits[i] = ch; });
                                $wire.set('otp', this.digits.join(''));
                                const next = Math.min(text.length, 5);
                                $refs['d'+next].focus();
                                e.preventDefault();
                            }
                        }"
                        class="flex gap-2 justify-center"
                        @paste="handlePaste($event)"
                    >
                        @foreach(range(0,5) as $i)
                        <input
                            x-ref="d{{ $i }}"
                            type="text"
                            inputmode="numeric"
                            maxlength="1"
                            @input="handleInput({{ $i }}, $event)"
                            @keydown="handleKey({{ $i }}, $event)"
                            class="w-11 h-12 text-center text-xl font-mono border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                            {{ $i === 0 ? 'autofocus' : '' }}
                        />
                        @endforeach
                    </div>
                    @error('otp')
                        <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 active:scale-95 text-white font-semibold py-3 rounded-xl transition"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="verifyOtp">Verify &amp; Sign In</span>
                    <span wire:loading wire:target="verifyOtp">Verifying…</span>
                </button>

                {{-- Resend with countdown --}}
                <div
                    x-data="{
                        seconds: 0,
                        timer: null,
                        init() {
                            this.startCountdown(@js($resendAvailableAt));
                            $wire.$watch('resendAvailableAt', val => this.startCountdown(val));
                        },
                        startCountdown(expiresAt) {
                            clearInterval(this.timer);
                            const tick = () => {
                                this.seconds = Math.max(0, expiresAt - Math.floor(Date.now() / 1000));
                                if (this.seconds === 0) clearInterval(this.timer);
                            };
                            tick();
                            this.timer = setInterval(tick, 1000);
                        }
                    }"
                    class="text-center space-y-1"
                >
                    <p x-show="seconds > 0" class="text-xs text-gray-400">
                        Resend available in <span class="font-semibold text-gray-600" x-text="seconds"></span>s
                    </p>
                    <button
                        x-show="seconds === 0"
                        x-cloak
                        type="button"
                        wire:click="resendOtp"
                        wire:loading.attr="disabled"
                        class="text-sm text-blue-700 hover:text-blue-900 font-medium transition"
                    >
                        Resend code
                    </button>
                </div>

                <button
                    type="button"
                    wire:click="resetOtp"
                    class="w-full text-xs text-gray-400 hover:text-gray-600 transition"
                >
                    &larr; Use a different email
                </button>

            </form>
        @endif

    </div>
</div>
