<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>

<body class="bg-gray-50 relative font-sans text-gray-800">

    <!-- Top Navigation with Cart -->
    <nav
        class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm w-full py-4 px-6 sm:px-10 lg:px-20 flex justify-between items-center transition-all">
        <!-- Logo/Back -->
        <a href="{{ url('/') }}"
            class="text-xl font-black text-orange-500 tracking-tighter hover:scale-105 transition-transform inline-flex items-center">
            <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i> Back
        </a>

        <!-- Cart Icon Wrapper -->
        <div class="relative group">
            <button id="cartBtn"
                class="relative p-2.5 bg-orange-50 rounded-full text-orange-500 hover:bg-orange-100 hover:shadow-lg transition-all focus:outline-none">
                <i data-feather="shopping-cart" class="w-6 h-6"></i>
                <span id="cartCount"
                    class="absolute top-0 right-0 -mt-1 -mr-1 bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full hidden">0</span>
            </button>

            <!-- Cart Dropdown (Visible on hover/click) -->
            <div id="cartDropdown"
                class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100 z-[100] transform opacity-0 scale-95 transition-all duration-200 origin-top-right">
                <div class="p-5 bg-gradient-to-r from-orange-400 to-orange-500 text-white flex justify-between items-center">
                    <h3 class="font-black text-lg flex items-center gap-2">
                        <i data-feather="shopping-bag" class="w-5 h-5"></i> Your Order
                    </h3>
                    <button id="closeCartBtn" class="text-white hover:bg-white/20 p-1.5 rounded-full transition-all flex items-center justify-center">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Cart Items Container -->
                <div id="cartItemsList" class="max-h-72 overflow-y-auto p-5 space-y-4 bg-gray-50/50">
                    <!-- Placeholder for empty cart -->
                    <div id="emptyCartMessage" class="text-center text-gray-400 py-8">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-feather="shopping-cart" class="w-8 h-8 opacity-50"></i>
                        </div>
                        <p class="font-bold text-sm">Your cart is empty</p>
                        <p class="text-xs mt-1">Add some delicious items!</p>
                    </div>
                </div>

                <!-- Cart Footer -->
                <div
                    class="p-5 border-t border-gray-100 bg-white shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] relative z-10">
                    <div class="flex justify-between items-center mb-5">
                        <span class="font-bold text-gray-400 text-xs tracking-widest uppercase">Total Cost</span>
                        <span id="cartTotal" class="font-black text-2xl text-gray-800">$0.00</span>
                    </div>
                    <div class="flex gap-3">
                        <button id="clearCartBtn"
                            class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-gray-500 font-black hover:bg-gray-100 transition-colors text-sm uppercase tracking-wider disabled:opacity-50 disabled:pointer-events-none disabled:bg-gray-100">Clear</button>
                        <button id="checkoutBtn"
                            class="flex-[2] py-3 rounded-xl border-2 border-orange-500 bg-orange-500 text-white font-black hover:bg-orange-600 transition-colors shadow-lg shadow-orange-200 text-sm uppercase tracking-wider disabled:opacity-50 disabled:pointer-events-none disabled:shadow-none">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Floating Offers Button -->
    <button id="openOffersBtn"
        class="fixed right-0 top-1/2 -translate-y-1/2 bg-gradient-to-b from-orange-400 to-orange-500 text-white px-2 py-5 rounded-l-2xl shadow-[-5px_0_15px_-3px_rgba(249,115,22,0.3)] z-40 hover:pr-4 hover:-ml-2 transition-all duration-300 flex flex-col items-center gap-3 group">
        <span class="[writing-mode:vertical-lr] font-black tracking-widest text-xs rotate-180 uppercase">Offers</span>
    </button>

    <!-- Header Section (Restaurant Info) -->
    <header
        class="bg-white shadow-sm pt-8 pb-12 px-6 sm:px-10 lg:px-20 border-b border-gray-100 relative overflow-hidden">
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
                <button
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
                    <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'category_id' => $categoryId]) }}"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 bg-white/50 hover:bg-red-50 rounded-full p-1 transition-all" title="Clear Search">
                        <i data-feather="x" class="w-4 h-4"></i>
                    </a>
                @endif

                @if($categoryId)
                    <input type="hidden" name="category_id" value="{{ $categoryId }}">
                @endif
            </form>

            <!-- Categories -->
            <div class="flex gap-2.5 overflow-x-auto w-full pb-1 md:pb-0 hide-scrollbar scroll-smooth">
                @if($categoryId)
                    <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'search' => $search]) }}"
                        class="flex-shrink-0 px-4 py-2.5 rounded-xl font-bold text-sm transition-all border-2 border-red-100 bg-red-50 text-red-500 hover:bg-red-100 hover:border-red-200 shadow-sm flex items-center gap-1.5 focus:outline-none">
                        <i data-feather="x" class="w-4 h-4"></i> Clear Category
                    </a>
                @else
                    <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'search' => $search]) }}"
                        class="flex-shrink-0 px-6 py-2.5 rounded-xl font-bold text-sm transition-all border-2 bg-gray-800 text-white shadow-xl shadow-gray-200 border-transparent focus:outline-none">
                        All Categories
                    </a>
                @endif

                @forelse($categories as $category)
                    <a href="{{ route('restaurant.details', ['id' => $restaurant->restaurant_id, 'category_id' => $category->category_id, 'search' => $search]) }}"
                        class="flex-shrink-0 px-6 py-2.5 rounded-xl font-bold text-sm transition-all border-2 {{ $categoryId == $category->category_id ? 'bg-gray-800 text-white shadow-xl shadow-gray-200 border-transparent' : 'bg-white border-gray-100 text-gray-500 hover:border-orange-500 hover:text-orange-500 shadow-sm' }}">
                        {{ $category->category_name }}
                    </a>
                @empty
                    <p class="text-gray-500">No categories found</p>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Main Content: Food Grid -->
    <main class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-20 py-12">

        <h2 class="text-2xl font-black text-gray-800 tracking-tight mb-8">Menu Items</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">

            @forelse($items as $item)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 group flex flex-col cursor-pointer"
                    onclick="openItemModal({{ $item->item_id }}, '{{ addslashes($item->item_name) }}', '{{ addslashes($item->description ?? '') }}', {{ $item->price }}, '{{ $item->item_image }}')">
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
                            <span class="font-black text-xl text-gray-800">${{ number_format($item->price, 2) }}</span>
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
                    <span id="modalPrice" class="text-3xl font-black text-gray-800">$0.00</span>
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
                class="w-full bg-gray-900 text-white font-black text-base py-4 rounded-2xl shadow-xl hover:bg-black hover:scale-[1.02] transition-all flex justify-between items-center px-6 group">
                <span class="flex items-center gap-2"><i data-feather="shopping-cart"
                        class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors"></i> Add to Cart</span>
                <span id="modalBtnTotal"
                    class="bg-gray-800 px-3 py-1 rounded-lg text-sm group-hover:bg-gray-700 transition-colors">$0.00</span>
            </button>
        </div>
    </div>


    <!-- 2. Offers Modal -->
    <div id="offersModal"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-sm bg-white rounded-[2rem] shadow-2xl z-[120] hidden opacity-0 scale-95 transition-all duration-300 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-black text-gray-800 flex items-center gap-2">
                <i data-feather="percent" class="text-orange-500"></i> Active Deals
            </h2>
            <button onclick="closeModals()"
                class="p-2 bg-gray-50 border border-gray-100 rounded-full hover:bg-gray-100 transition-colors">
                <i data-feather="x" class="w-4 h-4 text-gray-500"></i>
            </button>
        </div>

        <div
            class="relative overflow-hidden rounded-[1.5rem] bg-gradient-to-br from-orange-400 to-orange-500 p-8 text-center text-white shadow-xl shadow-orange-200 mb-6 border border-orange-300">
            <i data-feather="gift" class="w-10 h-10 mx-auto mb-3 opacity-80"></i>
            <h3 id="offerTitle" class="text-4xl font-black mb-2 tracking-tight">20% OFF</h3>
            <p id="offerDesc" class="font-medium text-orange-50 text-sm mb-6 max-w-[200px] mx-auto">Use code PANDA20 on
                orders above $50.</p>
            <button
                class="bg-white text-orange-500 font-black px-8 py-3 rounded-xl text-sm hover:scale-105 transition-transform shadow-md uppercase tracking-wider">USE
                Code</button>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center bg-gray-50 rounded-2xl p-2 border border-gray-100">
            <button class="p-3 bg-white shadow-sm rounded-xl text-gray-600 hover:text-orange-500 transition-colors">
                <i data-feather="chevron-left" class="w-4 h-4"></i>
            </button>
            <div class="flex gap-2">
                <span class="w-2 h-2 rounded-full bg-gray-800"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
            </div>
            <button class="p-3 bg-white shadow-sm rounded-xl text-gray-600 hover:text-orange-500 transition-colors">
                <i data-feather="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>


    <script>
        // Global State simulating Cart
        let cart = [];
        let currentModalItem = null;

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') feather.replace();

            // Cart Click Logic
            const cartBtn = document.getElementById('cartBtn');
            const cartDropdown = document.getElementById('cartDropdown');

            cartBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (cartDropdown.classList.contains('hidden')) openCart();
                else closeCart();
            });

            // Close cart when clicking outside
            document.addEventListener('click', (e) => {
                if (!cartBtn.contains(e.target) && !cartDropdown.contains(e.target) && !cartDropdown.classList.contains('hidden')) {
                    closeCart();
                }
            });

            // Cart Footer Buttons
            document.getElementById('clearCartBtn').addEventListener('click', clearCart);
            document.getElementById('checkoutBtn').addEventListener('click', () => {
                if (cart.length > 0) alert('Proceeding to checkout...');
                else alert('Add items to your cart first!');
            });
            document.getElementById('closeCartBtn').addEventListener('click', (e) => {
                e.stopPropagation();
                closeCart();
            });

            // Offers Modal Triggers
            document.getElementById('openOffersBtn').addEventListener('click', openOffersModal);
        });

        // --- Modals & Overlays Controller ---
        const overlay = document.getElementById('modalOverlay');
        const itemModal = document.getElementById('itemModal');
        const offersModal = document.getElementById('offersModal');

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
            [itemModal, offersModal].forEach(modal => {
                modal.classList.remove('opacity-100', 'scale-100');
                modal.classList.add('opacity-0', 'scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            });
            currentModalItem = null;
        }

        overlay.addEventListener('click', closeModals);

        // --- Item Detail Modal Logic ---
        window.openItemModal = function (id, name, desc, price, img) {
            currentModalItem = { id, name, price, qty: 1 };

            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalDesc').innerText = desc;
            document.getElementById('modalPrice').innerText = `$${price.toFixed(2)}`;
            document.getElementById('modalImg').src = img;

            updateModalUI();

            toggleOverlay(true);
            itemModal.classList.remove('hidden');
            setTimeout(() => itemModal.classList.replace('scale-95', 'scale-100'), 10);
            setTimeout(() => itemModal.classList.replace('opacity-0', 'opacity-100'), 10);
        }

        window.updateModalQty = function (change) {
            if (!currentModalItem) return;
            const newQty = currentModalItem.qty + change;
            if (newQty > 0) {
                currentModalItem.qty = newQty;
                updateModalUI();
            }
        }

        function updateModalUI() {
            if (!currentModalItem) return;
            document.getElementById('modalQty').innerText = currentModalItem.qty;
            const total = currentModalItem.price * currentModalItem.qty;
            document.getElementById('modalBtnTotal').innerText = `$${total.toFixed(2)}`;
        }

        document.getElementById('addToCartBtn').addEventListener('click', () => {
            if (currentModalItem) {
                addToCart(currentModalItem);
                closeModals();
            }
        });


        // --- Offers Modal Logic ---
        function openOffersModal() {
            toggleOverlay(true);
            offersModal.classList.remove('hidden');
            setTimeout(() => offersModal.classList.replace('scale-95', 'scale-100'), 10);
            setTimeout(() => offersModal.classList.replace('opacity-0', 'opacity-100'), 10);
        }

        // --- Global Cart Logic ---
        function openCart() {
            const dropdown = document.getElementById('cartDropdown');
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('opacity-0', 'scale-95');
                dropdown.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeCart() {
            const dropdown = document.getElementById('cartDropdown');
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => dropdown.classList.add('hidden'), 200);
        }

        function addToCart(item) {
            const existing = cart.find(i => i.id === item.id);
            if (existing) {
                existing.qty += item.qty;
            } else {
                cart.push({ ...item });
            }
            renderCart();
            openCart();
        }

        window.updateCartQty = function (id, change) {
            const item = cart.find(i => i.id === id);
            if (item) {
                item.qty += change;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                }
                renderCart();
            }
        }

        function clearCart() {
            cart = [];

            renderCart();
        }

        function renderCart() {
            const list = document.getElementById('cartItemsList');
            const totalEl = document.getElementById('cartTotal');
            const countEl = document.getElementById('cartCount');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const clearCartBtn = document.getElementById('clearCartBtn');

            // Reset UI cleanly
            if (cart.length === 0) {
                list.innerHTML = `
                    <div id="emptyCartMessage" class="text-center text-gray-400 py-8">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-feather="shopping-cart" class="w-8 h-8 opacity-50"></i>
                        </div>
                        <p class="font-bold text-sm">Your cart is empty</p>
                        <p class="text-xs mt-1">Add some delicious items!</p>
                    </div>
                `;
                totalEl.innerText = '$0.00';
                countEl.innerText = '0';
                countEl.classList.add('hidden');
                checkoutBtn.disabled = true;
                clearCartBtn.disabled = true;
                if (typeof feather !== 'undefined') feather.replace();
                return;
            }

            list.innerHTML = '';
            checkoutBtn.disabled = false;
            clearCartBtn.disabled = false;

            let total = 0;
            let count = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                total += itemTotal;
                count += item.qty;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex justify-between items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm';
                itemDiv.innerHTML = `
                    <div class="flex-1 pr-3">
                        <h4 class="font-bold text-sm text-gray-800 line-clamp-1 mb-1">${item.name}</h4>
                        <div class="text-orange-500 font-black text-sm">$${item.price.toFixed(2)}</div>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100 flex-shrink-0">
                        <button onclick="updateCartQty(${item.id}, -1)" class="w-7 h-7 flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm rounded-lg transition-all"><i data-feather="minus" class="w-3 h-3"></i></button>
                        <span class="text-sm font-black w-5 text-center text-gray-800">${item.qty}</span>
                        <button onclick="updateCartQty(${item.id}, 1)" class="w-7 h-7 flex items-center justify-center text-orange-500 bg-orange-50 border border-orange-100 hover:border-transparent hover:bg-white hover:shadow-sm rounded-lg transition-all"><i data-feather="plus" class="w-3 h-3"></i></button>
                    </div>
                `;
                list.appendChild(itemDiv);
            });

            totalEl.innerText = `$${total.toFixed(2)}`;
            countEl.innerText = count;
            countEl.classList.remove('hidden');

            if (typeof feather !== 'undefined') feather.replace();
        }
    </script>
</body>

</html>