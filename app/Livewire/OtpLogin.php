<?php

namespace App\Livewire;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;
use Throwable;

class OtpLogin extends Component
{
    public string $email = '';

    public string $otp = '';

    public bool $otpSent = false;

    public ?string $error = null;

    public ?string $successMessage = null;

    // Shown in UI only when SMTP is not configured and APP_DEBUG=true
    public ?string $devOtp = null;

    // Unix timestamp when the resend cooldown expires (sent to Alpine for countdown)
    public int $resendAvailableAt = 0;

    public function sendOtp(): void
    {
        $this->error = null;
        $this->devOtp = null;
        $this->validate(['email' => 'required|email|max:255']);

        $key = 'otp-send:' . Str::slug($this->email);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->error = "Too many attempts. Try again in {$seconds} seconds.";
            return;
        }

        RateLimiter::hit($key, 300);

        $code = (string) random_int(100000, 999999);

        $user = User::firstOrCreate(
            ['email' => $this->email],
            ['name' => 'Customer', 'role' => 'customer']
        );

        $user->update([
            'otp_code'       => $code,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        $sent = $this->deliverOtp($code);

        $this->otpSent = true;
        $this->resendAvailableAt = now()->addSeconds(60)->timestamp;

        if ($sent) {
            $this->successMessage = 'Code sent! Check your inbox (and spam folder).';
        } else {
            // SMTP not configured — show code on screen in debug mode
            $this->successMessage = 'Mail is not configured yet.';
            if (config('app.debug')) {
                $this->devOtp = $code;
            }
        }
    }

    public function resendOtp(): void
    {
        if (now()->timestamp < $this->resendAvailableAt) {
            return;
        }

        $this->otpSent = false;
        $this->otp = '';
        $this->sendOtp();
    }

    public function verifyOtp(): void
    {
        $this->error = null;
        $this->validate(['otp' => 'required|digits_between:4,6']);

        $verifyKey = 'otp-verify:' . Str::slug($this->email);

        if (RateLimiter::tooManyAttempts($verifyKey, 5)) {
            $this->error = 'Too many invalid attempts. Please request a new code.';
            $this->resetOtp();
            return;
        }

        $user = User::where('email', $this->email)->first();

        if (! $user || ! $user->isOtpValid($this->otp)) {
            RateLimiter::hit($verifyKey, 300);
            $this->error = 'Invalid or expired code. Please try again.';
            return;
        }

        $user->clearOtp();
        RateLimiter::clear($verifyKey);
        RateLimiter::clear('otp-send:' . Str::slug($this->email));

        Auth::login($user, remember: true);

        // New user → collect their name first
        if ($user->name === 'Customer') {
            $this->redirect(route('profile.complete'), navigate: false);
            return;
        }

        // Return to the page they were trying to reach, else home
        $this->redirect(redirect()->intended(route('home'))->getTargetUrl(), navigate: false);
    }

    public function resetOtp(): void
    {
        $this->otpSent = false;
        $this->otp = '';
        $this->error = null;
        $this->successMessage = null;
        $this->devOtp = null;
        $this->resendAvailableAt = 0;
    }

    private function deliverOtp(string $code): bool
    {
        // Skip real mail when credentials are not set
        if (blank(config('mail.mailers.smtp.username')) || config('mail.mailers.smtp.username') === 'null') {
            logger("DEV OTP for {$this->email}: {$code}");
            return false;
        }

        try {
            Mail::to($this->email)->send(new OtpMail($code));
            return true;
        } catch (Throwable $e) {
            logger()->error('OTP mail failed: ' . $e->getMessage());
            return false;
        }
    }

    public function render()
    {
        return view('livewire.otp-login');
    }
}
