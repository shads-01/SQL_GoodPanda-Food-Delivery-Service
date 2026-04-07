<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
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

        <div class="flex items-center gap-4">
            <div class="flex gap-1">
                <a href="{{ route('restaurant.add_item') }}" class="bg-white text-orange-500 px-4 py-2 rounded">+ Add Item</a>
                <a href="{{ route('restaurant.add_offer') }}" class="bg-orange-500 text-white px-4 py-2 rounded">+ Offer</a>
            </div>
            
            @if(Session::has('user_id'))
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white text-red-600 px-4 py-2 rounded font-semibold shadow hover:bg-red-50 transition flex items-center gap-2">
                        <i data-feather="log-out" class="w-4 h-4 text-red-600"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="bg-white text-orange-500 px-5 py-2 rounded-full font-semibold shadow hover:bg-orange-50 transition">
                    Login
                </a>
            @endif
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
                <h2 class="text-xl font-bold">{{ $itemCount ?? 0 }}</h2>
            </div>

            <div class="bg-white p-5 rounded shadow">
                <p class="text-gray-500">Top Item</p>
                <h2 class="text-sm font-bold">Panda Ramen</h2>
            </div>

        </div>

        <!-- Recent Orders Section -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">

            <!-- Recent Orders -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Recent Orders</h3>
                    <a href="{{ route('restaurant.orders') }}" class="text-orange-500 text-sm">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <p class="font-medium">Order #1234</p>
                            <p class="text-sm text-gray-500">2 items • $24.50</p>
                        </div>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Delivered</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <p class="font-medium">Order #1233</p>
                            <p class="text-sm text-gray-500">1 item • $12.00</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Preparing</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <div>
                            <p class="font-medium">Order #1232</p>
                            <p class="text-sm text-gray-500">3 items • $35.75</p>
                        </div>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Out for Delivery</span>
                    </div>
                </div>
            </div>

            <!-- Active Offers -->
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Active Offers</h3>
                    <a href="{{ route('restaurant.add_offer') }}" class="text-orange-500 text-sm">+ Add Offer</a>
                </div>
                <div class="space-y-3">
                    @if(isset($activeOffers) && $activeOffers->count() > 0)
                        @foreach($activeOffers->take(3) as $offer)
                            <div class="flex justify-between items-center py-2 border-b">
                                <div>
                                    <p class="font-medium">{{ $offer->offer_title }}</p>
                                    <p class="text-sm text-gray-500">{{ $offer->discount_value }}% off • Expires
                                        {{ \Carbon\Carbon::parse($offer->end_datetime)->format('M d') }}</p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Active</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm">No active offers</p>
                        <a href="{{ route('restaurant.add_offer') }}"
                            class="text-orange-500 text-sm mt-2 inline-block">Create your first offer →</a>
                    @endif
                </div>
            </div>

        </div>

        <!-- Menu Performance & Quick Actions -->
        <div class="grid md:grid-cols-3 gap-6">

            <!-- Top Performing Items -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-4">Top Items</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span>Panda Special Pizza</span>
                        <span class="font-bold">45 orders</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Chicken Burger</span>
                        <span class="font-bold">32 orders</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>French Fries</span>
                        <span class="font-bold">28 orders</span>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-4">Menu Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Available Items</span>
                        <span
                            class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ $availableItems ?? $itemCount ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Unavailable Items</span>
                        <span
                            class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ $unavailableItems ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Items with Offers</span>
                        <span
                            class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $itemsWithOffers ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('restaurant.add_item') }}"
                        class="block w-full bg-orange-500 text-white text-center py-2 px-4 rounded hover:bg-orange-600">
                        + Add New Item
                    </a>
                    <a href="{{ route('restaurant.add_offer') }}"
                        class="block w-full bg-blue-500 text-white text-center py-2 px-4 rounded hover:bg-blue-600">
                        Create Offer
                    </a>
                    <a href="{{ route('restaurant.items') }}"
                        class="block w-full bg-gray-500 text-white text-center py-2 px-4 rounded hover:bg-gray-600">
                        Manage Menu
                    </a>
                    <a href="{{ route('restaurant.analytics') }}"
                        class="block w-full bg-purple-500 text-white text-center py-2 px-4 rounded hover:bg-purple-600">
                        View Analytics
                    </a>
                </div>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>

</body>

</html>