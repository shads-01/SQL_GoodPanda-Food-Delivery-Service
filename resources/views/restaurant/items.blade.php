<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
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
                <p class="text-orange-500 font-bold uppercase tracking-widest text-xs mb-2">Inventory Control</p>
                <h2 class="text-4xl font-black text-gray-900 tracking-tight font-sora">Menu Items</h2>
            </div>
            <a href="{{ route('restaurant.add_item') }}"
                class="bg-orange-500 px-6 py-3 rounded-xl text-sm font-bold text-white shadow-md hover:bg-orange-600 transition flex items-center gap-2">
                <i data-feather="plus" class="w-4 h-4"></i> Add New Dish
            </a>
        </div>

        <div class="flex flex-col gap-4">
            @foreach($items as $item)
                {{-- ... (existing item card) ... --}}
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 flex flex-row items-center gap-6 hover:shadow-md transition-shadow duration-300">

                    <div class="flex-none w-32 h-32 rounded-xl overflow-hidden bg-gray-100 relative"
                        style="min-width: 8rem;">
                        <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" class="w-full h-full object-cover">
                        @if($item->has_offer)
                            <div
                                class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-black tracking-wider px-2 py-1 rounded shadow-sm">
                                OFFER
                            </div>
                        @endif
                    </div>

                    <div class="flex-grow min-w-0 py-2">
                        <div class="flex items-center gap-3 mb-1">
                            <h4 class="font-bold text-gray-900 text-xl font-sora truncate">{{ $item->item_name }}</h4>
                            <span
                                class="bg-gray-100 text-gray-600 text-[10px] uppercase font-bold tracking-wider px-2 py-1 rounded-md">
                                {{ $item->category_name }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 line-clamp-2 mb-3 pr-4">{{ $item->description }}</p>

                        @if($item->is_available)
                            <span class="text-emerald-600 text-xs font-bold uppercase tracking-wide flex items-center gap-1.5">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 me-1"></div> Live on Store
                            </span>
                        @else
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-wide flex items-center gap-1.5">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400 me-1"></div> Hidden
                            </span>
                        @endif
                    </div>

                    <div class="flex-none ml-auto flex items-center gap-6 pl-4">

                        <div class="text-right">
                            @if($item->has_offer)
                                <p class="text-xs text-gray-400 line-through mb-0.5">
                                    ৳{{ number_format($item->original_price, 0) }}</p>
                                <p class="text-2xl font-black text-orange-600 font-sora leading-none">
                                    ৳{{ number_format($item->discounted_price, 0) }}</p>
                            @else
                                <p class="text-2xl font-black text-gray-900 font-sora leading-none">
                                    ৳{{ number_format($item->price, 0) }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('restaurant.item.details', $item->item_id) }}" title="Edit Dish"
                                class="p-2.5 bg-white text-gray-500 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition-colors border border-gray-200 shadow-sm">
                                <i data-feather="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('restaurant.deleteItem', $item->item_id) }}" method="POST"
                                onsubmit="return confirm('Delete this dish?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete Dish"
                                    class="p-2.5 bg-white text-gray-500 rounded-xl hover:bg-red-50 hover:text-red-600 transition-colors border border-gray-200 shadow-sm">
                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

        @if($items->hasPages())
            <div class="pagination">
                {{ $items->appends(request()->query())->links('vendor.pagination.custom') }}
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