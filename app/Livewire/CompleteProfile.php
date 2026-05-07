<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompleteProfile extends Component
{
    public string $name = '';

    public string $phone = '';

    public ?string $error = null;

    public function mount(): void
    {
        // If already has a real name, skip this page
        if (Auth::check() && Auth::user()->name !== 'Customer') {
            $this->redirect(route('home'), navigate: false);
        }
    }

    public function save(): void
    {
        $this->error = null;

        $this->validate([
            'name'  => 'required|string|min:2|max:80',
            'phone' => 'nullable|regex:/^[0-9+\-\s]{7,20}$/',
        ]);

        $user = Auth::user();

        if (! $user) {
            $this->redirect(route('login'), navigate: false);
            return;
        }

        $user->update([
            'name'  => trim($this->name),
            'phone' => $this->phone ?: null,
        ]);

        $this->redirect(route('home'), navigate: false);
    }

    public function render()
    {
        return view('livewire.complete-profile');
    }
}
