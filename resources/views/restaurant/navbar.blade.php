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
<a href="{{ route('restaurant.add_item') }}" class="bg-white text-orange-500 px-4 py-2 rounded">+ Item</a>
<a href="{{ route('restaurant.add_offer') }}" class="bg-orange-500 text-white px-4 py-2 rounded">+ Offer</a>
</div>

</nav>