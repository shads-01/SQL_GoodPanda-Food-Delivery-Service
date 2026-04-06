<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="max-w-xl mx-auto bg-white p-8 mt-10 rounded shadow">

<h2 class="text-xl font-bold mb-6">Edit Item</h2>

<div class="mb-4">
    <a href="{{ route('restaurant.items') }}" class="text-blue-500 hover:text-blue-700">&larr; Back to Items</a>
</div>

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<!-- Update Form -->
<form action="{{ route('restaurant.updateItem', $item->item_id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
        <input type="text" name="name" value="{{ $item->item_name }}" class="w-full border p-3 rounded" placeholder="Item Name" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
        <input type="number" step="0.01" name="price" value="{{ $item->price }}" class="w-full border p-3 rounded" placeholder="Price" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
        <select name="category_id" class="w-full border p-3 rounded" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->category_id }}" {{ $item->category_id == $category->category_id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" class="w-full border p-3 rounded" placeholder="Description" rows="3">{{ $item->description }}</textarea>
    </div>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Item</button>
</form>

<!-- Delete Button -->
<form action="{{ route('restaurant.deleteItem', $item->item_id) }}" method="POST" class="mt-6" onsubmit="return confirm('Are you sure you want to delete this item?')">
    @csrf
    @method('DELETE')

    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
        Delete Item
    </button>
</form>

</div>

</body>
</html>