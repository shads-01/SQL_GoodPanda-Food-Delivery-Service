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
            <a href="{{ route('restaurant.add_item') }}" class="bg-white text-orange-500 px-4 py-2 rounded">+ Add
                Item</a>
            <a href="{{ route('restaurant.add_offer') }}" class="bg-orange-500 text-white px-4 py-2 rounded">+ Offer</a>
        </div>

        <div class="relative z-50 flex items-center gap-1">
            @if(Session::has('user_id'))
                <button id="profileBtn" class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow">
                    <i data-feather="user" class="text-orange-500"></i>
                </button>

                <!-- Dropdown -->
                <div id="profileDropdown"
                    class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded overflow-hidden">
                    <a href="{{ route('customer_profile') }}"
                        class="block px-4 py-2 hover:bg-gray-100 text-gray-800">Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2 hover:bg-red-50 text-red-600">Logout</button>
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
    </div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof feather !== 'undefined') feather.replace();

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
    });
</script>