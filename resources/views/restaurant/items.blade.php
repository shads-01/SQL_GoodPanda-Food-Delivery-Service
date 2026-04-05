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

<h2 class="text-2xl font-bold mb-6">Menu Management</h2>

<table class="w-full bg-white shadow rounded">

<tr class="border-b text-gray-500">
    <th class="p-3 text-left">Item</th>
    <th>Price</th>
    <th>Category</th>
    <th>Status</th>
    <th></th>
</tr>

<tr class="border-b">
    <td class="p-3">Panda Ramen</td>
    <td>$16</td>
    <td>Main</td>
    <td class="text-green-500">Available</td>
    <td>
        <a href="{{ route('restaurant.item.details',1) }}" class="text-orange-500">Edit</a>
    </td>
</tr>

</table>

</div>

</body>
</html>