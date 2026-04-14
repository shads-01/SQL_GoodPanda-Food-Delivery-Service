<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Management | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }

        .order-status-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
        }

        .status-pending {
            background: #FAEEDA;
            color: #854F0B;
        }

        .status-confirmed {
            background: #E6F1FB;
            color: #185FA5;
        }

        .status-preparing {
            background: #FFF7ED;
            color: #C2410C;
        }

        .status-ready {
            background: #EAF3DE;
            color: #3B6D11;
        }

        .status-on_the_way {
            background: #FFF7ED;
            color: #9A3412;
        }

        .status-delivered {
            background: #EAF3DE;
            color: #3B6D11;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }
                .status-select-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            border-radius: 100px;
            padding: 4px 8px 4px 10px;
            gap: 4px;
            cursor: pointer;
            transition: filter 0.15s;
        }

        .status-select-wrap:hover {
            filter: brightness(0.95);
        }

        .status-select {
            appearance: none;
            -webkit-appearance: none;
            background: transparent;
            border: none;
            outline: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: inherit;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .status-chevron {
            width: 8px;
            height: 8px;
            flex-shrink: 0;
            color: inherit;
            opacity: 0.7;
            pointer-events: none;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.4rem 0.8rem;
            border: 1px solid #E7E5E4;
            border-radius: 8px;
            font-size: 0.85rem;
            text-decoration: none;
            color: #1C1917;
            font-weight: 600;
        }

        .pagination a:hover {
            border-color: #F97316;
            color: #F97316;
        }

        .pagination span[aria-current="page"] span,
        .pagination .active {
            background: #F97316;
            color: white;
            border-color: #F97316;
        }
    </style>
</head>

<body class="bg-[#FAFAF9]">

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="p-8 max-w-7xl mx-auto">
        <div class="mb-8">
            <p class="text-orange-500 font-bold uppercase tracking-widest text-xs mb-2">Live Fulfillment</p>
            <h2 class="text-4xl font-black text-gray-900 tracking-tight font-sora">
                Order History
            </h2>
            <p class="text-gray-400 mt-2 font-medium">Keep track of every meal delivered to your customers.</p>
        </div>

        <div class="flex justify-center mb-8">
            <div class="flex flex-wrap justify-center gap-2 bg-white p-1 rounded-2xl shadow-sm border border-gray-100">
                <a href="{{ route('restaurant.orders', ['filter' => 'all']) }}" 
                   class="px-5 py-2 rounded-xl text-xs font-bold transition-colors inline-block {{ $filter === 'all' ? 'bg-gray-900 !text-white shadow-lg' : 'text-gray-400 hover:text-gray-600' }}">
                   All Orders
                </a>
                <a href="{{ route('restaurant.orders', ['filter' => 'pending']) }}" 
                   class="px-5 py-2 rounded-xl text-xs font-bold transition-colors inline-block {{ $filter === 'pending' ? 'bg-gray-900 !text-white shadow-lg' : 'text-gray-400 hover:text-gray-600' }}">
                   Active
                </a>
                <a href="{{ route('restaurant.orders', ['filter' => 'completed']) }}" 
                   class="px-5 py-2 rounded-xl text-xs font-bold transition-colors inline-block {{ $filter === 'completed' ? 'bg-gray-900 !text-white shadow-lg' : 'text-gray-400 hover:text-gray-600' }}">
                   Completed
                </a>
                <a href="{{ route('restaurant.orders', ['filter' => 'cancelled']) }}" 
                   class="px-5 py-2 rounded-xl text-xs font-bold transition-colors inline-block {{ $filter === 'cancelled' ? 'bg-gray-900 !text-white shadow-lg' : 'text-gray-400 hover:text-gray-600' }}">
                   Cancelled
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            @if(count($orders) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th colspan="5" style="height: 2rem; border: none; background: transparent;"></th>
                        </tr>
                        <tr class="bg-gray-50/50">
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Order ID</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Customer</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">DateTime</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $order)
                        <tr class="hover:bg-orange-50/10 transition-colors group">
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-gray-900">#{{ $order->order_id }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center font-black text-orange-600 text-xs">
                                        {{ substr($order->customer_name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-700">{{ $order->customer_name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, H:i') }}</p>
                                <p class="text-[10px] text-gray-300 font-bold uppercase tracking-tighter">{{ \Carbon\Carbon::parse($order->order_datetime)->diffForHumans() }}</p>
                            </td>
                            <td class="px-8 py-6">
                                @if(in_array($order->order_status, ['pending', 'on_the_way', 'delivered', 'cancelled']))
                                    <span class="order-status-badge status-{{ strtolower($order->order_status) }}">
                                        @if($order->order_status === 'on_the_way')
                                            ON THE WAY
                                        @else
                                            {{ ucfirst($order->order_status) }}
                                        @endif
                                    </span>
                                @else
                                    <form action="{{ route('restaurant.updateOrderStatus', $order->order_id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <div class="status-select-wrap status-{{ strtolower($order->order_status) }}">
                                            <select name="status" onchange="this.form.submit()" class="status-select">
                                                <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}
                                                    disabled hidden>Confirmed</option>
                                                <option value="preparing" {{ $order->order_status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                                <option value="ready" {{ $order->order_status === 'ready' ? 'selected' : '' }}>Ready
                                                </option>
                                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <svg class="status-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </form>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <p class="text-lg font-black text-gray-900">৳{{ number_format($order->total_amount, 0) }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-32 text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mb-6">
                    <i data-feather="clipboard" class="w-10 h-10 text-gray-200"></i>
                </div>
                <h4 class="font-black text-gray-800 text-2xl font-sora">No order history</h4>
                <p class="text-gray-400 max-w-xs mt-2 text-sm leading-relaxed font-medium">As soon as you receive your first order, it will appear here in chronological order.</p>
            </div>
            @endif
        </div>

        @if($orders->hasPages())
            <div class="pagination">
                {{ $orders->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>

</body>

</html>