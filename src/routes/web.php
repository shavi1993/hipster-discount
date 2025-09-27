<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Hipster\Discount\DiscountManager;
use Hipster\Discount\Models\Discount;

Route::match(['get', 'post'], '/discount/test', function (\Illuminate\Http\Request $request, DiscountManager $manager) {
    $eligible = [];
    $finalAmount = null;

    // All users for the dropdown
    $users = User::all();

    // All discounts for the dropdown / Blade
    $discounts = Discount::all();

    if ($request->isMethod('post')) {
        $userId = $request->input('user_id');
        $amount = $request->input('amount');
        $discountId = $request->input('discount_id'); // changed from type
        $activeOnly = $request->input('active_only');

        // Get all eligible discounts from package
        $eligible = $manager->eligibleFor($userId);

        // Filter by selected discount ID if provided
        if ($discountId) {
            $eligible = array_filter($eligible, fn($ud) => $ud->discount->id == $discountId);
        }

        // Filter active only if checkbox checked
        if ($activeOnly) {
            $eligible = array_filter($eligible, fn($ud) => $ud->discount->is_active);
        }

        // Apply all eligible discounts to the amount
        $finalAmount = $manager->apply($userId, $amount);
    }

    return view('discount::test', compact('users', 'discounts', 'eligible', 'finalAmount'));
})->name('discount.test');


Route::match(['get', 'post'], '/discount/dashboard', function (\Illuminate\Http\Request $request, DiscountManager $manager) {
    $users = User::all();
    $userSelected = null;
    $allDiscounts = [];

    if ($request->isMethod('post') && $request->filled('user_id')) {
        $userId = $request->input('user_id');
        $userSelected = User::find($userId);

        // All discounts
        $allDiscounts = $manager->allUserDiscounts($userId); // Custom function to get all discounts with usage and eligibility
    }

    return view('discount::dashboard', compact('users', 'userSelected', 'allDiscounts'));
})->name('discount.dashboard');
