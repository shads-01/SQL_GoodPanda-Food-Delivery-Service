<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | {{ $restaurant->name ?? 'Restaurant' }}</title>
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
                <a href="{{ route('login') }}" class="bg-white text-orange-500 px-5 py-2 rounded-full font-semibold shadow hover:bg-orange-50 transition">Login</a>
            @endif
        </div>
    </nav>

    <div class="p-8 max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-5xl font-black text-gray-900 tracking-tight">Welcome, <span class="text-orange-500">{{ $restaurant->name }}</span>!</h2>
            </div>
            <div class="flex items-center gap-2 text-sm font-bold text-gray-400 uppercase tracking-widest bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                <i data-feather="calendar" class="w-4 h-4"></i>
                {{ date('M d, Y') }}
            </div>
        </div>

        <!-- ===== STAT CARDS ===== -->
        <div class="flex flex-wrap gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex-1 min-w-[280px]">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-green-50 rounded-lg">
                        <i data-feather="dollar-sign" class="w-5 h-5 text-green-600"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Revenue</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">
                    ৳{{ number_format($stats->total_revenue ?? 0, 0) }}
                </h2>
                <p class="text-xs text-gray-400 mt-2 font-medium">Gross income from completed orders</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex-1 min-w-[280px]">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <i data-feather="shopping-bag" class="w-5 h-5 text-blue-600"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Completed Orders</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $stats->total_completed_orders ?? 0 }}</h2>
                <p class="text-xs text-blue-500 mt-2 font-bold italic">Avg: ৳{{ number_format($stats->average_order_value ?? 0, 0) }} / order</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex-1 min-w-[280px]">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-purple-50 rounded-lg">
                        <i data-feather="layers" class="w-5 h-5 text-purple-600"></i>
                    </div>
                </div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Menu Inventory</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">{{ $itemCount }}</h2>
                <p class="text-xs text-gray-400 mt-2 font-medium"><span class="text-green-600 font-bold">{{ $availableItems }} Live</span> · {{ $unavailableItems }} Hidden</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-br from-white to-orange-50 hover:shadow-md transition-shadow border-l-4 border-l-orange-500 flex-1 min-w-[280px]">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <i data-feather="zap" class="w-5 h-5 text-orange-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">Active Orders</p>
                <h2 class="text-3xl font-black text-orange-600 mt-1">{{ count($activeOrders) }}</h2>
                <p class="text-xs text-orange-400 mt-2 font-bold animate-pulse">Orders waiting for preparation</p>
            </div>

        </div>

        <!-- ===== ACTIVE PENDING ORDERS + RECENT REVIEWS ===== -->
        <div class="grid lg:grid-cols-7 gap-8 mb-10">

            <!-- Active Pending Orders -->
            <div class="lg:col-span-4 bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-10">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-800 flex items-center gap-2">
                        Pending Orders
                    </h3>
                    <a href="{{ route('restaurant.orders') }}" class="text-orange-500 text-sm font-bold border-b-2 border-orange-100 hover:border-orange-500 transition-all pb-0.5">Manage All Orders</a>
                </div>
                @if(count($activeOrders) > 0)
                    <div class="space-y-4">
                        @foreach($activeOrders as $order)
                            <div class="flex justify-between items-center p-4 rounded-xl border border-gray-50 bg-gray-50/30 hover:bg-orange-50/30 transition-colors">
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">
                                        Customer: <span class="text-gray-700 font-bold">{{ $order->customer_name }}</span> · {{ \Carbon\Carbon::parse($order->order_datetime)->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="text-right flex flex-col items-end gap-1.5">
                                    <p class="font-black text-gray-900">৳{{ number_format($order->subtotal, 0) }}</p>
                                    @php
                                        $statusColors = [
                                            'pending'   => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'preparing' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'ready'     => 'bg-green-100 text-green-800 border-green-200',
                                        ];
                                        $color = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span class="{{ $color }} px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-100">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                            <i data-feather="check-circle" class="w-8 h-8 text-green-400"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg">Kitchen clear!</h4>
                        <p class="text-gray-400 px-10 max-w-xs mt-1">There are no active orders waiting. Sit back or update your menu!</p>
                    </div>
                @endif
            </div>

            <!-- Recent Reviews -->
            <div class="lg:col-span-3 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-800">Reviews Feedback</h3>
                    @if(count($recentReviews) > 0)
                        <div class="flex items-center gap-1 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                            <span class="text-orange-600 font-black text-sm">{{ number_format($recentReviews[0]->avg_restaurant_rating ?? 0, 1) }}</span>
                            <i data-feather="star" class="w-3 h-3 text-orange-500 fill-orange-500"></i>
                        </div>
                    @endif
                </div>
                @if(count($recentReviews) > 0)
                    <div class="space-y-6">
                        @foreach($recentReviews as $review)
                            <div class="relative pl-4 border-l-2 border-gray-100 hover:border-orange-500 transition-colors">
                                <div class="flex justify-between items-start mb-1.5">
                                    <p class="font-bold text-gray-900 leading-tight">{{ $review->reviewer_name }}</p>
                                    <div class="flex text-orange-400 scale-90 origin-right">
                                        @for($i=0; $i<5; $i++)
                                            <i data-feather="star" class="w-3 h-3 {{ $i < $review->customer_rating ? 'fill-orange-400' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p class="text-sm text-gray-600 italic leading-relaxed line-clamp-2">"{{ $review->comment }}"</p>
                                @endif
                                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($review->review_datetime)->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-12 font-medium italic">No customer feedback yet.</p>
                @endif
            </div>

        </div>

        <!-- ===== RECENT ORDERS + TOP ITEMS + MENU STATUS ===== -->
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Recent Orders Feed -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-10">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-800">Order History</h3>
                </div>
                @if(count($recentOrders) > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors px-1 rounded-lg">
                                <div>
                                    <p class="font-black text-gray-900 text-sm">Order #{{ $order->order_id }}</p>
                                    <p class="text-[11px] text-gray-400 font-bold uppercase">{{ $order->customer_name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-gray-900 text-sm">৳{{ number_format($order->total_amount, 0) }}</p>
                                    @php
                                        $colors = [
                                            'delivered' => 'text-green-600',
                                            'pending'   => 'text-yellow-600',
                                            'confirmed' => 'text-blue-600',
                                            'preparing' => 'text-orange-600',
                                            'cancelled' => 'text-red-600',
                                            'ready'     => 'text-teal-600',
                                        ];
                                        $c = $colors[$order->order_status] ?? 'text-gray-400';
                                    @endphp
                                    <span class="{{ $c }} text-[10px] font-black uppercase tracking-widest italic">{{ $order->order_status }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-10">Historical orders empty.</p>
                @endif
            </div>

            <!-- Top Sold Items -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-b from-white to-gray-50/30 mb-10">
                <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center gap-2">
                    <i data-feather="award" class="text-orange-500 w-5 h-5"></i>
                    Top Sold Items
                </h3>
                @if(count($topItems) > 0)
                    <div class="space-y-5">
                        @foreach($topItems as $i => $item)
                            <div class="flex justify-between items-center group">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-100 text-[10px] font-black text-gray-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">0{{ $i + 1 }}</span>
                                    <span class="text-sm font-bold text-gray-700">{{ $item->item_name }}</span>
                                </div>
                                <div class="text-right">
                                    <p class="font-black text-sm text-gray-900">{{ $item->total_quantity_sold }} <span class="text-[10px] text-gray-400 font-medium">Sold</span></p>
                                    <p class="text-[10px] text-green-500 font-black tracking-tighter italic">+৳{{ number_format($item->total_revenue_from_item, 0) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-10">Ranking items...</p>
                @endif
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