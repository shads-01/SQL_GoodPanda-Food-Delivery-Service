<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GoodPanda</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="w-full p-4 flex justify-between items-center" style="background: linear-gradient(135deg, #f3a34e, #FB923C);">

        <!-- Left: Logo -->
        <h1 class="text-2xl font-bold text-white">GoodPanda</h1>

        <!-- Center: Menu -->
        <div class="flex gap-6 text-white font-medium mx-auto">
            <a href="{{ route('home') }}">Home</a>
            <a href="#">Restaurants</a>
            <a href="#">Offers</a>
            <a href="#">About</a>
        </div>

        <!-- Right: Profile -->
        <div class="relative z-50 flex items-center gap-4">
            @if(Session::has('user_id') && ($isOwner ?? false))
            {{-- Owner views simple logout button similar to unauthenticated login button --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white text-orange-500 px-5 py-2 rounded-full font-semibold shadow hover:bg-orange-50 transition">Logout</button>
            </form>
            @elseif(Session::has('user_id'))
            <button id="profileBtn" class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow">
                <i data-feather="user" class="text-orange-500"></i>
            </button>

            <!-- Dropdown -->
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded overflow-hidden">
                <a href="{{ route('customer_profile') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-800">Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 hover:bg-red-50 text-red-600">Logout</button>
                </form>
            </div>
            @else
            {{-- Guests --}}
            <a href="{{ route('login') }}"
                class="bg-white text-orange-500 px-5 py-2 rounded-full font-semibold shadow hover:bg-orange-50 transition">
                Login
            </a>
            @endif

        </div>
    </nav>

    <!-- Flash Message -->
    @if(session('success'))
    <div id="flash-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-2xl mx-auto mt-4 text-center shadow-sm transition-opacity duration-500" role="alert">
        <span class="block sm:inline font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div id="flash-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-2xl mx-auto mt-4 text-center shadow-sm transition-opacity duration-500" role="alert">
        <span class="block sm:inline font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace(); // render icons after DOM loaded

            // Filter Dropdown
            const filterBtn = document.getElementById('filterBtn');
            const filterDropdown = document.getElementById('filterDropdown');

            if (filterBtn && filterDropdown) {
                filterBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    filterDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!filterDropdown.contains(e.target) && !filterBtn.contains(e.target)) {
                        filterDropdown.classList.add('hidden');
                    }
                });
            }

            // Profile Dropdown
            const btn = document.getElementById('profileBtn');
            const dropdown = document.getElementById('profileDropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Auto-dismiss flash messages after 4s
            ['flash-success', 'flash-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    setTimeout(() => { 
                        el.style.transition = 'opacity 0.5s ease-out';
                        el.style.opacity = '0'; 
                    }, 10000);
                    setTimeout(() => { el.remove(); }, 10000);
                }
            });
        });
    </script>

    <div class="flex">

        <!-- Main Content -->
        <div class="flex-1 p-8">

            <!-- Search + Filter -->
            <div class="grid grid-cols-1 md:grid-cols-3 items-center mb-10 gap-4">

                <!-- Filter (Left on desktop, Top on mobile) -->
                <div class="flex md:justify-start justify-center">
                    <div class="relative">
                        <button id="filterBtn"
                            class="flex items-center gap-2 bg-white border px-4 py-3 rounded-lg shadow w-40">
                            <i data-feather="filter" class="text-gray-400 h-4 w-4"></i>
                            <span class="text-gray-400">Filter</span>
                            <i data-feather="chevron-down"></i>
                        </button>

                        <!-- Dropdown -->
                        <div id="filterDropdown"
                            class="hidden absolute left-0 mt-2 w-52 bg-white shadow-xl rounded-xl p-3 space-y-2 z-50">

                            <label class="flex gap-2 items-center cursor-pointer p-2 rounded-md hover:bg-gray-50">
                                <input type="checkbox" class="accent-orange-500"> Italian
                            </label>

                            <label class="flex gap-2 items-center cursor-pointer p-2 rounded-md hover:bg-gray-50">
                                <input type="checkbox" class="accent-orange-500"> Chinese
                            </label>

                            <label class="flex gap-2 items-center cursor-pointer p-2 rounded-md hover:bg-gray-50">
                                <input type="checkbox" class="accent-orange-500"> Bangladeshi
                            </label>

                            <label class="flex gap-2 items-center cursor-pointer p-2 rounded-md hover:bg-gray-50">
                                <input type="checkbox" class="accent-orange-500"> Fast Food
                            </label>

                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="md:col-span-1 flex justify-center">
                    <div class="relative w-full max-w-2xl">

                        <!-- Search Icon -->
                        <i data-feather="search"
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>

                        <!-- Input -->
                        <input
                            type="text"
                            placeholder="Search restaurants or dishes..."
                            class="w-full pl-12 pr-32 py-3 border rounded-full shadow-sm
                   focus:outline-none focus:ring-2 focus:ring-orange-400
                   focus:shadow-lg transition-all duration-200" />

                        <!-- Button -->
                        <button
                            class="absolute right-1 top-1/2 -translate-y-1/2
                   bg-orange-500 text-white px-6 py-2 rounded-full
                   hover:bg-orange-600 transition">
                            Search
                        </button>

                    </div>
                </div>

                <!-- Empty column for balance (desktop only) -->
                <div class="hidden md:block"></div>

            </div>
            <!-- Explore Cuisines -->
            <h2 class="text-2xl font-semibold mb-4">Explore Cuisines</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-10">
                @forelse($cuisines as $cuisine)
                <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:scale-105 transform transition">
                    <div class="h-20 w-20 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-3 text-orange-500">
                        <i data-feather="grid" class="h-8 w-8"></i>
                    </div>
                    <h3 class="font-bold text-lg">{{ $cuisine->cuisine_name }}</h3>
                </div>
                @empty
                <p class="text-gray-500">No cuisines found.</p>
                @endforelse
            </div>

            <!-- Top Restaurants -->
            <h2 class="text-2xl font-semibold mb-4">Top Restaurants</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($restaurants as $restaurant)
                <div class="bg-white rounded-2xl shadow p-4 hover:shadow-xl transition">
                    <div class="h-40 bg-gray-200 rounded mb-4 overflow-hidden flex items-center justify-center relative">
                        @if(isset($restaurant->cover_image) && $restaurant->cover_image)
                        <img src="{{ $restaurant->cover_image }}" alt="Cover" class="w-full h-full object-cover">
                        @else
                        <i data-feather="image" class="text-gray-400 w-10 h-10"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-lg">{{ $restaurant->name }}</h3>
                    <p class="text-gray-500 text-sm mb-2 text-ellipsis overflow-hidden whitespace-nowrap"><i data-feather="map-pin" class="inline w-3 h-3"></i> {{ $restaurant->location }}</p>
                    <button class="mt-2 text-sm bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                        Order Now
                    </button>
                </div>
                @empty
                <p class="text-gray-500">No restaurants found.</p>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-12 text-white text-center" style="background: linear-gradient(135deg, #FDBA74, #FB923C);">
        <div class="max-w-4xl mx-auto px-6 py-10">
            <!-- Brand -->
            <!-- Panda Logo Circle -->
            <div class="w-38 h-38 mx-auto rounded-full bg-white flex items-center justify-center mb-4 shadow-lg overflow-hidden">
                <img src="https://images.fineartamerica.com/images/artworkimages/mediumlarge/3/kawaii-cute-anime-panda-otaku-japanese-ramen-noodles-finnly-maria.jpg"
                    class="w-full h-full object-cover"
                    alt="Panda Logo">
            </div>
            <p class="text-sm opacity-90 mb-6">
                Discover the best restaurants and enjoy fast delivery at your doorstep.
            </p>
            <!-- Contact -->
            <div class="space-y-1 text-sm">
                <p>Email: support@goodpanda.com</p>
                <p>Phone: +880 1234 567890</p>
            </div>
        </div>
        <!-- Bottom -->
        <div class="border-t border-orange-300 py-4 text-sm">
            &copy {{ date('Y') }} GoodPanda. All Rights Reserved.
            |
            <a href="#" class="hover:underline">Privacy Policy</a>
            |
            <a href="#" class="hover:underline">Terms of Service</a>
        </div>
    </footer>
</body>

</html>