{{-- resources/views/components/restaurant_navbar.blade.php --}}
<style>
    :root {
        --orange-main: #F97316;
        --orange-light: #FED7AA;
        --orange-pale: #FFF7ED;
        --border: #E7E5E4;
        --bg: #FAFAF9;
    }

    .gp-navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 0 2rem;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
    }

    .gp-navbar-logo {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--orange-main);
        text-decoration: none;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-shrink: 0;
    }

    .gp-navbar-logo span {
        font-size: 1.3rem;
    }

    .gp-nav-links {
        display: flex;
        gap: 1.5rem;
        flex: 1;
        justify-content: center;
    }

    .gp-nav-links a {
        text-decoration: none;
        color: #444;
        font-size: 0.9rem;
        font-weight: 600;
        transition: color 0.2s;
        padding: 0.5rem 0;
        border-bottom: 2px solid transparent;
    }

    .gp-nav-links a:hover,
    .gp-nav-links a.active {
        color: var(--orange-main);
    }

    .gp-nav-links a.active {
        border-bottom-color: var(--orange-main);
    }

    .gp-navbar-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .gp-profile-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--orange-pale);
        border: 1.5px solid var(--orange-light);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s;
    }

    .gp-profile-btn:hover {
        background: var(--orange-light);
        transform: scale(1.05);
    }

    .gp-profile-btn svg {
        color: var(--orange-main);
        width: 17px;
        height: 17px;
    }

    .gp-profile-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        min-width: 180px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        overflow: hidden;
        display: none;
        z-index: 200;
    }

    .gp-profile-dropdown.open {
        display: block;
    }

    .gp-profile-dropdown a,
    .gp-profile-dropdown button {
        display: block;
        width: 100%;
        padding: 0.7rem 1rem;
        font-size: 0.875rem;
        color: #1C1917;
        text-decoration: none;
        font-weight: 500;
        background: none;
        border: none;
        text-align: left;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.1s;
        border-bottom: 1px solid var(--border);
    }

    .gp-profile-dropdown a:last-child,
    .gp-profile-dropdown button:last-child {
        border-bottom: none;
    }

    .gp-profile-dropdown a:hover,
    .gp-profile-dropdown button:hover {
        background: var(--bg);
    }

    .gp-profile-dropdown .danger {
        color: #EF4444;
    }

    .gp-profile-dropdown .danger:hover {
        background: #FEF2F2;
    }

    .gp-btn-logout {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #FCA5A5;
        background: #FEF2F2;
        color: #EF4444;
        font-family: inherit;
    }

    .gp-btn-logout:hover {
        background: #EF4444;
        color: #fff;
        border-color: #EF4444;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .gp-navbar-body-offset {
        padding-top: 60px;
    }

    .gp-btn-add {
        background: var(--orange-main);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .gp-btn-add:hover {
        transform: translateY(-1px);
        background: #EA580C;
    }
</style>

<nav class="gp-navbar" id="gpNavbar">
    <a href="{{ route('restaurant.dashboard') }}" class="gp-navbar-logo">
        <span>🐼</span> GoodPanda <small
            class="text-[10px] bg-orange-100 px-1.5 py-0.5 rounded ml-1 uppercase">Restaurant</small>
    </a>

    <div class="gp-nav-links">
        <a href="{{ route('restaurant.dashboard') }}"
            class="{{ request()->routeIs('restaurant.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('restaurant.items') }}"
            class="{{ request()->routeIs('restaurant.items') ? 'active' : '' }}">Menu</a>
        <a href="{{ route('restaurant.orders') }}"
            class="{{ request()->routeIs('restaurant.orders') ? 'active' : '' }}">Orders</a>
        <a href="{{ route('restaurant.offers') }}"
            class="{{ request()->routeIs('restaurant.offers') ? 'active' : '' }}">Offers</a>
        <a href="{{ route('restaurant.analytics') }}"
            class="{{ request()->routeIs('restaurant.analytics') ? 'active' : '' }}">Analytics</a>
    </div>

    <div class="gp-navbar-right">
        <div class="flex gap-2">
            <a href="{{ route('restaurant.add_item') }}" class="gp-btn-add">+ Item</a>
            <a href="{{ route('restaurant.add_offer') }}" class="gp-btn-add" style="background: #4B5563;">+ Offer</a>
        </div>

        @if(Session::has('user_id'))
            <div class="relative">
                <form action="{{ route('logout') }}" method="POST" style="margin:0;padding:0;">
                    @csrf
                    <button type="submit" class="gp-btn-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        @endif
    </div>
</nav>

{{-- Body offset --}}
<div class="gp-navbar-body-offset"></div>

<script>
    (function () {
        const btn = document.getElementById('gpResProfileBtn');
        const dd = document.getElementById('gpResProfileDropdown');
        if (btn && dd) {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                dd.classList.toggle('open');
            });
            document.addEventListener('click', e => {
                if (!dd.contains(e.target) && !btn.contains(e.target)) dd.classList.remove('open');
            });
        }
    })();
</script>