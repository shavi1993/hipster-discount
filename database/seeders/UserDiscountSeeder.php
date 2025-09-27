<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Hipster\Discount\Models\Discount;

class UserDiscountSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();          // Get all users
        $discounts = Discount::all();  // Get all discounts

        // Clear existing records (optional)
        DB::table('user_discounts')->truncate();

        // Assign each discount to a random set of users
        foreach ($discounts as $discount) {
            // Assign each discount to 3 random users
            $assignedUsers = $users->random(min(3, $users->count()));

            foreach ($assignedUsers as $user) {
                DB::table('user_discounts')->insert([
                    'user_id' => $user->id,
                    'discount_id' => $discount->id,
                    'used_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
