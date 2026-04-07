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
            </div>

            <!-- Add to Cart -->
            <button onclick="addToCart()" style="width:100%;padding:0.85rem;background:#F97316;color:white;border:none;border-radius:12px;font-size:1rem;font-weight:600;cursor:pointer;transition:background 0.15s;" onmouseover="this.style.background='#EA580C'" onmouseout="this.style.background='#F97316'">
                Add to Cart
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

    function addToCart() {
        if (!_popupItem) return;
        // Cart wiring by teammate – we just log for now
        console.log('Add to cart:', _popupItem.item_id, 'qty:', _popupQty);
        closeItemPopup();
        // Show a quick toast
        const t = document.createElement('div');
        t.textContent = '✓ Added to cart!';
        t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#1C1917;color:white;padding:0.6rem 1.1rem;border-radius:8px;font-size:0.875rem;z-index:9999;transition:opacity 0.4s;';
        document.body.appendChild(t);
        setTimeout(() => t.style.opacity = '0', 2000);
        setTimeout(() => t.remove(), 2500);
    }

    // Close on overlay background click
    document.getElementById('itemPopupOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeItemPopup();
    });
</script>