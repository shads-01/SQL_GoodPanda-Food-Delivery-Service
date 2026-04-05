<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="max-w-2xl mx-auto p-8 bg-white mt-10 rounded shadow">

<h2 class="text-xl font-bold mb-4">Create Offer</h2>

<form class="space-y-4">

<select class="w-full border p-3 rounded">
<option>Select Item</option>
</select>

<input class="w-full border p-3 rounded" placeholder="Discount %">

<input type="datetime-local" class="w-full border p-3 rounded">
<input type="datetime-local" class="w-full border p-3 rounded">

<button class="bg-orange-500 text-white px-6 py-2 rounded">
Apply Offer
</button>

</form>

</div>

</body>
</html>