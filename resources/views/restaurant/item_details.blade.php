<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="max-w-xl mx-auto bg-white p-8 mt-10 rounded shadow">

<h2 class="text-xl font-bold mb-6">Edit Item</h2>

<!-- Update Form -->
<form action="{{ route('restaurant.updateItem', $item->id) }}" method="POST" class="space-y-4">
    @csrf

    <input type="text" name="name" value="{{ $item->name }}" class="w-full border p-3 rounded" placeholder="Item Name">

    <input type="text" name="price" value="{{ $item->price }}" class="w-full border p-3 rounded" placeholder="Price">

    <input type="text" name="category" value="{{ $item->category }}" class="w-full border p-3 rounded" placeholder="Category">

    <button class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
</form>

<!-- Delete Button -->
<form action="{{ route('restaurant.deleteItem', $item->id) }}" method="POST" class="mt-6">
    @csrf
    @method('DELETE')

    <button class="bg-red-500 text-white px-4 py-2 rounded">
        Delete Item
    </button>
</form>

</div>

</body>
</html>