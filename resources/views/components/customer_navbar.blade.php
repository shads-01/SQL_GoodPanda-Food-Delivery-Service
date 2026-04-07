{{-- resources/views/components/customer_navbar.blade.php --}}
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

    .gp-navbar-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* ---- Search Bar inside Navbar ---- */
    .gp-nav-search {
        flex: 1;
        max-width: 500px;
        margin: 0 2rem;
        position: relative;
    }

    .gp-nav-search input {
        width: 100%;
        padding: 0.6rem 2.8rem 0.6rem 2.5rem;
        border: 1.5px solid var(--border);
        border-radius: 50px;
        background: #fcfcfc;
        font-size: 0.9rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .gp-nav-search input:focus {
        border-color: var(--orange-main);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.12);
        background: #fff;
    }

    .gp-nav-search .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        width: 16px;
        height: 16px;
    }

    .gp-nav-search-btn {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--orange-main);
        color: white;
        border: none;
        padding: 0.4rem 0.9rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .gp-nav-search-btn:hover {
        background: #EA580C;
    }

    /* Suggestions */
    .nav-search-suggestions {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        z-index: 500;
        overflow: hidden;
        display: none;
    }

    .nav-search-suggestions.open {
        display: block;
    }

    .nav-search-suggestions li {
        list-style: none;
        padding: 0.65rem 1rem;
        font-size: 0.875rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #1C1917;
    }

    .nav-search-suggestions li:hover {
        background: var(--bg);
    }

    .nav-sug-type {
        font-size: 0.7rem;
        background: var(--orange-pale);
        color: var(--orange-main);
        padding: 2px 6px;
        border-radius: 20px;
        font-weight: 600;
    }

    .gp-cart-btn {
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
        color: var(--orange-main);
        text-decoration: none;
    }

    .gp-cart-btn:hover {
        background: var(--orange-light);
        transform: scale(1.05);
    }

    .gp-cart-btn svg {
        width: 17px;
        height: 17px;
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

    .gp-navbar-body-offset {
        padding-top: 60px;
    }
</style>

<nav class="gp-navbar" id="gpNavbar">
    {{-- Logo → home --}}
    <a href="{{ route('home') }}" class="gp-navbar-logo">
        <span>🐼</span> GoodPanda
    </a>

    {{-- Universal Search Bar --}}
    <div class="gp-nav-search">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <input type="text" id="globalSearchInput" placeholder="Search items or restaurants..." autocomplete="off" value="{{ request('q', '') }}">
        <button class="gp-nav-search-btn" onclick="executeNavbarSearch()">Search</button>
        <ul class="nav-search-suggestions" id="globalSearchSuggestions"></ul>
    </div>

    <div class="gp-navbar-right">
        {{-- Cart icon (placeholder – teammate will wire up) --}}
        <a href="#" class="gp-cart-btn" id="cartBtn" title="Cart">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.273M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
        </a>

        @if(Session::has('user_id'))
        <button class="gp-profile-btn" id="gpProfileBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </button>
        <div class="gp-profile-dropdown" id="gpProfileDropdown">
            <a href="{{ route('customer_profile') }}">👤 Profile</a>
            <a href="{{ route('customer.offers') }}">🏷️ Offers</a>
            <a href="#">❓ Help</a>
            <a href="#">ℹ️ About</a>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;padding:0;">
                @csrf
                <button type="submit" class="danger">🚪 Logout</button>
            </form>
        </div>
        @else
        <a href="{{ route('login') }}" style="background:var(--orange-main);color:white;padding:0.45rem 1.1rem;border-radius:999px;text-decoration:none;font-size:0.875rem;font-weight:600;">Login</a>
        @endif
    </div>
</nav>

{{-- Body offset so content doesn't hide under fixed navbar --}}
<div class="gp-navbar-body-offset"></div>

@if(session('success'))
<div id="gp-flash-success" style="background:#D1FAE5;border:1px solid #34D399;color:#065F46;padding:0.75rem 1rem;border-radius:0.5rem;max-width:40rem;margin:1rem auto;text-align:center;font-weight:500;">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div id="gp-flash-error" style="background:#FEE2E2;border:1px solid #F87171;color:#991B1B;padding:0.75rem 1rem;border-radius:0.5rem;max-width:40rem;margin:1rem auto;text-align:center;font-weight:500;">
    {{ session('error') }}
</div>
@endif

<script>
    (function() {
        const btn = document.getElementById('gpProfileBtn');
        const dd = document.getElementById('gpProfileDropdown');
        if (btn && dd) {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                dd.classList.toggle('open');
            });
            document.addEventListener('click', e => {
                if (!dd.contains(e.target) && !btn.contains(e.target)) dd.classList.remove('open');
            });
        }
        ['gp-flash-success', 'gp-flash-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s';
                    el.style.opacity = '0';
                }, 4000);
                setTimeout(() => el.remove(), 4600);
            }
        });

        // Global Search Logic
        const gSearchInput = document.getElementById('globalSearchInput');
        const gSugList = document.getElementById('globalSearchSuggestions');
        let gDebounce;

        if (gSearchInput) {
            gSearchInput.addEventListener('input', () => {
                clearTimeout(gDebounce);
                const q = gSearchInput.value.trim();
                if (q.length < 2) {
                    gSugList.classList.remove('open');
                    gSugList.innerHTML = '';
                    return;
                }
                gDebounce = setTimeout(() => {
                    fetch(`/search/suggestions?q=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(data => {
                            gSugList.innerHTML = '';
                            if (!data.length) {
                                gSugList.classList.remove('open');
                                return;
                            }
                            data.forEach(s => {
                                const li = document.createElement('li');
                                li.innerHTML = `<span>${s.label}</span><span class="nav-sug-type">${s.type}</span>`;
                                li.onclick = () => {
                                    gSearchInput.value = s.label;
                                    executeNavbarSearch();
                                };
                                gSugList.appendChild(li);
                            });
                            gSugList.classList.add('open');
                        });
                }, 250);
            });

            document.addEventListener('click', e => {
                if (!gSearchInput.contains(e.target) && !gSugList.contains(e.target))
                    gSugList.classList.remove('open');
            });

            gSearchInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') executeNavbarSearch();
            });
        }
    })();

    function executeNavbarSearch() {
        const q = document.getElementById('globalSearchInput').value.trim();
        if (!q) return;
        window.location = `/search?q=${encodeURIComponent(q)}`;
    }
</script>