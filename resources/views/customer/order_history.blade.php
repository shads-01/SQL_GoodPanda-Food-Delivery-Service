<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History – GoodPanda</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange-main: #F97316;
            --orange-light: #FED7AA;
            --orange-pale: #FFF7ED;
            --text-primary: #1C1917;
            --text-secondary: #78716C;
            --text-muted: #A8A29E;
            --border: #E7E5E4;
            --bg: #FAFAF9;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
        }

        h1,
        h2,
        h3 {
            font-family: 'Sora', sans-serif;
        }

        .page-wrap {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .back-btn:hover {
            color: var(--orange-main);
        }

        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .order-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .order-id {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .order-rest {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .order-date {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .order-status {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .status-delivered {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        .order-total {
            font-weight: 700;
            font-size: 1rem;
            color: var(--orange-main);
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.4rem 0.8rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.85rem;
            text-decoration: none;
            color: var(--text-primary);
        }

        .pagination a:hover {
            border-color: var(--orange-main);
            color: var(--orange-main);
        }

        .pagination .active {
            background: var(--orange-main);
            color: white;
            border-color: var(--orange-main);
        }
    </style>
</head>

<body>
    @include('components.customer_navbar')

    <div class="page-wrap">
        <a href="{{ route('customer_profile') }}" class="back-btn">← Back to Profile</a>
        <h1 class="page-title">📋 Order History</h1>

        @forelse($orders as $order)
        <div class="order-card">
            <div class="order-card-header">
                <div>
                    <div class="order-id">Order #{{ $order->order_id }}</div>
                    <div class="order-rest">{{ $order->restaurant_name }}</div>
                    <div class="order-date">{{ \Carbon\Carbon::parse($order->order_datetime)->format('d M Y, h:i A') }}</div>
                </div>
                <div style="text-align:right;">
                    <span class="order-status status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
                    <div class="order-total" style="margin-top:0.4rem;">৳{{ number_format($order->total_amount,0) }}</div>
                </div>
            </div>
            <hr style="border:none;border-top:1px solid var(--border);margin-bottom:0.6rem;">
            <div style="font-size:0.82rem;color:var(--text-secondary);">
                Delivery fee: ৳{{ number_format($order->delivery_fee,0) }} &nbsp;·&nbsp;
                Discount: ৳{{ number_format($order->discount_amount,0) }}
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
            <p style="font-size:2rem;margin-bottom:0.5rem;">📋</p>
            <p>No orders yet.</p>
        </div>
        @endforelse

        <div class="pagination">
            {{ $orders->links('vendor.pagination.custom') }}
        </div>
    </div>
</body>

</html>