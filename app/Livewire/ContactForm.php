<?php

namespace App\Livewire;

use App\Mail\NewInquiryMail;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name    = '';
    public string $email   = '';
    public string $phone   = '';
    public string $subject = '';
    public string $message = '';

    public bool $submitted = false;

    // Real-time field validation on blur/change
    public function updated(string $field): void
    {
        $this->validateOnly($field, $this->validationRules());
    }

    public function submit(): void
    {
        $this->validate($this->validationRules());

        $inquiry = Inquiry::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'type'    => 'general',
            'phone'   => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'status'  => 'new',
        ]);

        $this->notifyAdmin($inquiry);

        $this->submitted = true;
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'phone', 'subject', 'message', 'submitted']);
        $this->resetValidation();
    }

    private function validationRules(): array
    {
        return [
            'name'    => 'required|string|min:2|max:80',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|regex:/^[0-9+\-\s]{7,20}$/',
            'subject' => 'required|string|min:3|max:150',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    private function notifyAdmin(Inquiry $inquiry): void
    {
        $adminEmail = config('mail.from.address');

        if (blank($adminEmail) || $adminEmail === 'noreply@dandeejuice.com') {
            return;
        }

        try {
            Mail::to($adminEmail)->send(new NewInquiryMail($inquiry));
        } catch (\Throwable $e) {
            logger()->error('Admin inquiry notification failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
