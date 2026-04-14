{{-- resources/views/components/menu_item_popup.blade.php --}}
{{-- Include once per customer page, before </body> --}}

<div id="itemPopupOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:2000;align-items:center;justify-content:center;">
    <div id="itemPopupBox" style="background:#fff;border-radius:20px;width:min(480px,95vw);max-height:88vh;overflow-y:auto;position:relative;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <!-- Close -->
        <button onclick="closeItemPopup()" style="position:absolute;top:12px;right:14px;background:none;border:none;cursor:pointer;font-size:1.4rem;color:#78716C;z-index:10;">✕</button>

        <!-- Image -->
        <div id="popupImageWrap" style="height:200px;background:#FFF7ED;border-radius:20px 20px 0 0;overflow:hidden;">
            <img id="popupImage" src="" alt="" style="width:100%;height:100%;object-fit:cover;display:none;">
            <div id="popupImagePlaceholder" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:4rem;">🍽️</div>
        </div>

        <div style="padding:1.25rem 1.5rem 1.5rem;">
            <h2 id="popupName" style="font-family:'Sora',sans-serif;font-size:1.2rem;font-weight:700;color:#1C1917;margin-bottom:0.25rem;"></h2>
            <div id="popupCuisines" style="font-size:0.78rem;color:#A8A29E;margin-bottom:0.75rem;"></div>
            <div id="popupDescription" style="font-size:0.87rem;color:#78716C;margin-bottom:1rem;line-height:1.5;"></div>

            <!-- Price -->
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem;">
                <span id="popupOriginalPrice" style="text-decoration:line-through;color:#A8A29E;font-size:0.9rem;"></span>
                <span id="popupFinalPrice" style="font-size:1.3rem;font-weight:700;color:#F97316;"></span>
            </div>

            <!-- Quantity + Line Total -->
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <button onclick="changeQty(-1)" style="width:32px;height:32px;border-radius:50%;border:1.5px solid #E7E5E4;background:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">−</button>
                    <span id="popupQty" style="font-size:1rem;font-weight:600;min-width:24px;text-align:center;">1</span>
                    <button onclick="changeQty(1)" style="width:32px;height:32px;border-radius:50%;border:1.5px solid #E7E5E4;background:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">+</button>
                </div>
                <span style="font-size:0.9rem;color:#78716C;">Total: <strong id="popupLineTotal" style="color:#1C1917;"></strong></span>
                       <!-- Add to Cart -->
            <button id="popupAddToCartBtn" onclick="addToCart()" style="width:100%;padding:0.85rem;background:#F97316;color:white;border:none;border-radius:12px;font-size:1rem;font-weight:600;cursor:pointer;transition:background 0.15s;display:flex;align-items:center;justify-content:center;gap:0.5rem;" onmouseover="this.style.background='#EA580C'" onmouseout="this.style.background='#F97316'">
                <span id="popupAddToCartText">Add to Cart</span>
                <div id="popupAddToCartLoading" class="hidden">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
    let _popupItem = null;
    let _popupQty = 1;

    function openItemPopup(item) {
        _popupItem = item;
        _popupQty = 1;
        document.getElementById('popupName').textContent = item.item_name;
        document.getElementById('popupCuisines').textContent = item.cuisine_names || '';
        document.getElementById('popupDescription').textContent = item.description || '';

        const img = document.getElementById('popupImage');
        const ph = document.getElementById('popupImagePlaceholder');
        if (item.item_image && item.item_image.startsWith('http')) {
            img.src = item.item_image;
            img.style.display = 'block';
            ph.style.display = 'none';
        } else {
            img.style.display = 'none';
            ph.style.display = 'flex';
        }

        const unitPrice = item.offer_price ? parseFloat(item.offer_price) : parseFloat(item.price);
        const origEl = document.getElementById('popupOriginalPrice');
        const finalEl = document.getElementById('popupFinalPrice');
        if (item.offer_price) {
            origEl.textContent = '৳' + parseFloat(item.price).toFixed(0);
            origEl.style.display = 'inline';
        } else {
            origEl.style.display = 'none';
        }
        finalEl.textContent = '৳' + unitPrice.toFixed(0);
        document.getElementById('popupQty').textContent = 1;
        document.getElementById('popupLineTotal').textContent = '৳' + unitPrice.toFixed(0);

        // Reset button state
        const btn = document.getElementById('popupAddToCartBtn');
        const btnText = document.getElementById('popupAddToCartText');
        const btnLoading = document.getElementById('popupAddToCartLoading');
        btn.disabled = false;
        btnText.textContent = 'Add to Cart';
        btnLoading.classList.add('hidden');

        const ov = document.getElementById('itemPopupOverlay');
        ov.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeItemPopup() {
        document.getElementById('itemPopupOverlay').style.display = 'none';
        document.body.style.overflow = '';
    }

    function changeQty(delta) {
        if (!_popupItem) return;
        _popupQty = Math.max(1, _popupQty + delta);
        const unitPrice = _popupItem.offer_price ? parseFloat(_popupItem.offer_price) : parseFloat(_popupItem.price);
        document.getElementById('popupQty').textContent = _popupQty;
        document.getElementById('popupLineTotal').textContent = '৳' + (unitPrice * _popupQty).toFixed(0);
    }

    async function addToCart() {
        if (!_popupItem) return;

        const btn = document.getElementById('popupAddToCartBtn');
        const btnText = document.getElementById('popupAddToCartText');
        const btnLoading = document.getElementById('popupAddToCartLoading');

        const restaurantId = _popupItem.restaurant_id;
        if (!restaurantId) {
            alert('Cannot add to cart: restaurant not found.');
            return;
        }

        const unitPrice = _popupItem.price ? parseFloat(_popupItem.price) : 0;
        const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';

        // ── Single-restaurant cart enforcement ──
        if (window.gpRestaurantId && window.gpRestaurantId != restaurantId && window.gpCart && window.gpCart.length > 0) {
            const confirmed = confirm('Your cart has items from another restaurant.\n\nClear it and start a new order from this restaurant?');
            if (!confirmed) return;
            try {
                await fetch('/api/cart/clear', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ restaurant_id: window.gpRestaurantId }),
                });
            } catch (e) { console.error(e); }
            window.gpRestaurantId = null;
            window.gpActiveOffer  = null;
        }

        // Set Loading State
        btn.disabled = true;
        btnText.textContent = 'Adding to cart...';
        btnLoading.classList.remove('hidden');

        try {
            const res = await fetch('/api/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: JSON.stringify({
                    restaurant_id: restaurantId,
                    item_id:       _popupItem.item_id,
                    quantity:      _popupQty,
                    unit_price:    unitPrice,
                }),
            });
            if (!res.ok) throw new Error('Failed');
        } catch (e) {
            alert('Could not add to cart. Please try again.');
            btn.disabled = false;
            btnText.textContent = 'Add to Cart';
            btnLoading.classList.add('hidden');
            return;
        }

        // Success: reload and show toast
        closeItemPopup();
        
        // Reload navbar cart
        window.gpRestaurantId = restaurantId;
        if (typeof window.gpLoadCart === 'function') window.gpLoadCart();
        if (typeof window.gpOpenCart === 'function') window.gpOpenCart();

        // Quick toast
        const t = document.createElement('div');
        t.textContent = '✓ Added to cart!';
        t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#1C1917;color:white;padding:0.6rem 1.1rem;border-radius:8px;font-size:0.875rem;z-index:9999;transition:opacity 0.4s;';
        document.body.appendChild(t);
        setTimeout(() => { t.style.opacity = '0'; }, 2000);
        setTimeout(() => t.remove(), 2500);
    }

    // Close on overlay background click
    document.getElementById('itemPopupOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeItemPopup();
    });
</script>

<style>
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .hidden {
        display: none;
    }
</style>