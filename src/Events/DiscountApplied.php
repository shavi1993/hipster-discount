<?php

namespace Hipster\Discount\Events;

use Hipster\Discount\Models\Discount;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscountApplied
{
    use Dispatchable, SerializesModels;

    public Discount $discount;
    public float $amountSaved;

    public function __construct(Discount $discount, float $amountSaved)
    {
        $this->discount = $discount;
        $this->amountSaved = $amountSaved;
    }
}
