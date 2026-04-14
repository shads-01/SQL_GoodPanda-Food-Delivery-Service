<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers Management | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
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

<body class="bg-[#FAFAF9] text-gray-800">

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="p-8 max-w-5xl mx-auto pb-20">
        <div class="mb-10 flex items-end justify-between gap-6">
            <div>
                <p class="text-orange-500 font-bold uppercase tracking-widest text-xs mb-2">Promotions</p>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight font-sora">Active Offers</h2>
            </div>
            <a href="{{ route('restaurant.add_offer') }}"
                class="bg-orange-500 px-6 py-3 rounded-xl text-sm font-bold text-white shadow-md hover:bg-orange-600 transition flex items-center gap-2">
                <i data-feather="zap" class="w-4 h-4"></i> Create New Offer
            </a>
        </div>

        {{-- Alerts & Errors --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8 text-red-600 font-medium text-sm flex items-center gap-2">
                <i data-feather="alert-octagon" class="w-4 h-4"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-8 text-emerald-700 font-medium text-sm flex items-center gap-2">
                <i data-feather="check-circle" class="w-4 h-4"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            @forelse($offers as $offer)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex flex-row items-center gap-6 hover:shadow-md transition-shadow duration-300">

                    <div class="flex-none w-24 h-24 rounded-xl overflow-hidden bg-orange-50 flex items-center justify-center text-orange-400 border border-orange-100">
                        <i data-feather="gift" class="w-10 h-10"></i>
                    </div>

                    <div class="flex-grow min-w-0 py-2">
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="font-bold text-gray-900 text-xl font-sora truncate">{{ $offer->offer_title }}</h4>
                            <span class="bg-gray-100 text-gray-600 text-[10px] uppercase font-bold tracking-wider px-2 py-1 rounded-md">
                                {{ strtoupper($offer->target_type) }} 
                                {{ $offer->target_type === 'item' && $offer->item_name ? ' - ' . $offer->item_name : '' }}
                                {{ $offer->target_type === 'category' && $offer->category_name ? ' - ' . $offer->category_name : '' }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 mb-2 font-medium">Valid from {{ \Carbon\Carbon::parse($offer->start_datetime)->format('M d, Y h:ia') }} to {{ \Carbon\Carbon::parse($offer->end_datetime)->format('M d, Y h:ia') }}</p>

                        @if($offer->min_order_amount)
                            <span class="text-indigo-600 bg-indigo-50 border border-indigo-100 text-xs font-bold px-2 py-1 rounded-lg shadow-sm">Min. Order: ৳{{ number_format($offer->min_order_amount, 0) }}</span>
                        @endif
                    </div>

                    <div class="flex-none ml-auto flex items-center gap-6 pl-4">

                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-widest mb-1">{{ str_replace('_', ' ', $offer->discount_type) }}</p>
                            <p class="text-2xl font-black text-orange-600 font-sora leading-none">
                                @if($offer->discount_type === 'percentage')
                                    {{ rtrim(rtrim($offer->discount_value, '0'), '.') }}% OFF
                                @elseif($offer->discount_type === 'flat')
                                    ৳{{ rtrim(rtrim($offer->discount_value, '0'), '.') }} OFF
                                @else
                                    FREE
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="#" onclick="alert('Offer editing requires custom modal design.')" title="Edit Offer"
                                class="p-2.5 bg-white text-gray-500 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition-colors border border-gray-200 shadow-sm">
                                <i data-feather="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('restaurant.deleteOffer', $offer->offer_id) }}" method="POST"
                                onsubmit="return confirm('Delete this offer permanently?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Offer"
                                    class="p-2.5 bg-white text-gray-500 rounded-xl hover:bg-red-50 hover:text-red-600 transition-colors border border-gray-200 shadow-sm">
                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @empty
                <div class="py-16 flex flex-col items-center justify-center text-gray-400 bg-white border border-gray-100 rounded-2xl shadow-sm">
                    <i data-feather="sun" class="w-12 h-12 mb-4 text-orange-200"></i>
                    <p class="font-bold text-lg text-gray-500">No active offers right now.</p>
                    <p class="text-sm font-medium mt-1">Create one to boost your sales!</p>
                </div>
            @endforelse
        </div>

        @if($offers->hasPages())
            <div class="pagination">
                {{ $offers->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace({ 'stroke-width': 2.5 });
        });
    </script>
</body>

</html>
