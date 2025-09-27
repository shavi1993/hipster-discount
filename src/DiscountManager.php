<?php

namespace Hipster\Discount;

use Hipster\Discount\Models\Discount;
use Hipster\Discount\Models\UserDiscount;
use Hipster\Discount\Models\DiscountAudit;
use Hipster\Discount\Events\DiscountAssigned;
use Hipster\Discount\Events\DiscountRevoked;
use Hipster\Discount\Events\DiscountApplied;
use Illuminate\Support\Facades\DB;

class DiscountManager
{
    public function assign(int $userId, int $discountId): void {
        $userDiscount = UserDiscount::firstOrCreate([
            'user_id' => $userId,
            'discount_id' => $discountId
        ]);
    
        event(new DiscountAssigned($userId, $discountId)); // pass both
    }

    public function revoke(int $userId, int $discountId): void {
        UserDiscount::where('user_id',$userId)->where('discount_id',$discountId)->delete();
        event(new DiscountRevoked($userId, $discountId));
    }

    public function eligibleFor(int $userId): array {
        return UserDiscount::with('discount')
            ->where('user_id',$userId)
            ->get()
            ->filter(fn($ud) => $ud->eligible())
            ->all();
    }
    public function allUserDiscounts($userId)
    {
        $discounts = Discount::all();

        // Get user's discount usage counts
        $userDiscounts = DB::table('user_discounts')
            ->where('user_id', $userId)
            ->pluck('used_count', 'discount_id') // [discount_id => used_count]
            ->toArray();

        // Map discounts with status info
        return $discounts->map(function ($discount) use ($userDiscounts) {
            return (object)[
                'discount' => $discount,
                'used_count' => $userDiscounts[$discount->id] ?? 0,
                'assigned' => isset($userDiscounts[$discount->id])
            ];
        });
    }

    public function apply(int $userId, float $amount): float {
        $finalAmount = $amount;
    
        $discounts = collect($this->eligibleFor($userId))
            ->sortBy(fn($ud) => array_search($ud->discount->type, config('discount.stacking_order')));
    
        foreach ($discounts as $ud) {
            $discount = $ud->discount;
            DB::transaction(function() use ($ud, $discount, &$finalAmount, $userId) {
                $ud->refresh();
                if (!$ud->eligible()) return;
                
                $applied = match($discount->type) {
                    'percentage' => min(
                        $finalAmount * $discount->value/100,
                        $finalAmount * config('discount.max_percentage_cap')/100
                    ),
                    'fixed' => $discount->value
                };
                
                $finalAmount -= $applied;
                $finalAmount = round($finalAmount, config('discount.rounding'));
                $ud->increment('used_count');
    
                DiscountAudit::create([
                    'user_id'       => $userId,
                    'discount_id'   => $discount->id,
                    'applied_amount'=> $applied
                ]);
    
                // ✅ Pass Discount model + applied amount
                event(new DiscountApplied($discount, $applied));
            });
        }
    
        return $finalAmount;
    }
    
}
