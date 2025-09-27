<?php

namespace Hipster\Discount\Events;

use Hipster\Discount\Models\Discount;
use Hipster\Discount\Models\UserDiscount;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscountRevoked
{
    use Dispatchable, SerializesModels;

    public UserDiscount $userDiscount;
    public Discount $discount;

    public function __construct(UserDiscount $userDiscount, Discount $discount)
    {
        $this->userDiscount = $userDiscount;
        $this->discount = $discount;
    }
}
