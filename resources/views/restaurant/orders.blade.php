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
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: inline-block;
        }


        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-confirmed {
            background: #E0E7FF;
            color: #3730A3;
        }

        .status-preparing {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-ready {
            background: #F3E8FF;
            color: #6B21A8;
        }

        .status-on_the_way {
            background: #FFF7ED;
            color: #9A3412;
            border: 1px solid #FED7AA;
        }

        .status-delivered {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Custom Pagination Styling */
        .pagination-container nav div:first-child {
            display: none;
        }

        .pagination-container nav div:last-child {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
        }

        .pagination-container nav span[aria-current="page"] span {
            background-color: #F97316 !important;
            color: white !important;
            border-color: #F97316 !important;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.1);
        }

        .pagination-container nav a,
        .pagination-container nav span {
            border-radius: 0.75rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            transition: all 0.2s !important;
            border: 1.5px solid #F3F4F6 !important;
            color: #6B7280 !important;
        }

        .pagination-container nav a:hover {
            border-color: #F97316 !important;
            color: #F97316 !important;
            background-color: #FFF7ED !important;
        }
    </style>
</head>

<body class="bg-[#FAFAF9]">

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="p-8 max-w-7xl mx-auto">
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-orange-500 font-bold uppercase tracking-widest text-xs mb-2">Live Fulfillment</p>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight font-sora">
                    Order History
                </h2>
                <p class="text-gray-400 mt-2 font-medium">Keep track of every meal delivered to your customers.</p>
            </div>
            <div class="flex gap-2 bg-white p-1 rounded-2xl shadow-sm border border-gray-100">
                <button class="px-5 py-2 rounded-xl text-xs font-bold bg-gray-900 text-black shadow-lg">All Orders</button>
                <button class="px-5 py-2 rounded-xl text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">Pending</button>
                <button class="px-5 py-2 rounded-xl text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">Completed</button>
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
                                <span class="order-status-badge status-{{ strtolower($order->order_status) }}">
                                    @if($order->order_status === 'on_the_way')
                                        ON THE WAY
                                    @else
                                        {{ ucfirst($order->order_status) }}
                                    @endif
                                </span>
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
        <div class="mt-10 pb-10 pagination-container">
            {{ $orders->links() }}
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