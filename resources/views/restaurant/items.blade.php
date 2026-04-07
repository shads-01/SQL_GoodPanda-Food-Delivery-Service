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

<div class="mb-4">
    <a href="{{ route('restaurant.add_offer') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
        Create Offer
    </a>
</div>

<table class="w-full bg-white shadow rounded text-left">

<tr class="border-b text-gray-500 bg-gray-50">
    <th class="p-3">Image</th>
    <th class="p-3">Item</th>
    <th class="p-3">Price</th>
    <th class="p-3">Category</th>
    <th class="p-3">Cuisine</th>
    <th class="p-3">Status</th>
    <th class="p-3">Actions</th>
</tr>

@foreach($items as $item)
<tr class="border-b hover:bg-gray-50 transition-colors">
    <td class="p-3">
        <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
            <img src="{{ $item->item_image }}" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name='+encodeURIComponent('{{ $item->item_name }}')+'&background=random'">
        </div>
    </td>
    <td class="p-3 font-semibold text-gray-700">{{ $item->item_name }}</td>
    <td class="p-3">
        @if($item->has_offer)
            <span class="line-through text-gray-500">${{ $item->original_price }}</span>
            <span class="text-green-600 font-bold">${{ $item->discounted_price }}</span>
            @if($item->discount_type === 'percentage')
                <span class="text-sm text-green-600">({{ $item->discount_value }}% off)</span>
            @endif
        @else
            ${{ $item->price }}
        @endif
    </td>
    <td class="p-3">{{ $item->category_name ?? 'No Category' }}</td>
    <td class="p-3">{{ $item->cuisine_name ?? 'No Cuisine' }}</td>
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