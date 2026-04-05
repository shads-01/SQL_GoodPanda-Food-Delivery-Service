<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

<!-- Navbar -->
<nav class="w-full p-4 flex justify-between items-center"
style="background: linear-gradient(135deg, #f3a34e, #FB923C);">

    <h1 class="text-2xl font-bold text-white">GoodPanda</h1>

    <div class="flex gap-6 text-white">
        <a href="{{ route('restaurant.dashboard') }}">Dashboard</a>
        <a href="{{ route('restaurant.items') }}">Menu</a>
        <a href="{{ route('restaurant.orders') }}">Orders</a>
        <a href="{{ route('restaurant.analytics') }}">Analytics</a>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('restaurant.add_item') }}" class="bg-white text-orange-500 px-4 py-2 rounded">+ Add Item</a>
        <a href="{{ route('restaurant.add_offer') }}" class="bg-orange-500 text-white px-4 py-2 rounded">+ Offer</a>
    </div>
</nav>

<div class="p-8">

    <!-- Stats -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white p-5 rounded shadow">
            <p class="text-gray-500">Revenue</p>
            <h2 class="text-xl font-bold">$12,845</h2>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <p class="text-gray-500">Orders</p>
            <h2 class="text-xl font-bold">320</h2>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <p class="text-gray-500">Items</p>
            <h2 class="text-xl font-bold">42</h2>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <p class="text-gray-500">Top Item</p>
            <h2 class="text-sm font-bold">Panda Ramen</h2>
        </div>

    </div>

</div>

</body>
</html>