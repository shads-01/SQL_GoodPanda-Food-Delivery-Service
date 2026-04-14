<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restaurant Detail | GoodPanda</title>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin 1s linear infinite;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 3rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
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
            background: white;
            transition: all 0.2s;
        }

        .pagination a:hover {
            border-color: #F97316;
            color: #F97316;
            background: #FFF7ED;
        }

        .pagination span[aria-current="page"] span,
        .pagination .active {
            background: #F97316;
            color: white;
            border-color: #F97316;
        }
    </style>
</head>

<body class="bg-gray-50 relative font-sans text-gray-800">


    @include('components.customer_navbar')


    <!-- Floating Offers Button -->
    <button id="openOffersBtn"
        class="fixed right-0 top-1/2 -translate-y-1/2 bg-gradient-to-b from-orange-400 to-orange-500 text-white px-2 py-5 rounded-l-2xl shadow-[-5px_0_15px_-3px_rgba(249,115,22,0.3)] z-[60] hover:pr-4 hover:-ml-2 transition-all duration-300 flex flex-col items-center gap-3 group">
        <span class="[writing-mode:vertical-lr] font-black tracking-widest text-xs rotate-180 uppercase">Offers</span>
    </button>

    <!-- Header Section (Restaurant Info) -->
    <header
        class="bg-white shadow-sm pt-8 pb-12 px-6 sm:px-10 lg:px-20 border-b border-gray-100 relative overflow-hidden">

        <!-- Back Button -->
        <a href="{{ url()->previous() === url()->current() ? route('home') : url()->previous() }}"
            class="inline-flex items-center gap-2 mb-5 text-sm font-bold text-gray-500 hover:text-orange-500 transition-colors group">
            <span class="w-8 h-8 rounded-full bg-gray-100 group-hover:bg-orange-50 group-hover:border-orange-200 border border-gray-200 flex items-center justify-center transition-colors">
                <i data-feather="arrow-left" class="w-4 h-4"></i>
            </span>
            Back
        </a>

        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>

        <div
            class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-8 relative z-10">
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    <span
                        class="bg-orange-100 text-orange-600 font-black px-3 py-1.5 rounded-lg text-xs uppercase tracking-widest flex items-center gap-1.5 shadow-sm">
                        <i data-feather="star" class="w-3.5 h-3.5 fill-current"></i>
                        {{ number_format($restaurant->avg_rating, 1) }}
                    </span>
                    <span
                        class="text-sm font-bold text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">{{ $restaurant->total_reviews }}+
                        Reviews</span>
                    <span
                        class="text-sm font-bold text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 flex items-center gap-1"><i
                            data-feather="map-pin" class="w-3.5 h-3.5"></i> {{ $restaurant->location }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-gray-800 tracking-tight mb-3">{{ $restaurant->name }}
                </h1>
                <p class="text-gray-500 font-medium max-w-2xl text-sm md:text-base leading-relaxed mb-6">
                    <!-- Showing location/phone as description placeholder -->
                    Contact: {{ $restaurant->phone_number }} <br>
                    Welcome to {{ $restaurant->name }}! Explore our delicious offerings below.
                </p>
                <button onclick="openReviewsModal()"
                    class="bg-white border-2 border-gray-200 text-gray-700 font-bold px-6 py-2.5 rounded-xl hover:border-orange-500 hover:text-orange-500 transition-all text-sm shadow-sm flex items-center gap-2 group">
                    <i data-feather="message-square"
                        class="w-4 h-4 text-gray-400 group-hover:text-orange-500 transition-colors"></i> Read User
                    Reviews
                </button>
            </div>

            <div
                class="hidden md:block w-56 h-56 rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white rotate-2 hover:rotate-0 hover:scale-105 transition-all duration-500 flex-shrink-0 bg-gray-100">
                <img src="{{ $restaurant->cover_image ?? 'https://images.unsplash.com/photo-1552566626-52f8b828add9?q=80&w=600&auto=format&fit=crop' }}"
                    class="w-full h-full object-cover">
            </div>
        </div>
    </header>

    <!-- Search & Filter Bar (Sticky) -->
    <div
        class="sticky top-[68px] sm:top-[76px] z-40 bg-white/80 backdrop-blur-xl shadow-sm border-b border-gray-200/50 py-3 px-6 sm:px-10 lg:px-20 transition-all">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-4 items-center">

            <!-- Search -->
            <form action="{{ route('restaurant.details', $restaurant->restaurant_id) }}" method="GET"
                class="relative w-full md:w-80 flex-shrink-0">
                <i data-feather="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search menu by name..."
                    class="w-full pl-12 pr-12 py-3 bg-gray-100/50 border border-transparent rounded-2xl focus:bg-white focus:border-orange-400 transition-all font-bold text-sm text-gray-700 placeholder-gray-400">
                
                @if($search)
                    <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'category_id' => $categoryId, 'cuisine_id' => $cuisineId]) }}"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 bg-white/50 hover:bg-red-50 rounded-full p-1 transition-all" title="Clear Search">
                        <i data-feather="x" class="w-4 h-4"></i>
                    </a>
                @endif

                @if($categoryId)
                    <input type="hidden" name="category_id" value="{{ $categoryId }}">
                @endif
                @if($cuisineId)
                    <input type="hidden" name="cuisine_id" value="{{ $cuisineId }}">
                @endif
            </form>

            <div class="flex flex-col gap-2 w-full">
                <!-- Categories -->
                <div class="flex gap-2.5 overflow-x-auto w-full pb-1 hide-scrollbar scroll-smooth">
                    @if($categoryId)
                        <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'search' => $search, 'cuisine_id' => $cuisineId]) }}"
                            class="flex-shrink-0 px-4 py-2 rounded-xl font-bold text-xs transition-all border-2 border-red-100 bg-red-50 text-red-500 hover:bg-red-100 hover:border-red-200 shadow-sm flex items-center gap-1.5 focus:outline-none">
                            <i data-feather="x" class="w-3.5 h-3.5"></i> Clear Category
                        </a>
                    @else
                        <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'search' => $search, 'cuisine_id' => $cuisineId]) }}"
                            class="flex-shrink-0 px-4 py-2 rounded-xl font-bold text-xs transition-all border-2 bg-gray-800 text-white shadow-xl shadow-gray-200 border-transparent focus:outline-none">
                            All Categories
                        </a>
                    @endif

                    @forelse($categories as $category)
                        <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'category_id' => $category->category_id, 'search' => $search, 'cuisine_id' => $cuisineId]) }}"
                            class="flex-shrink-0 px-4 py-2 rounded-xl font-bold text-xs transition-all border-2 {{ $categoryId == $category->category_id ? 'bg-gray-800 text-white shadow-xl shadow-gray-200 border-transparent' : 'bg-white border-gray-100 text-gray-500 hover:border-orange-500 hover:text-orange-500 shadow-sm' }}">
                            {{ $category->category_name }}
                        </a>
                    @empty
                        <p class="text-gray-500 text-xs">No categories</p>
                    @endforelse
                </div>

                <!-- Cuisines -->
                <div class="flex gap-2.5 overflow-x-auto w-full pb-1 hide-scrollbar scroll-smooth">
                    @if($cuisineId)
                        <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'search' => $search, 'category_id' => $categoryId]) }}"
                            class="flex-shrink-0 px-4 py-2 rounded-xl font-bold text-xs transition-all border-2 border-red-100 bg-red-50 text-red-500 hover:bg-red-100 hover:border-red-200 shadow-sm flex items-center gap-1.5 focus:outline-none">
                            <i data-feather="x" class="w-3.5 h-3.5"></i> Clear Cuisine
                        </a>
                    @else
                        <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'search' => $search, 'category_id' => $categoryId]) }}"
                            class="flex-shrink-0 px-4 py-2 rounded-xl font-bold text-xs transition-all border-2 bg-gray-600 text-white shadow-xl shadow-gray-200 border-transparent focus:outline-none">
                            All Cuisines
                        </a>
                    @endif

                    @forelse($cuisines as $cuisine)
                        <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'cuisine_id' => $cuisine->cuisine_id, 'search' => $search, 'category_id' => $categoryId]) }}"
                            class="flex-shrink-0 px-4 py-2 rounded-xl font-bold text-xs transition-all border-2 {{ $cuisineId == $cuisine->cuisine_id ? 'bg-gray-600 text-white shadow-xl shadow-gray-200 border-transparent' : 'bg-white border-gray-100 text-gray-500 hover:border-orange-500 hover:text-orange-500 shadow-sm' }}">
                            {{ $cuisine->cuisine_name }}
                        </a>
                    @empty
                        <p class="text-gray-500 text-xs">No cuisines</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Main Content: Food Grid -->
    <main class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-20 py-12">

        <h2 class="text-2xl font-black text-gray-800 tracking-tight mb-8">Menu Items</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">

            @forelse($items as $item)
                <div class="item-card bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 group flex flex-col cursor-pointer"
                    data-item-id="{{ $item->item_id }}" data-category-id="{{ $item->category_id }}" data-price="{{ $item->price }}"
                    onclick="openItemModal({{ $item->item_id }}, {{ $item->category_id }}, '{{ addslashes($item->item_name) }}', '{{ addslashes($item->description ?? '') }}', {{ $item->price }}, '{{ $item->item_image }}')">
                    <div class="relative h-56 overflow-hidden bg-gray-100">
                        <img src="{{ $item->item_image }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <span
                            class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm">{{ $item->category_name }}</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3
                            class="font-black text-lg text-gray-800 leading-tight mb-2 group-hover:text-orange-500 transition-colors">
                            {{ $item->item_name }}</h3>
                        <p class="text-xs text-gray-400 line-clamp-2 mb-4 font-medium leading-relaxed flex-1">
                            {{ $item->description }}</p>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-50 mt-auto">
                            <span class="item-price-display font-black text-xl text-gray-800">৳{{ number_format($item->price, 2) }}</span>
                            <div
                                class="bg-orange-50 text-orange-500 p-2.5 rounded-xl transition-all shadow-sm group-hover:bg-orange-500 group-hover:text-white">
                                <i data-feather="plus" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-400 font-bold">
                    No items available for this restaurant yet.
                </div>
            @endforelse

        </div>

        @if($items->hasPages())
            <div class="pagination">
                {{ $items->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @endif

    </main>

    <!-- OVERLAYS & MODALS -->

    <!-- Overlay Background -->
    <div id="modalOverlay"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[110] hidden opacity-0 transition-opacity duration-300">
    </div>

    <!-- 1. Item Detail Modal -->
    <div id="itemModal"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-md bg-white rounded-[2.5rem] shadow-2xl z-[120] hidden opacity-0 scale-95 transition-all duration-300 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="relative h-64 sm:h-72 bg-gray-100 flex-shrink-0">
            <img id="modalImg" src="" class="w-full h-full object-cover">
            <button onclick="closeModals()"
                class="absolute top-5 right-5 bg-white/90 backdrop-blur-md p-2.5 rounded-full text-gray-800 hover:bg-white hover:scale-110 shadow-sm transition-all border border-gray-100">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
            <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-white to-transparent"></div>
        </div>
        <div class="px-8 pb-8 flex-1 overflow-y-auto -mt-6 relative z-10">
            <h2 id="modalTitle" class="text-3xl font-black text-gray-800 mb-3 leading-tight">Item Name</h2>
            <p id="modalDesc" class="text-gray-500 font-medium mb-8 text-sm leading-relaxed">Item description goes here.
            </p>

            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Unit Price</p>
                    <span id="modalPrice" class="text-3xl font-black text-gray-800">৳0.00</span>
                    <p id="modalPriceOriginal" class="text-sm font-bold text-gray-400 line-through hidden">৳0.00</p>
                </div>

                <!-- Quantity Selector -->
                <div class="flex items-center bg-gray-50 rounded-2xl p-1.5 border border-gray-200">
                    <button onclick="updateModalQty(-1)"
                        class="w-12 h-12 flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm rounded-xl transition-all">
                        <i data-feather="minus" class="w-5 h-5"></i>
                    </button>
                    <span id="modalQty" class="w-12 text-center font-black text-xl text-gray-800">1</span>
                    <button onclick="updateModalQty(1)"
                        class="w-12 h-12 flex items-center justify-center text-orange-500 bg-orange-50 hover:bg-white hover:shadow-sm rounded-xl transition-all border border-orange-100 hover:border-transparent">
                        <i data-feather="plus" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <button id="addToCartBtn"
                class="w-full bg-gray-900 text-white font-black text-base py-4 rounded-2xl shadow-xl hover:bg-black hover:scale-[1.02] transition-all flex justify-between items-center px-6 group disabled:opacity-70 disabled:pointer-events-none relative overflow-hidden">
                <span id="addToCartBtnText" class="flex items-center gap-2">
                    <i data-feather="shopping-cart" class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors"></i> 
                    Add to Cart
                </span>
                <span id="addToCartBtnLoading" class="hidden absolute inset-0 flex items-center justify-center bg-gray-900 z-10">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="ml-2">Adding...</span>
                </span>
                <span id="modalBtnTotal"
                    class="bg-gray-800 px-3 py-1 rounded-lg text-sm group-hover:bg-gray-700 transition-colors">৳0.00</span>
            </button>
        </div>
    </div>


    <!-- 2. Offers Modal -->
    <div id="offersModal"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-sm bg-white rounded-[2rem] shadow-2xl z-[120] hidden opacity-0 scale-95 transition-all duration-300 p-8 overflow-hidden">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-black text-gray-800 flex items-center gap-2">
                Active Offers
            </h2>
            <button onclick="closeModals()"
                class="p-2 bg-gray-50 border border-gray-100 rounded-full hover:bg-gray-100 transition-colors">
                <i data-feather="x" class="w-4 h-4 text-gray-500"></i>
            </button>
        </div>

        <!-- Offer Container -->
        <div id="offersContainer" class="relative max-h-96 overflow-y-auto pr-2 space-y-4">
            @forelse($offers as $offer)
            <div class="relative overflow-hidden rounded-[1.5rem] bg-gradient-to-br from-orange-400 to-orange-500 p-8 text-center text-white shadow-xl shadow-orange-200 border border-orange-300">
                <i data-feather="gift" class="w-10 h-10 mx-auto mb-3 opacity-80"></i>
                <h3 class="text-3xl font-black mb-2 tracking-tight">{{ $offer->offer_title }}</h3>
                
                <div class="font-bold text-orange-50 text-sm mb-3 max-w-[250px] mx-auto bg-black/10 rounded-lg py-2">
                    @if($offer->discount_type == 'percentage')
                        {{ (int)$offer->discount_value }}% OFF
                    @elseif($offer->discount_type == 'flat')
                        ৳{{ number_format($offer->discount_value, 2) }} OFF
                    @elseif($offer->discount_type == 'free_delivery')
                        FREE DELIVERY
                    @endif
                </div>

                <p class="font-medium text-orange-100 text-xs mb-6 max-w-[250px] mx-auto leading-relaxed">
                    Target:
                    <span class="font-bold text-white">
                        @if($offer->target_type == 'item')
                            {{ $offer->item_name }}
                        @elseif($offer->target_type == 'category')
                            {{ $offer->category_name }}
                        @else
                            Entire Restaurant
                        @endif
                    </span>
                    <br>
                    @if($offer->min_order_amount > 0)
                        Min Order: ৳{{ number_format($offer->min_order_amount, 2) }}
                    @else
                        No Minimum Order
                    @endif
                    <br>
                    <span class="opacity-75">Valid until: {{ date('M d, Y h:i A', strtotime($offer->end_datetime)) }}</span>
                </p>
                
                <button id="offerBtn_{{ $offer->offer_id }}" onclick="availOffer({{ $offer->offer_id }})"
                    class="offer-avail-btn bg-white text-orange-500 font-black px-8 py-3 rounded-xl text-sm hover:scale-105 transition-transform shadow-md uppercase tracking-wider relative z-10 w-full active:scale-95">
                    Avail Offer
                </button>
            </div>
            @empty
            <div class="text-center py-10 px-6 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <i data-feather="frown" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-xl font-black mb-2 tracking-tight text-gray-800">No Active Deals</h3>
                <p class="font-medium text-gray-500 text-sm max-w-[200px] mx-auto">This restaurant currently has no active offers. Check back later!</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- 3. Reviews Modal -->
    <div id="reviewsModal"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[95%] max-w-lg bg-white rounded-[2rem] shadow-2xl z-[120] hidden opacity-0 scale-95 transition-all duration-300 flex flex-col max-h-[85vh] overflow-hidden">
        <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-xl font-black text-gray-800 flex items-center gap-2">
                    <i data-feather="message-circle" class="w-5 h-5 text-orange-500"></i> Recent Reviews
                </h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Showing last 10 reviews</p>
            </div>
            <button onclick="closeModals()"
                class="p-2 bg-white border border-gray-100 rounded-full hover:bg-red-50 hover:text-red-500 transition-all hover:rotate-90">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="p-6 overflow-y-auto space-y-6">
            @forelse($reviews as $rev)
            <div class="bg-gray-50/30 rounded-2xl p-5 border border-gray-100/50 hover:bg-white hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-black">
                            {{ strtoupper(substr($rev->reviewer_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-black text-gray-800 text-sm">{{ $rev->reviewer_name }}</h4>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($rev->review_datetime)->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <div class="flex items-center gap-1 bg-white px-2 py-1 rounded-lg shadow-sm border border-gray-50">
                            <i data-feather="star" class="w-3 h-3 text-orange-500 fill-orange-500"></i>
                            <span class="text-xs font-black text-gray-800">{{ number_format($rev->restaurant_rating, 1) }}</span>
                        </div>
                    </div>
                </div>
                
                @if($rev->comment)
                <div class="relative pl-4 border-l-2 border-orange-200 py-1">
                    <p class="text-sm text-gray-600 font-medium leading-relaxed italic">"{{ $rev->comment }}"</p>
                </div>
                @else
                <p class="text-xs text-gray-300 italic font-medium">No comment provided.</p>
                @endif
            </div>
            @empty
            <div class="text-center py-12 px-6">
                <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-gray-200">
                    <i data-feather="message-square" class="w-8 h-8 text-gray-300 opacity-50"></i>
                </div>
                <h3 class="text-xl font-black mb-2 tracking-tight text-gray-800">No reviews yet</h3>
                <p class="font-medium text-gray-500 text-sm max-w-[200px] mx-auto">Be the first to share your experience after ordering!</p>
            </div>
            @endforelse
        </div>
        
        <div class="p-6 bg-gray-50/50 border-t border-gray-100 mt-auto flex justify-center flex-shrink-0">
             <button onclick="closeModals()" class="px-8 py-3 bg-gray-800 text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-black transition-all shadow-lg active:scale-95">Close</button>
        </div>
    </div>

    <script>
        // ── Constants for THIS restaurant page ──
        const CSRF_TOKEN    = document.querySelector('meta[name="csrf-token"]').content;
        const RESTAURANT_ID = {{ $restaurant->restaurant_id }};
        const CART_ADD_URL  = "{{ route('cart.add') }}";

        // ── Offers for this restaurant ──
        window.activeOffersList = @json($offers);
        window.restaurantId     = RESTAURANT_ID;

        // Restore active offer from sessionStorage
        const savedOfferId = sessionStorage.getItem('goodpanda_offer_' + RESTAURANT_ID);
        window.activeOffer = savedOfferId
            ? window.activeOffersList.find(o => parseInt(o.offer_id) == savedOfferId)
            : null;

        let currentModalItem = null;

        function saveOfferState() {
            if (window.activeOffer) {
                sessionStorage.setItem('goodpanda_offer_' + RESTAURANT_ID, window.activeOffer.offer_id);
            } else {
                sessionStorage.removeItem('goodpanda_offer_' + RESTAURANT_ID);
            }
            // Push the current offer into the navbar's offer state too
            window.gpActiveOffer  = window.activeOffer;
            window.gpOffersList   = window.activeOffersList;
        }

        // ── Delegate cart open/close to navbar ──
        function openCart()  { if (typeof gpOpenCart  === 'function') gpOpenCart();  }
        function closeCart() { if (typeof gpCloseCart === 'function') gpCloseCart(); }

        // ── API helper (page-level, for add to cart only) ──
        async function apiFetch(url, options = {}) {
            const defaults = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept':       'application/json',
                },
            };
            const res  = await fetch(url, { ...defaults, ...options, headers: { ...defaults.headers, ...(options.headers || {}) } });
            const json = await res.json();
            if (!res.ok) throw new Error(json.message || 'API error');
            return json;
        }

        // ── loadCart / renderCart delegate to navbar ──
        async function loadCart() {
            if (typeof gpLoadCart === 'function') {
                await gpLoadCart();
            }
        }

        function renderCart() {
            if (typeof gpRenderCart === 'function') gpRenderCart();
        }

        // ── updateCartQty delegates to navbar ──
        window.updateCartQty = async function(id, change) {
            if (typeof gpUpdateQty === 'function') {
                await gpUpdateQty(id, change);
                // Sync active offer to navbar state
                window.gpActiveOffer = window.activeOffer;
            }
        };

        // ── clearCart delegates to navbar ──
        window.clearCart = async function() {
            window.activeOffer = null;
            saveOfferState();
            updateGridPrices();
            if (typeof gpClearCart === 'function') await gpClearCart();
        };

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') feather.replace();

            // Sync offer state into navbar on load
            window.gpActiveOffer = window.activeOffer;
            window.gpOffersList  = window.activeOffersList;
            window.gpRestaurantId = RESTAURANT_ID;

            // Load cart via the navbar
            loadCart();

            // cartBtn is now owned by the navbar; wire up the offer button
            document.getElementById('openOffersBtn').addEventListener('click', openOffersModal);

            // Restore offer visual state
            if (window.activeOffer) {
                updateGridPrices();
                updateOfferModalButtons();
            }
        });

        const overlay     = document.getElementById('modalOverlay');
        const itemModal   = document.getElementById('itemModal');
        const offersModal = document.getElementById('offersModal');
        const reviewsModal = document.getElementById('reviewsModal');

        function toggleOverlay(show) {
            if (show) {
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }

        function closeModals() {
            toggleOverlay(false);
            [itemModal, offersModal, reviewsModal].forEach(modal => {
                modal.classList.remove('opacity-100', 'scale-100');
                modal.classList.add('opacity-0', 'scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            });
            currentModalItem = null;
        }

        overlay.addEventListener('click', closeModals);

        function calculateDiscount(basePrice, testCategory = null, testItem = null) {
            if (!window.activeOffer) return basePrice;
            const offer = window.activeOffer;

            let isApplicable = false;
            if (offer.target_type === 'category' && offer.target_category_id == testCategory) isApplicable = true;
            else if (offer.target_type === 'item'     && offer.target_item_id     == testItem)     isApplicable = true;

            if (isApplicable) {
                if (offer.discount_type === 'percentage') return Math.max(0, basePrice - (basePrice * (offer.discount_value / 100)));
                if (offer.discount_type === 'flat')       return Math.max(0, basePrice - offer.discount_value);
            }
            return basePrice;
        }

        window.availOffer = function(offerId) {
            const newOffer = window.activeOffersList.find(o => parseInt(o.offer_id) === parseInt(offerId));
            if (!newOffer) { console.error('Offer not found!'); return; }

            if (window.activeOffer && window.activeOffer.offer_id !== newOffer.offer_id) {
                if (!confirm(`You currently have "${window.activeOffer.offer_title}" applied. Replace with "${newOffer.offer_title}"?`)) return;
            }

            window.activeOffer = newOffer;
            closeModals();
            updateGridPrices();
            saveOfferState();
            renderCart();
            updateOfferModalButtons();
            alert(`Offer "${window.activeOffer.offer_title}" successfully applied!`);
        };

        function updateOfferModalButtons() {
            document.querySelectorAll('.offer-avail-btn').forEach(btn => {
                const offerId = btn.id.split('_')[1];
                if (window.activeOffer && parseInt(window.activeOffer.offer_id) === parseInt(offerId)) {
                    btn.innerHTML = '<i data-feather="check-circle" class="w-4 h-4 inline-block mr-1"></i> APPLIED';
                    btn.classList.add('bg-green-500', 'text-white');
                    btn.classList.remove('bg-white', 'text-orange-500');
                } else {
                    btn.innerHTML = 'Avail Offer';
                    btn.classList.add('bg-white', 'text-orange-500');
                    btn.classList.remove('bg-green-500', 'text-white');
                }
            });
            if (typeof feather !== 'undefined') feather.replace();
        }

        function updateGridPrices() {
            document.querySelectorAll('.item-card').forEach(card => {
                const basePrice      = parseFloat(card.dataset.price);
                const categoryId     = card.dataset.categoryId;
                const itemId         = card.dataset.itemId;
                const priceDisplay   = card.querySelector('.item-price-display');
                const discountedPrice = calculateDiscount(basePrice, categoryId, itemId);

                if (discountedPrice < basePrice) {
                    priceDisplay.innerHTML = `<span class="line-through text-gray-400 text-sm mr-1">৳${basePrice.toFixed(2)}</span> <span class="text-orange-500">৳${discountedPrice.toFixed(2)}</span>`;
                } else {
                    priceDisplay.innerHTML = `৳${basePrice.toFixed(2)}`;
                }
            });
        }

        window.openItemModal = function(itemId, categoryId, name, desc, price, img) {
            currentModalItem = { id: itemId, category_id: categoryId, name, price, qty: 1 };

            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalDesc').innerText  = desc;

            const discountedPrice  = calculateDiscount(price, categoryId, itemId);
            document.getElementById('modalPrice').innerText = `৳${discountedPrice.toFixed(2)}`;

            const originPriceEl = document.getElementById('modalPriceOriginal');
            if (discountedPrice < price) {
                originPriceEl.innerText = `৳${price.toFixed(2)}`;
                originPriceEl.classList.remove('hidden');
                currentModalItem.calculatedPrice = discountedPrice;
            } else {
                originPriceEl.classList.add('hidden');
                currentModalItem.calculatedPrice = price;
            }
            document.getElementById('modalImg').src = img;
            updateModalUI();

            toggleOverlay(true);
            itemModal.classList.remove('hidden');
            setTimeout(() => itemModal.classList.replace('scale-95', 'scale-100'), 10);
            setTimeout(() => itemModal.classList.replace('opacity-0', 'opacity-100'), 10);
        };

        window.updateModalQty = function(change) {
            if (!currentModalItem) return;
            const newQty = currentModalItem.qty + change;
            if (newQty > 0) { currentModalItem.qty = newQty; updateModalUI(); }
        };

        function updateModalUI() {
            if (!currentModalItem) return;
            document.getElementById('modalQty').innerText = currentModalItem.qty;
            const priceToUse = currentModalItem.calculatedPrice || currentModalItem.price;
            document.getElementById('modalBtnTotal').innerText = `৳${(priceToUse * currentModalItem.qty).toFixed(2)}`;
        }

        document.getElementById('addToCartBtn').addEventListener('click', () => {
            if (currentModalItem) addToCart(currentModalItem);
        });

        function openOffersModal() {
            toggleOverlay(true);
            offersModal.classList.remove('hidden');
            setTimeout(() => offersModal.classList.replace('scale-95',  'scale-100'), 10);
            setTimeout(() => offersModal.classList.replace('opacity-0', 'opacity-100'), 10);
        }

        window.openReviewsModal = function() {
            toggleOverlay(true);
            reviewsModal.classList.remove('hidden');
            if (typeof feather !== 'undefined') feather.replace();
            setTimeout(() => reviewsModal.classList.replace('scale-95',  'scale-100'), 10);
            setTimeout(() => reviewsModal.classList.replace('opacity-0', 'opacity-100'), 10);
        }

        function openCart() {
            const dropdown = document.getElementById('cartDropdown');
            dropdown.classList.remove('hidden');
            setTimeout(() => dropdown.classList.replace('opacity-0', 'opacity-100'), 10);
            setTimeout(() => dropdown.classList.replace('translate-y-4', 'translate-y-0'), 10);
        }

        function closeCart() {
            const dropdown = document.getElementById('cartDropdown');
            dropdown.classList.replace('opacity-100', 'opacity-0');
            dropdown.classList.replace('translate-y-0', 'translate-y-4');
            setTimeout(() => dropdown.classList.add('hidden'), 200);
        }

        // ── addToCart: posts to API, then delegates reload to the navbar ──
        async function addToCart(item) {
            // ── Single-restaurant cart enforcement ──
            if (window.gpRestaurantId && window.gpRestaurantId != RESTAURANT_ID && window.gpCart && window.gpCart.length > 0) {
                const confirmed = confirm(
                    `Your cart already has items from a different restaurant.\n\nClear the current cart and start a new order from ${document.title.split('|')[0].trim()}?`
                );
                if (!confirmed) return;

                // Clear the previous restaurant's cart
                try {
                    await apiFetch('/api/cart/clear', {
                        method: 'POST',
                        body: JSON.stringify({ restaurant_id: window.gpRestaurantId }),
                    });
                } catch (e) {
                    console.error('Failed to clear old cart:', e.message);
                }
                window.gpActiveOffer = null;
                window.gpRestaurantId = null;
                sessionStorage.removeItem('goodpanda_offer_' + RESTAURANT_ID);
                window.activeOffer = null;
                saveOfferState();
                updateGridPrices();
            }

            const btn       = document.getElementById('addToCartBtn');
            const btnText   = document.getElementById('addToCartBtnText');
            const btnLoading = document.getElementById('addToCartBtnLoading');
            const btnTotal  = document.getElementById('modalBtnTotal');

            btn.disabled = true;
            btnText.classList.add('opacity-0');
            btnTotal.classList.add('opacity-0');
            btnLoading.classList.remove('hidden');

            try {
                await apiFetch(CART_ADD_URL, {
                    method: 'POST',
                    body: JSON.stringify({
                        restaurant_id: RESTAURANT_ID,
                        item_id:       item.id,
                        quantity:      item.qty,
                        unit_price:    item.price,
                    }),
                });
            } catch (e) {
                console.error('addToCart failed:', e.message);
                alert('Failed to add item to cart. Please try again.');
                btn.disabled = false;
                btnText.classList.remove('opacity-0');
                btnTotal.classList.remove('opacity-0');
                btnLoading.classList.add('hidden');
                return;
            }

            btn.disabled = false;
            btnText.classList.remove('opacity-0');
            btnTotal.classList.remove('opacity-0');
            btnLoading.classList.add('hidden');

            closeModals();

            // Sync offer and reload via navbar
            window.gpActiveOffer  = window.activeOffer;
            window.gpOffersList   = window.activeOffersList;
            window.gpRestaurantId = RESTAURANT_ID;
            await window.gpLoadCart();
            openCart();

            // ── Show "Added to cart" Toast ──
            const t = document.createElement('div');
            t.textContent = '✓ Added to cart!';
            t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#1C1917;color:white;padding:0.6rem 1.1rem;border-radius:8px;font-size:0.875rem;z-index:9999;transition:opacity 0.4s;';
            document.body.appendChild(t);
            setTimeout(() => { t.style.opacity = '0'; }, 2000);
            setTimeout(() => t.remove(), 2500);
        }

        function renderCart() {
            // Delegate to the global navbar cart renderer
            if (typeof gpRenderCart === 'function') gpRenderCart();
        }

    </script>
</body>

</html>
