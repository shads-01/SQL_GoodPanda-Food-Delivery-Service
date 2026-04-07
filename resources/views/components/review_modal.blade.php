<div id="reviewPopupOverlay">
    <div class="review-popup">
        <h3>Rate Your Experience</h3>
        <p>How was your food from <strong id="modalRestaurantName"></strong>?</p>
        
        <form action="{{ route('customer.review.store') }}" method="POST">
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

            <div class="form-group">
                <label>Select Delivery Partner (Optional)</label>
                <select name="partner_id" id="modalPartnerIdSelect">
                    <option value="" selected>No partner assigned...</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->id }}">{{ $partner->name }} (Rider)</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
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
                <button type="submit" class="btn btn-orange" style="justify-content: center">Submit Review</button>
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
        z-index: 1000;
        padding: 1rem;
    }
    #reviewPopupOverlay.open {
        display: flex;
    }
    .review-popup {
        background: #fff;
        padding: 2rem;
        border-radius: 16px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    .review-popup h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }
    .review-popup p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--primary);
    }
    .form-group textarea {
        height: 100px;
        resize: vertical;
    }
    .popup-btns {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .popup-btns .btn {
        flex: 1;
        padding: 0.75rem;
        font-size: 0.95rem;
    }
</style>

<script>
    function openReviewModal(orderId, restaurantId, partnerId, restaurantName) {
        document.getElementById('modalOrderId').value = orderId;
        document.getElementById('modalRestaurantId').value = restaurantId;
        
        const partnerSelect = document.getElementById('modalPartnerIdSelect');
        
        if (partnerId && partnerId !== 'null') {
            partnerSelect.value = partnerId;
        } else {
            partnerSelect.value = "";
        }

        document.getElementById('modalRestaurantName').innerText = restaurantName;
        document.getElementById('reviewPopupOverlay').classList.add('open');
    }

    function closeReviewModal() {
        document.getElementById('reviewPopupOverlay').classList.remove('open');
    }
</script>
