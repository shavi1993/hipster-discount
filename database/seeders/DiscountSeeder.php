<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hipster\Discount\Models\Discount;
use Carbon\Carbon;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $types = ['percentage', 'fixed'];
        
        for ($i = 1; $i <= 10; $i++) {
            Discount::create([
                'name' => "Discount {$i}",
                'type' => $types[$i % 2], // alternating types
                'value' => rand(5, 50),   // random value between 5 and 50
                'usage_limit' => rand(1, 5),
                'active' => rand(0, 1), // some active, some inactive
                'expires_at' => Carbon::now()->addDays(rand(1, 60)),
            ]);
        }
    }
}
