<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="p-8">

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<h2 class="text-2xl font-bold mb-6">Menu Management</h2>

<table class="w-full bg-white shadow rounded text-left">

<tr class="border-b text-gray-500 bg-gray-50">
    <th class="p-3">Item</th>
    <th class="p-3">Price</th>
    <th class="p-3">Category</th>
    <th class="p-3">Status</th>
    <th class="p-3">Actions</th>
</tr>

@foreach($items as $item)
<tr class="border-b">
    <td class="p-3">{{ $item->item_name }}</td>
    <td class="p-3">${{ $item->price }}</td>
    <td class="p-3">{{ $item->category_name ?? 'No Category' }}</td>
    <td class="p-3 {{ $item->is_available ? 'text-green-500' : 'text-red-500' }}">
        {{ $item->is_available ? 'Available' : 'Unavailable' }}
    </td>
    <td class="p-3">
        <a href="{{ route('restaurant.item.details', $item->item_id) }}" class="text-orange-500">Edit</a>
    </td>
</tr>
@endforeach

</table>

</div>

</body>
</html>