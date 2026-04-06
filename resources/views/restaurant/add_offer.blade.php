<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="max-w-2xl mx-auto p-8 bg-white mt-10 rounded shadow">

<h2 class="text-xl font-bold mb-4">Create Offer</h2>

<form action="{{ route('restaurant.store_offer') }}" method="POST" class="space-y-4">
    @csrf

<select name="item_id" class="w-full border p-3 rounded" required>
<option value="">Select Item</option>
@foreach($items as $item)
<option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
@endforeach
</select>

<input name="discount_percentage" type="number" min="1" max="100" class="w-full border p-3 rounded" placeholder="Discount %" required>

<input name="start_date" type="datetime-local" class="w-full border p-3 rounded" required>
<input name="end_date" type="datetime-local" class="w-full border p-3 rounded" required>

<button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded">
Apply Offer
</button>

</form>

</div>

</body>
</html>