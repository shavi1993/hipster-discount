<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Discount Eligibility</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold mb-6">User Discount Eligibility</h1>

    {{-- Select User --}}
    <form action="{{ route('discount.dashboard') }}" method="POST" class="mb-6">
        @csrf
        <label class="block font-medium mb-2">Select User:</label>
        <select name="user_id" class="w-full border rounded p-2" onchange="this.form.submit()">
            <option value="">-- Choose User --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </form>

    @if(isset($userSelected))
        <h2 class="text-xl font-semibold mb-2">Discounts for {{ $userSelected->name }}</h2>
        {{-- Back to Discount Test Button --}}
    <div class="mb-4">
        <a href="{{ route('discount.test') }}" 
           class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Go to Discount Test
        </a>
    </div>

        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-2 py-1">Discount Name</th>
                    <th class="border px-2 py-1">Type</th>
                    <th class="border px-2 py-1">Value</th>
                    <th class="border px-2 py-1">Usage Count</th>
                    <th class="border px-2 py-1">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allDiscounts as $ud)
                    <tr>
                        <td class="border px-2 py-1">{{ $ud->discount->name }}</td>
                        <td class="border px-2 py-1">{{ $ud->discount->type }}</td>
                        <td class="border px-2 py-1">{{ $ud->discount->value }}{{ $ud->discount->type === 'percentage' ? '%' : '₹' }}</td>
                        <td class="border px-2 py-1">{{ $ud->used_count ?? 0 }}</td>
                        <td class="border px-2 py-1">
                            @if(!$ud->discount->active)
                                Inactive
                            @elseif($ud->used_count >= $ud->discount->usage_limit)
                                Max Usage Reached
                            @elseif($ud->assigned)
                                Already Assigned
                            @else
                                Eligible
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
</body>
</html>
