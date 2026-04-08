<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | GoodPanda</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        /* Inheriting your GoodPanda UI variables */
        :root {
            --orange-main: #F97316;
            --orange-light: #FED7AA;
            --orange-pale: #FFF7ED;
            --text-primary: #1C1917;
            --text-secondary: #78716C;
            --text-muted: #A8A29E;
            --border: #E7E5E4;
            --surface: #FFFFFF;
            --bg: #FAFAF9;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text-primary); }
        h1, h2, h3, .font-display { font-family: 'Sora', sans-serif; }

        .page-container { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
        
        .page-header { margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; }
        .page-header h1 { font-size: 1.8rem; font-weight: 700; }
        
        .btn-back { color: var(--text-secondary); text-decoration: none; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: #fff; border: 1px solid var(--border); transition: 0.2s; }
        .btn-back:hover { border-color: var(--orange-main); color: var(--orange-main); }

        /* Order Cards */
        .order-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.25rem; display: flex; flex-direction: column; gap: 1rem; box-shadow: 0 1px 6px rgba(0, 0, 0, 0.04); }
        .order-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid var(--border); padding-bottom: 1rem; }
        .order-info h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; }
        .order-info p { font-size: 0.85rem; color: var(--text-secondary); }
        .order-status-badge { font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em; }
        
        .status-delivered { background: #D1FAE5; color: #065F46; }
        .status-pending { background: #FEF3C7; color: #92400E; }
        .status-cancelled { background: #FEE2E2; color: #991B1B; }

        .order-footer { display: flex; justify-content: space-between; align-items: center; }
        .order-total { font-size: 1.1rem; font-weight: 700; color: var(--orange-main); }
        
        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.15s; font-family: inherit; }
        .btn-orange { background: var(--orange-main); color: #fff; }
        .btn-orange:hover { background: #EA580C; }
        .btn-ghost { background: none; border: 1.5px solid var(--border); color: var(--text-primary); }
        .btn-ghost:hover { border-color: var(--orange-main); color: var(--orange-main); }
        .btn-outline-orange { background: var(--orange-pale); border: 1.5px solid var(--orange-light); color: var(--orange-main); }
        .btn-outline-orange:hover { background: var(--orange-main); color: #fff; }

        /* Review Modal */
        #reviewPopupOverlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
        #reviewPopupOverlay.open { display: flex; }
        
        .review-popup { background: #fff; border-radius: 18px; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); }
        .review-popup h3 { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.25rem; margin-bottom: 0.5rem; color: var(--text-primary); }
        .review-popup p { font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1.5rem; }
        
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; }
        
        select, textarea { width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 0.75rem; font-size: 0.9rem; font-family: inherit; outline: none; transition: border-color 0.2s; }
        select:focus, textarea:focus { border-color: var(--orange-main); }
        textarea { resize: vertical; min-height: 100px; }
        
        .popup-btns { display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem; }
    </style>
</head>

<body>
    @include('components.customer_navbar')

    <div class="page-container">
        <div class="page-header">
            <a href="{{ route('customer_profile') }}" class="btn-back">←</a>
            <div>
                <h1>Order History</h1>
                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.25rem;">View your past orders and leave reviews.</p>
            </div>
        </div>
    
        <div class="order-list">
            @forelse($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>{{ $order->restaurant_name ?? 'Unknown Restaurant' }}</h3>
                            <p>Order #{{ $order->order_id }} • {{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, Y h:i A') }}</p>
                        </div>
                        <span class="order-status-badge status-{{ strtolower($order->order_status) }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">৳{{ number_format($order->total_amount, 2) }}</div>
                        
                        <div class="order-actions">
                            {{-- Check if order is delivered AND user hasn't reviewed it yet --}}
                            @if($order->order_status == 'delivered')
                                @if(!$order->review_id)
                                    <button class="btn btn-outline-orange" 
                                            onclick="openReviewModal({{ $order->order_id }}, {{ $order->restaurant_id }}, {{ $order->partner_id ?? 'null' }}, '{{ addslashes($order->restaurant_name) }}')">
                                        ⭐ Write a Review
                                    </button>
                                @else
                                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">⭐ Reviewed</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 3rem; background: #fff; border-radius: 16px; border: 1px dashed var(--border);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🍽️</div>
                    <h3 style="margin-bottom: 0.5rem;">No orders yet</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">Looks like you haven't placed any orders yet.</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    </div>

    @include('components.review_modal')
</body>
</html>