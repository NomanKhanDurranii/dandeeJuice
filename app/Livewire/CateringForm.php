<?php

namespace App\Livewire;

use App\Mail\NewInquiryMail;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CateringForm extends Component
{
    public string $name        = '';
    public string $email       = '';
    public string $phone       = '';
    public string $eventType   = '';
    public string $guestCount  = '';
    public string $eventDate   = '';
    public string $message     = '';

    public bool $submitted = false;

    public function updated(string $field): void
    {
        $this->validateOnly($field, $this->validationRules());
    }

    public function submit(): void
    {
        $this->validate($this->validationRules());

        $subject = "Catering Inquiry — {$this->eventType} ({$this->guestCount} guests)";

        $body = "Event Type: {$this->eventType}\n"
              . "Guests: {$this->guestCount}\n"
              . "Event Date: {$this->eventDate}\n\n"
              . $this->message;

        $inquiry = Inquiry::create([
            'type'    => 'catering',
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'subject' => $subject,
            'message' => $body,
            'status'  => 'new',
        ]);

        $this->notifyAdmin($inquiry);

        $this->submitted = true;
    }

    private function validationRules(): array
    {
        return [
            'name'       => 'required|string|min:2|max:80',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|regex:/^[0-9+\-\s]{7,20}$/',
            'eventType'  => 'required|string|max:100',
            'guestCount' => 'required|string|max:50',
            'eventDate'  => 'nullable|string|max:100',
            'message'    => 'required|string|min:10|max:2000',
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
            logger()->error('Admin catering notification failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.catering-form');
    }
}
