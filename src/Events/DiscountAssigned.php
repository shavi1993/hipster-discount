<?php

namespace Hipster\Discount\Events;

use Hipster\Discount\Models\Discount;
use Hipster\Discount\Models\UserDiscount;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiscountAssigned
{
    public int $userId;
    public int $discountId;

    public function __construct(int $userId, int $discountId)
    {
        $this->userId = $userId;
        $this->discountId = $discountId;
    }
}

