<div id="reviewPopupOverlay">
    <div class="review-popup">
        <!-- Close Button -->
        <button type="button" class="modal-close-btn" onclick="closeReviewModal()">&times;</button>

        <h3>Rate Your Experience</h3>
        <p>How was your food from <strong id="modalRestaurantName"></strong>?</p>
        <p id="modalPartnerNameContainer" style="display:none; font-size: 0.85rem; margin-top: -0.5rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
            Delivered by <strong id="modalPartnerName"></strong>
        </p>
        
        <form action="{{ route('customer.review.store') }}" method="POST" id="reviewForm">
            @csrf
            <input type="hidden" name="order_id" id="modalOrderId">
            <input type="hidden" name="restaurant_id" id="modalRestaurantId">

            <div class="form-group">
                <label>Restaurant Rating (Required)</label>
                <select name="restaurant_rating" required>
                    <option value="" disabled selected>Select a rating...</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5) - Excellent</option>
                    <option value="4">⭐⭐⭐⭐ (4) - Very Good</option>
                    <option value="3">⭐⭐⭐ (3) - Average</option>
                    <option value="2">⭐⭐ (2) - Poor</option>
                    <option value="1">⭐ (1) - Terrible</option>
                </select>
            </div>

            <input type="hidden" name="partner_id" id="modalPartnerId">

            <div class="form-group" id="deliveryRatingSection">
                <label>Delivery Rating (Optional)</label>
                <select name="delivery_rating">
                    <option value="" selected>Select a rating...</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5) - Fast & Friendly</option>
                    <option value="4">⭐⭐⭐⭐ (4) - Good</option>
                    <option value="3">⭐⭐⭐ (3) - Okay</option>
                    <option value="2">⭐⭐ (2) - Slow/Unprofessional</option>
                    <option value="1">⭐ (1) - Terrible</option>
                </select>
            </div>

            <div class="form-group">
                <label>Comment (Optional, Max 500 chars)</label>
                <textarea name="comment" maxlength="500" placeholder="Tell us what you liked or what could be improved..."></textarea>
            </div>

            <div class="popup-btns">
                <button type="button" class="btn btn-ghost" style="justify-content: center" onclick="closeReviewModal()">Cancel</button>
                <button type="submit" class="btn btn-orange" style="justify-content: center" id="submitReviewBtn">
                    <span id="btnText">Submit Review</span>
                    <span id="btnLoading" style="display: none;">
                        <svg class="spinner" viewBox="0 0 50 50">
                            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                        </svg>
                        Submitting...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    #reviewPopupOverlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 1rem;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    #reviewPopupOverlay.open { display: flex; }

    .review-popup {
        background: #fff;
        padding: 2.5rem 2rem 2rem;
        border-radius: 20px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        position: relative;
        transform: translateY(0);
        animation: slideUp 0.3s ease;
    }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    .modal-close-btn {
        position: absolute;
        top: 1rem;
        right: 1.25rem;
        background: none;
        border: none;
        font-size: 1.75rem;
        line-height: 1;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
    }
    .modal-close-btn:hover {
        color: var(--orange-main);
        transform: scale(1.1);
    }

    .review-popup h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-family: 'Sora', sans-serif;
    }
    /* Rest of style same... */
    .review-popup p { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; }
    .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1.5px solid var(--border); border-radius: 10px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; }
    .form-group select:focus, .form-group textarea:focus { border-color: var(--orange-main); }
    .form-group textarea { height: 100px; resize: vertical; }
    .popup-btns { display: flex; gap: 1rem; margin-top: 1.5rem; }
    .popup-btns .btn { flex: 1; padding: 0.85rem; font-size: 0.95rem; font-weight: 700; border-radius: 12px; cursor: pointer; transition: 0.2s; border: none; }
    .btn-ghost { background: var(--bg); color: var(--text-secondary); border: 1.5px solid var(--border) !important; }
    .btn-orange { background: var(--orange-main); color: #fff; display: flex; justify-content: center; align-items: center; gap: 0.5rem; }
    .btn-orange:hover { background: #EA580C; }

    /* Spinner Animation */
    .spinner { animation: rotate 2s linear infinite; width: 20px; height: 20px; }
    .spinner .path { stroke: #fff; stroke-linecap: round; animation: dash 1.5s ease-in-out infinite; }
    @keyframes rotate { 100% { transform: rotate(360deg); } }
    @keyframes dash {
        0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
        50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
        100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
    }
</style>

<script>
    function openReviewModal(orderId, restaurantId, partnerId, restaurantName, partnerName = null) {
        document.getElementById('modalOrderId').value = orderId;
        document.getElementById('modalRestaurantId').value = restaurantId;
        
        const validPartner = (partnerId && partnerId !== 'null' && partnerId !== '');
        document.getElementById('modalPartnerId').value = validPartner ? partnerId : '';
        document.getElementById('deliveryRatingSection').style.display = validPartner ? 'block' : 'none';

        // Update Partner Name Display
        const partnerContainer = document.getElementById('modalPartnerNameContainer');
        const partnerNameEl = document.getElementById('modalPartnerName');
        if (validPartner && partnerName && partnerName !== 'null') {
            partnerNameEl.innerText = partnerName;
            partnerContainer.style.display = 'block';
        } else {
            partnerContainer.style.display = 'none';
        }

        document.getElementById('modalRestaurantName').innerText = restaurantName;
        document.getElementById('reviewPopupOverlay').classList.add('open');
    }

    function closeReviewModal() {
        document.getElementById('reviewPopupOverlay').classList.remove('open');
    }

    // Handle Form Submission Animation
    document.getElementById('reviewForm').onsubmit = function() {
        const btn = document.getElementById('submitReviewBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');
        
        btn.disabled = true;
        btn.style.opacity = '0.8';
        btn.style.cursor = 'not-allowed';
        btnText.style.display = 'none';
        btnLoading.style.display = 'flex';
        btnLoading.style.alignItems = 'center';
        btnLoading.style.gap = '8px';
    };
</script>
