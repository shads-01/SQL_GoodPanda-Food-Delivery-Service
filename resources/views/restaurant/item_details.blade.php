<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="max-w-2xl mx-auto p-8 bg-white mt-10 rounded shadow">

<h2 class="text-xl font-bold mb-4">Add Item</h2>

<form class="space-y-4">

<input class="w-full border p-3 rounded" placeholder="Item Name">
<input class="w-full border p-3 rounded" placeholder="Price">

<select class="w-full border p-3 rounded">
<option>Main Course</option>
<option>Dessert</option>
</select>

<textarea class="w-full border p-3 rounded" placeholder="Description"></textarea>

<button class="bg-orange-500 text-white px-6 py-2 rounded">Save</button>

</form>

</div>

</body>
</html>