<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Discount Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold mb-6">Discount Test</h1>

    {{-- Form to select user, amount, and filters --}}
    <form action="{{ route('discount.test') }}" method="POST" class="space-y-4 bg-gray-50 p-4 rounded">
        @csrf

        {{-- Select User --}}
        <div>
            <label class="block font-medium mb-1">Select User:</label>
            <select name="user_id" class="w-full border rounded p-2" required>
                <option value="">-- Choose User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div>
            <label class="block font-medium mb-1">Amount:</label>
            <input type="number" step="0.01" name="amount" class="w-full border rounded p-2" value="{{ request('amount') ?? '' }}" required>
        </div>

        {{-- Discount Selection --}}
        <div>
            <label class="block font-medium mb-1">Select Discount (Optional):</label>
            <select name="discount_id" class="w-full border rounded p-2">
                <option value="">All Discounts</option>
                @foreach($discounts as $discount)
                    <option value="{{ $discount->id }}" {{ request('discount_id') == $discount->id ? 'selected' : '' }}>
                        {{ $discount->name }} - {{ $discount->value }}{{ $discount->type === 'percentage' ? '%' : '₹' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Active Only Checkbox --}}
        <div class="flex items-center gap-2">
            <input type="checkbox" name="active_only" value="1" {{ request('active_only') ? 'checked' : '' }}>
            <label class="font-medium">Active Discounts Only</label>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Check & Apply Discounts</button>
    </form>

    {{-- Dashboard Button --}}
    <div class="mt-4">
        <a href="{{ route('discount.dashboard') }}" 
           class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Go to Discount Dashboard
        </a>
    </div>

    {{-- Eligible Discounts --}}
    @if(isset($eligible) && count($eligible) > 0)
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Eligible Discounts</h2>
            <ul class="border-t divide-y">
                @foreach($eligible as $ud)
                    <li class="py-2 flex justify-between">
                        <span>
                            {{ $ud->discount->name }} - 
                            Value: {{ $ud->discount->value }}{{ $ud->discount->type === 'percentage' ? '%' : '₹' }}
                        </span>
                        <span class="text-gray-600">
                            Usage: {{ $ud->usage_count ?? 0 }}/{{ $ud->discount->usage_limit ?? '∞' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @elseif(request()->isMethod('post'))
        <p class="mt-6 text-red-500">No eligible discounts for this user.</p>
    @endif

    {{-- Final Amount --}}
    @if(isset($finalAmount))
        <div class="mt-6 bg-green-100 p-4 rounded">
            <h2 class="text-xl font-semibold mb-2">Final Amount after Discounts:</h2>
            <p class="text-2xl font-bold">₹{{ number_format($finalAmount, 2) }}</p>
        </div>
    @endif
</div>

</body>
</html>
