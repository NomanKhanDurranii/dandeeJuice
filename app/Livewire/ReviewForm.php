<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class ReviewForm extends Component
{
    public int $productId;

    public string $reviewerName  = '';
    public string $reviewerEmail = '';
    public int    $rating        = 0;
    public string $body          = '';
    public bool   $submitted     = false;

    protected function rules(): array
    {
        return [
            'reviewerName'  => 'required|min:2|max:100',
            'reviewerEmail' => 'required|email|max:255',
            'rating'        => 'required|integer|min:1|max:5',
            'body'          => 'required|min:10|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'rating.min' => 'Please select a star rating.',
        ];
    }

    public function mount(int $productId): void
    {
        $this->productId = $productId;

        if (auth()->check()) {
            $this->reviewerName  = auth()->user()->name ?? '';
            $this->reviewerEmail = auth()->user()->email ?? '';
        }
    }

    public function submit(): void
    {
        $this->validate();

        Review::create([
            'product_id'     => $this->productId,
            'user_id'        => auth()->id(),
            'reviewer_name'  => $this->reviewerName,
            'reviewer_email' => $this->reviewerEmail,
            'rating'         => $this->rating,
            'body'           => $this->body,
            'status'         => 'pending',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
