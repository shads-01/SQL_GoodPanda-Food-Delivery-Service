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

    /* ---- Cart Button ---- */
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
        position: relative;
    }

    .gp-cart-btn:hover {
        background: var(--orange-light);
        transform: scale(1.05);
    }

    .gp-cart-btn svg {
        width: 17px;
        height: 17px;
    }

    /* ---- Cart Dropdown ---- */
    .gp-cart-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 22rem;
        background: white;
        border-radius: 1.25rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.18);
        border: 1px solid #F3F4F6;
        z-index: 9999;
        overflow: hidden;
        transform-origin: top right;
        transition: opacity 0.2s, transform 0.2s;
    }

    .gp-cart-dropdown.hidden {
        display: none;
    }

    .gp-cart-dropdown.invisible-cart {
        opacity: 0;
        transform: scale(0.95) translateY(-4px);
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
        @if(Session::has('user_id') && Session::get('user_role') === 'customer')
        {{-- Cart Button + Dropdown --}}
        <div style="position:relative;" id="navCartWrapper">
            <button class="gp-cart-btn" id="cartBtn" title="Cart" onclick="gpToggleCart(event)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.273M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
                <span id="cartCount" style="display:none;position:absolute;top:-4px;right:-4px;background:#EF4444;color:white;font-size:10px;font-weight:900;padding:2px 6px;border-radius:999px;min-width:18px;text-align:center;">0</span>
            </button>

            {{-- Cart Dropdown --}}
            <div class="gp-cart-dropdown hidden invisible-cart" id="cartDropdown">
                {{-- Header --}}
                <div style="padding:1.1rem 1.25rem;background:linear-gradient(to right,#fb923c,#f97316);color:white;display:flex;justify-content:space-between;align-items:center;">
                    <h3 style="font-weight:900;font-size:1rem;display:flex;align-items:center;gap:0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/></svg>
                        Your Order
                    </h3>
                    <button onclick="gpCloseCart()" style="background:rgba(255,255,255,0.2);border:none;color:white;width:28px;height:28px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;">✕</button>
                </div>

                {{-- Items list --}}
                <div id="cartItemsList" style="max-height:260px;overflow-y:auto;padding:1rem;background:#FAFAF9;display:flex;flex-direction:column;gap:0.75rem;">
                    <div id="emptyCartMessage" style="text-align:center;color:#9CA3AF;padding:2rem 0;">
                        <div style="width:3.5rem;height:3.5rem;background:#F3F4F6;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1.5rem;height:1.5rem;opacity:0.5;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.273M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                        </div>
                        <p style="font-weight:700;font-size:0.875rem;">Your cart is empty</p>
                        <p style="font-size:0.75rem;margin-top:0.25rem;">Add some delicious items!</p>
                    </div>
                </div>

                {{-- Footer --}}
                <div style="padding:1rem 1.25rem;border-top:1px solid #F3F4F6;background:white;">
                    <div style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem;font-size:0.875rem;color:#6B7280;">
                        <div style="display:flex;justify-content:space-between;">
                            <span>Subtotal</span>
                            <span id="cartSubtotal" style="color:#111827;font-weight:700;">৳0.00</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span>Delivery Fee</span>
                            <span id="cartDelivery" style="color:#111827;font-weight:700;">৳70.00</span>
                        </div>
                        <div id="cartDiscountRow" style="display:none;justify-content:space-between;color:#F97316;font-weight:700;">
                            <span>Discount Applied</span>
                            <span id="cartDiscount">-৳0.00</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding-top:0.6rem;border-top:1px solid #F3F4F6;margin-top:0.25rem;">
                            <span style="font-weight:700;color:#374151;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Total Cost</span>
                            <span id="cartTotal" style="font-weight:900;font-size:1.25rem;color:#111827;">৳0.00</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.6rem;">
                        <button id="clearCartBtn" onclick="gpClearCart()" disabled style="flex:1;padding:0.65rem;border-radius:0.75rem;border:2px solid #E5E7EB;color:#6B7280;font-weight:900;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;background:white;transition:all 0.15s;opacity:0.5;" onmouseenter="this.style.background='#F9FAFB'" onmouseleave="this.style.background='white'">Clear</button>
                        <button id="checkoutBtn" onclick="gpCheckout()" disabled style="flex:2;padding:0.65rem;border-radius:0.75rem;border:2px solid #F97316;background:#F97316;color:white;font-weight:900;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;cursor:pointer;transition:all 0.15s;opacity:0.5;" onmouseenter="this.style.background='#EA580C'" onmouseleave="this.style.background='#F97316'">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(Session::has('user_id'))
        <button class="gp-profile-btn" id="gpProfileBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </button>
        <div class="gp-profile-dropdown" id="gpProfileDropdown">
            <a href="{{ route('customer_profile') }}">👤 Profile</a>
            <a href="{{ route('customer.offers') }}">🏷️ Offers</a>
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
    // ── Profile dropdown ──
    const btn = document.getElementById('gpProfileBtn');
    const dd  = document.getElementById('gpProfileDropdown');
    if (btn && dd) {
        btn.addEventListener('click', e => { e.stopPropagation(); dd.classList.toggle('open'); });
        document.addEventListener('click', e => {
            if (!dd.contains(e.target) && !btn.contains(e.target)) dd.classList.remove('open');
        });
    }

    // ── Flash messages ──
    ['gp-flash-success', 'gp-flash-error'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            setTimeout(() => { el.style.transition = 'opacity 0.5s'; el.style.opacity = '0'; }, 4000);
            setTimeout(() => el.remove(), 4600);
        }
    });

    // ── Global Search ──
    const gSearchInput = document.getElementById('globalSearchInput');
    const gSugList     = document.getElementById('globalSearchSuggestions');
    let gDebounce;
    if (gSearchInput) {
        gSearchInput.addEventListener('input', () => {
            clearTimeout(gDebounce);
            const q = gSearchInput.value.trim();
            if (q.length < 2) { gSugList.classList.remove('open'); gSugList.innerHTML = ''; return; }
            gDebounce = setTimeout(() => {
                fetch(`/search/suggestions?q=${encodeURIComponent(q)}`)
                    .then(r => r.json())
                    .then(data => {
                        gSugList.innerHTML = '';
                        if (!data.length) { gSugList.classList.remove('open'); return; }
                        data.forEach(s => {
                            const li = document.createElement('li');
                            li.innerHTML = `<span>${s.label}</span><span class="nav-sug-type">${s.type}</span>`;
                            li.onclick = () => { gSearchInput.value = s.label; executeNavbarSearch(); };
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
        gSearchInput.addEventListener('keydown', e => { if (e.key === 'Enter') executeNavbarSearch(); });
    }
})();

function executeNavbarSearch() {
    const q = document.getElementById('globalSearchInput').value.trim();
    if (!q) return;
    window.location = `/search?q=${encodeURIComponent(q)}`;
}

// ══════════════════════════════════════════════════
//  GLOBAL NAVBAR CART
// ══════════════════════════════════════════════════
@if(Session::has('user_id') && Session::get('user_role') === 'customer')
(function() {
    const CSRF = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';

    // State
    window.gpCart            = [];       // [{id, name, price, qty, category_id}]
    window.gpRestaurantId    = null;
    window.gpActiveOffer     = null;
    window.gpOffersList      = [];

    // ── API helper ──
    async function gpFetch(url, opts = {}) {
        const res  = await fetch(url, {
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            ...opts,
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'API error');
        return json;
    }

    // ── Load cart from server ──
    window.gpLoadCart = async function() {
        try {
            const data = await gpFetch('/api/cart/active/summary');
            window.gpRestaurantId = data.restaurant_id || null;

            window.gpCart = (data.cart || []).map(row => ({
                id:          row.item_id,
                name:        row.item_name,
                price:       parseFloat(row.unit_price),
                qty:         parseInt(row.quantity),
                category_id: row.category_id,
            }));

            // Restore saved offer for this restaurant
            if (window.gpRestaurantId) {
                const savedOfferId = sessionStorage.getItem('goodpanda_offer_' + window.gpRestaurantId);
                if (savedOfferId && window.gpOffersList.length === 0) {
                    await gpLoadOffers(window.gpRestaurantId);
                }
                window.gpActiveOffer = savedOfferId
                    ? (window.gpOffersList.find(o => parseInt(o.offer_id) == savedOfferId) || null)
                    : null;
            } else {
                window.gpActiveOffer = null;
            }
        } catch(e) {
            window.gpCart = [];
        }
        gpRenderCart();
    };

    async function gpLoadOffers(restaurantId) {
        try {
            const data = await gpFetch(`/api/cart/offers/${restaurantId}`);
            window.gpOffersList = data.offers || [];
        } catch(e) {
            window.gpOffersList = [];
        }
    }

    // ── Discount calculation ──
    function gpCalcDiscount(basePrice, categoryId, itemId) {
        const offer = window.gpActiveOffer;
        if (!offer) return basePrice;
        let applicable = false;
        if (offer.target_type === 'category' && offer.target_category_id == categoryId) applicable = true;
        if (offer.target_type === 'item'     && offer.target_item_id     == itemId)     applicable = true;
        if (applicable) {
            if (offer.discount_type === 'percentage') return Math.max(0, basePrice - basePrice * (offer.discount_value / 100));
            if (offer.discount_type === 'flat')       return Math.max(0, basePrice - offer.discount_value);
        }
        return basePrice;
    }

    // ── Render cart dropdown ──
    window.gpRenderCart = function() {
        const list        = document.getElementById('cartItemsList');
        const totalEl     = document.getElementById('cartTotal');
        const countEl     = document.getElementById('cartCount');
        const subtotalEl  = document.getElementById('cartSubtotal');
        const deliveryEl  = document.getElementById('cartDelivery');
        const discountRow = document.getElementById('cartDiscountRow');
        const discountEl  = document.getElementById('cartDiscount');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const clearBtn    = document.getElementById('clearCartBtn');

        if (!list) return;

        if (window.gpCart.length === 0) {
            list.innerHTML = `<div id="emptyCartMessage" style="text-align:center;color:#9CA3AF;padding:2rem 0;">
                <div style="width:3.5rem;height:3.5rem;background:#F3F4F6;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1.5rem;height:1.5rem;opacity:0.5;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.962-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.273M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                </div>
                <p style="font-weight:700;font-size:0.875rem;">Your cart is empty</p>
                <p style="font-size:0.75rem;margin-top:0.25rem;">Add some delicious items!</p>
            </div>`;
            if (subtotalEl)  subtotalEl.textContent  = '৳0.00';
            if (deliveryEl)  deliveryEl.textContent  = '৳70.00';
            if (discountRow) discountRow.style.display = 'none';
            if (totalEl)     totalEl.textContent     = '৳0.00';
            if (countEl)     { countEl.textContent = '0'; countEl.style.display = 'none'; }
            if (checkoutBtn) { checkoutBtn.disabled = true; checkoutBtn.style.opacity = '0.5'; }
            if (clearBtn)    { clearBtn.disabled = true; clearBtn.style.opacity = '0.5'; }
            return;
        }

        list.innerHTML = '';
        if (checkoutBtn) { checkoutBtn.disabled = false; checkoutBtn.style.opacity = '1'; }
        if (clearBtn)    { clearBtn.disabled = false; clearBtn.style.opacity = '1'; }

        let subtotal = 0, count = 0, undiscountedSubtotal = 0;

        // Pre-calculate undiscounted total for min_order validation
        window.gpCart.forEach(item => {
            undiscountedSubtotal += item.price * item.qty;
            count += item.qty;
        });

        let isOfferValid = true;
        if (window.gpActiveOffer) {
            const minOrder = parseFloat(window.gpActiveOffer.min_order_amount) || 0;
            if (undiscountedSubtotal < minOrder && minOrder > 0) isOfferValid = false;
        }
        const savedOffer = window.gpActiveOffer;
        if (!isOfferValid) window.gpActiveOffer = null;

        window.gpCart.forEach(item => {
            const discountedUnit = gpCalcDiscount(item.price, item.category_id, item.id);
            subtotal += discountedUnit * item.qty;

            let priceHTML = `<div style="color:#F97316;font-weight:900;font-size:0.875rem;">৳${discountedUnit.toFixed(2)}</div>`;
            if (discountedUnit < item.price) {
                priceHTML = `<div style="color:#F97316;font-weight:900;font-size:0.875rem;"><span style="text-decoration:line-through;color:#9CA3AF;font-size:0.75rem;margin-right:4px;">৳${item.price.toFixed(2)}</span>৳${discountedUnit.toFixed(2)}</div>`;
            }

            const row = document.createElement('div');
            row.style.cssText = 'display:flex;justify-content:space-between;align-items:center;background:white;padding:0.75rem;border-radius:0.75rem;border:1px solid #F3F4F6;box-shadow:0 1px 2px rgba(0,0,0,0.04);';
            row.innerHTML = `
                <div style="flex:1;padding-right:0.75rem;">
                    <h4 style="font-weight:700;font-size:0.8rem;color:#1F2937;margin-bottom:4px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;">${item.name}</h4>
                    ${priceHTML}
                </div>
                <div style="display:flex;align-items:center;gap:6px;background:#F9FAFB;border-radius:0.625rem;padding:4px;border:1px solid #F3F4F6;flex-shrink:0;">
                    <button onclick="gpUpdateQty(${item.id}, -1)" style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:transparent;cursor:pointer;border-radius:6px;font-size:1rem;color:#6B7280;" onmouseenter="this.style.background='white'" onmouseleave="this.style.background='transparent'">−</button>
                    <span style="font-size:0.875rem;font-weight:900;width:20px;text-align:center;color:#1F2937;">${item.qty}</span>
                    <button onclick="gpUpdateQty(${item.id}, 1)"  style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:#FFF7ED;cursor:pointer;border-radius:6px;font-size:1rem;color:#F97316;border:1px solid #FED7AA;" onmouseenter="this.style.background='white'" onmouseleave="this.style.background='#FFF7ED'">+</button>
                </div>`;
            list.appendChild(row);
        });

        window.gpActiveOffer = savedOffer;

        // Order-level discount (restaurant-wide only)
        let deliveryFee = 70.00, orderDiscount = 0;
        if (window.gpActiveOffer && isOfferValid) {
            if (window.gpActiveOffer.discount_type === 'free_delivery') {
                deliveryFee = 0;
                if (deliveryEl) deliveryEl.innerHTML = `<span style="text-decoration:line-through;color:#9CA3AF;margin-right:6px;font-size:0.75rem;">৳70.00</span><span style="color:#10B981;font-weight:900;">FREE</span>`;
            } else {
                if (deliveryEl) deliveryEl.textContent = `৳${deliveryFee.toFixed(2)}`;
            }
            if (window.gpActiveOffer.target_type === 'restaurant') {
                if (window.gpActiveOffer.discount_type === 'flat')
                    orderDiscount = parseFloat(window.gpActiveOffer.discount_value);
                else if (window.gpActiveOffer.discount_type === 'percentage')
                    orderDiscount = undiscountedSubtotal * (parseFloat(window.gpActiveOffer.discount_value) / 100);
            }
        } else {
            if (deliveryEl) deliveryEl.textContent = '৳70.00';
        }

        const finalTotal = Math.max(0, subtotal - orderDiscount) + deliveryFee;
        if (subtotalEl)  subtotalEl.textContent = `৳${subtotal.toFixed(2)}`;
        if (orderDiscount > 0) {
            if (discountRow) discountRow.style.display = 'flex';
            if (discountEl)  discountEl.textContent = `-৳${orderDiscount.toFixed(2)}`;
        } else {
            if (discountRow) discountRow.style.display = 'none';
        }
        if (totalEl)  totalEl.textContent = `৳${finalTotal.toFixed(2)}`;
        if (countEl)  { countEl.textContent = count; countEl.style.display = count > 0 ? 'block' : 'none'; }
    };

    // ── Cart open/close ──
    window.gpOpenCart = function() {
        const dd = document.getElementById('cartDropdown');
        if (!dd) return;
        dd.classList.remove('hidden', 'invisible-cart');
    };

    window.gpCloseCart = function() {
        const dd = document.getElementById('cartDropdown');
        if (!dd) return;
        dd.classList.add('invisible-cart');
        setTimeout(() => dd.classList.add('hidden'), 200);
    };

    window.gpToggleCart = function(e) {
        e.stopPropagation();
        const dd = document.getElementById('cartDropdown');
        if (!dd) return;
        if (dd.classList.contains('hidden')) gpOpenCart(); else gpCloseCart();
    };

    // Close cart when clicking outside
    document.addEventListener('click', e => {
        const wrapper = document.getElementById('navCartWrapper');
        const dd      = document.getElementById('cartDropdown');
        if (wrapper && dd && !wrapper.contains(e.target) && !dd.classList.contains('hidden')) {
            gpCloseCart();
        }
    });

    // ── Cart API calls ──
    window.gpUpdateQty = async function(itemId, change) {
        if (!window.gpRestaurantId) return;
        try {
            await gpFetch('/api/cart/update', {
                method: 'POST',
                body: JSON.stringify({ restaurant_id: window.gpRestaurantId, item_id: itemId, qty_change: change }),
            });
        } catch(e) { console.error('gpUpdateQty failed:', e.message); }
        await window.gpLoadCart();
        // Notify restaurant detail page if open (so its grid and modals re-sync)
        if (typeof renderCart === 'function') renderCart();
    };

    window.gpClearCart = async function() {
        if (!window.gpRestaurantId) return;
        try {
            await gpFetch('/api/cart/clear', {
                method: 'POST',
                body: JSON.stringify({ restaurant_id: window.gpRestaurantId }),
            });
        } catch(e) { console.error('gpClearCart failed:', e.message); }
        window.gpActiveOffer = null;
        sessionStorage.removeItem('goodpanda_offer_' + window.gpRestaurantId);
        window.gpRestaurantId = null;
        await window.gpLoadCart();
        gpCloseCart();
        if (typeof updateGridPrices === 'function') updateGridPrices();
    };

    window.gpCheckout = function() {
        if (!window.gpRestaurantId || window.gpCart.length === 0) return;
        let url = `/checkout/${window.gpRestaurantId}`;
        if (window.gpActiveOffer) url += `?offer_id=${window.gpActiveOffer.offer_id}`;
        window.location.href = url;
    };

    // ── Load on page ready ──
    document.addEventListener('DOMContentLoaded', () => {
        window.gpLoadCart();
    });

})();
@endif
</script>