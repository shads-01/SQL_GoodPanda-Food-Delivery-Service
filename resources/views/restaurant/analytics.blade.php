<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Business Analytics | {{ $restaurant->name }}</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-sora { font-family: 'Sora', sans-serif; }
    </style>
</head>

<body class="bg-[#FAFAF9]">

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="p-8 max-w-7xl mx-auto">
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <p class="text-orange-500 font-bold uppercase tracking-widest text-xs mb-2">Performance Metrics</p>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight font-sora">
                    Business Analytics
                </h2>
                <p class="text-gray-400 mt-2 font-medium">Deep dive into your sales, revenue, and product performance.</p>
            </div>
            <div class="flex gap-2">
                <button class="bg-white border border-gray-100 px-4 py-2 rounded-xl text-xs font-bold text-gray-500 shadow-sm hover:bg-gray-50 transition-colors">Export CSV</button>
                <button class="bg-orange-500 px-4 py-2 rounded-xl text-xs font-bold text-white shadow-md shadow-orange-100 hover:bg-orange-600 transition-colors">Weekly Report</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Key Performance Indicators -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Revenue Card -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <i data-feather="dollar-sign" class="w-24 h-24"></i>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Revenue</p>
                    <h3 class="text-3xl font-black text-gray-900 font-sora">৳{{ number_format($stats->total_revenue ?? 0, 0) }}</h3>
                    <div class="mt-6 p-4 rounded-2xl bg-green-50/50 border border-green-50">
                        <div class="flex items-center gap-2 text-green-600 font-bold text-xs mb-1">
                            <i data-feather="arrow-up" class="w-3 h-3"></i>
                            <span>Growth Spike</span>
                        </div>
                        <p class="text-[10px] text-green-700/70 font-medium">Your revenue is up by 15% compared to the previous period.</p>
                    </div>
                </div>

                <!-- Order Stats -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Order Summary</p>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div class="p-4 rounded-2xl bg-blue-50/30 border border-blue-50">
                            <p class="text-[10px] font-bold text-blue-400 uppercase">Total</p>
                            <p class="text-xl font-black text-blue-900">{{ $stats->total_completed_orders ?? 0 }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-purple-50/30 border border-purple-50">
                            <p class="text-[10px] font-bold text-purple-400 uppercase">Avg Value</p>
                            <p class="text-xl font-black text-purple-900">৳{{ number_format($stats->average_order_value ?? 0, 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Top Items Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden h-full">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-gray-800 font-sora">Bestsellers Ranking</h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 py-1 bg-gray-50 rounded-full border border-gray-100">Last 30 Days</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Rank</th>
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Item Name</th>
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Sold</th>
                                    <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($topItems as $i => $item)
                                    <tr class="hover:bg-orange-50/10 transition-colors">
                                        <td class="px-8 py-6">
                                            <span class="w-8 h-8 flex items-center justify-center rounded-lg {{ $i == 0 ? 'bg-orange-500 text-white shadow-lg shadow-orange-100' : 'bg-gray-50 text-gray-400' }} text-[10px] font-black">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <p class="font-bold text-gray-900 text-sm">{{ $item->item_name }}</p>
                                        </td>
                                        <td class="px-8 py-6 text-center">
                                            <p class="font-black text-gray-800 text-sm">{{ $item->total_quantity_sold }}</p>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <p class="font-black text-orange-600 text-sm">৳{{ number_format($item->total_revenue_from_item, 0) }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic font-medium">No sales data recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Future placeholder for charts -->
        <div class="mt-8 p-12 rounded-[3rem] bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 shadow-2xl relative overflow-hidden group">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_50%_50%,rgba(249,115,22,0.4),transparent)] group-hover:opacity-20 transition-opacity"></div>
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="p-4 bg-white/5 rounded-2xl backdrop-blur-md border border-white/10 mb-6">
                    <i data-feather="bar-chart-2" class="w-8 h-8 text-orange-500"></i>
                </div>
                <h4 class="text-2xl font-black text-white font-sora mb-2">Advanced Visualizations Coming Soon</h4>
                <p class="text-gray-400 max-w-md text-sm leading-relaxed">We're building interactive revenue charts and customer heatmaps to help you optimize your delivery zones.</p>
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
