<!DOCTYPE html>
<html>

<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    @include('restaurant.navbar')

    <div class="p-8 max-w-7xl mx-auto">
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight">Orders List</h2>
            </div>
        </div>

        @if(count($orders) > 0)
            <div class="flex flex-wrap gap-6">
                @foreach($orders as $order)
                            <div
                                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all flex-col flex justify-between min-w-[320px] max-w-[380px] flex-1">
                                <div>
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <p class="text-[11px] text-gray-400 font-black uppercase tracking-widest mb-3">
                                                {{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, h:i A') }}</p>
                                        </div>
                                        @php
                                            $colors = [
                                                'delivered' => 'bg-green-100 text-green-800 border-green-200',
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'preparing' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                'ready' => 'bg-teal-100 text-teal-800 border-teal-200',
                                            ];
                                            $c = $colors[strtolower($order->order_status)] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                     <span
                                            class="{{ $c }} px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border">
                                            {{ $order->order_status }}
                                        </span>
                                    </div>

                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-orange-50 rounded-full flex items-center justify-center text-orange-600 font-black text-sm">
                                                {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-gray-400 uppercase tracking-tighter">Customer</p>
                                                <p class="font-bold text-gray-800">{{ $order->customer_name }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center text-gray-400">
                                                <i data-feather="map-pin" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-gray-400 uppercase tracking-tighter">Delivery Address</p>
                                                <p class="font-medium text-gray-700 text-sm">{{ $order->delivery_address_line }}, {{ $order->delivery_address_city }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-5 border-t border-gray-50 flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase mb-0.5">Total Amount</p>
                                        <p class="text-2xl font-black text-gray-900 tracking-tighter">
                                            ৳{{ number_format($order->total_amount, 0) }}</p>
                                    </div>
                                </div>
                            </div>
                @endforeach
            </div>
        @else
            <div
                class="flex flex-col items-center justify-center py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                    <i data-feather="package" class="w-10 h-10 text-gray-200"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800">Your order book is empty!</h3>
                <p class="text-gray-400 max-w-xs mx-auto mt-2 font-medium">When customers place orders from your menu,
                    they'll appear here instantly.</p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();
        });
    </script>
</body>

</html>