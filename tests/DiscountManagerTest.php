<?php

namespace Hipster\Discount\Tests;

use Hipster\Discount\Models\Discount;
use Hipster\Discount\Models\UserDiscount;
use Hipster\Discount\Services\DiscountManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;

class DiscountManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            \Hipster\Discount\PackageServiceProvider::class,
        ];
    }

    /** @test */
    public function it_can_assign_a_discount_to_a_user()
    {
        $user = \App\Models\User::factory()->create();

        $discount = Discount::create([
            'name' => '10OFF',
            'type' => 'percentage',
            'value' => 10,
            'active' => true
        ]);

        $manager = new DiscountManager();
        $userDiscount = $manager->assign($user, $discount);

        $this->assertDatabaseHas('user_discounts', [
            'user_id' => $user->id,
            'discount_id' => $discount->id,
        ]);

        $this->assertTrue($userDiscount->discount->isValid());
    }

    /** @test */
    public function it_can_revoke_a_discount()
    {
        $user = \App\Models\User::factory()->create();
        $discount = Discount::create([
            'name' => '20OFF',
            'type' => 'percentage',
            'value' => 20,
            'active' => true
        ]);

        $manager = new DiscountManager();
        $userDiscount = $manager->assign($user, $discount);
        $manager->revoke($userDiscount);

        $this->assertDatabaseHas('user_discounts', [
            'id' => $userDiscount->id,
            'revoked_at' => now(), // or use ->notNull()
        ]);
    }
}
