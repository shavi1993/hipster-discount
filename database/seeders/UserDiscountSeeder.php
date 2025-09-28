<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hipster\Discount\Models\Discount;
use Illuminate\Support\Facades\DB;

class UserDiscountSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users and discounts
        $users = User::all();
        $discounts = Discount::all();

        foreach ($users as $user) {
            foreach ($discounts as $discount) {
                // Randomly decide if the user gets this discount
                if (rand(0, 1)) {
                    DB::table('user_discounts')->insert([
                        'user_id' => $user->id,
                        'discount_id' => $discount->id,
                        'used_count' => rand(0, 5), // Random used count
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('User discounts seeded successfully!');
    }
}
