<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite('resources/css/app.css')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }

        .dash {
            padding: 2rem 1.5rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        /* Top bar */
        .topbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .welcome-h {
            font-size: clamp(26px, 4vw, 38px);
            font-weight: 800;
            color: #111;
            line-height: 1.1;
        }

        .welcome-h .name {
            color: #F97316;
        }

        .welcome-sub {
            font-size: 13px;
            color: #9CA3AF;
            margin-top: 4px;
            font-style: italic;
            font-weight: 300;
        }

        .topbar-right {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
        }

        .pill {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 100px;
            border: 1px solid #E5E7EB;
            background: #fff;
            color: #6B7280;
        }

        .pill.accent {
            background: #FFF7ED;
            color: #C2410C;
            border-color: #FED7AA;
        }

        .pill svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        /* Stat grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 1.75rem;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #F3F4F6;
            border-radius: 16px;
            padding: 1.25rem;
            transition: border-color .2s;
        }

        .stat-card:hover {
            border-color: #D1D5DB;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-icon svg {
            width: 16px;
            height: 16px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #9CA3AF;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: clamp(22px, 3vw, 28px);
            font-weight: 700;
            color: #111;
            line-height: 1;
        }

        .stat-sub {
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 8px;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 8px;
            padding: 3px 8px;
            border-radius: 100px;
        }

        .badge-up {
            background: #EAF3DE;
            color: #3B6D11;
        }

        .stat-card.active-card {
            background: #F97316;
            border-color: #F97316;
        }

        .active-card .stat-label,
        .active-card .stat-sub {
            color: rgba(255, 255, 255, .65);
        }

        .active-card .stat-value {
            color: #fff;
            font-size: 42px;
            margin-bottom: 8px;
        }

        .pulse-dot {
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.6s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .3;
            }
        }

        /* Section cards */
        .section-card {
            background: #fff;
            border: 1px solid #F3F4F6;
            border-radius: 20px;
            padding: 1.75rem;
            margin-bottom: 1.25rem;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #111;
        }

        .section-meta {
            font-size: 12px;
            color: #9CA3AF;
            font-weight: 300;
            font-style: italic;
            margin-top: 2px;
        }

        .sec-link {
            font-size: 12px;
            font-weight: 600;
            color: #F97316;
            text-decoration: none;
            flex-shrink: 0;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid #FED7AA;
            background: #FFF7ED;
            transition: background .15s;
        }

        .sec-link:hover {
            background: #FED7AA;
        }

        /* Order cards */
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 10px;
        }

        .order-card {
            border: 1px solid #F3F4F6;
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            background: #FAFAF9;
            transition: border-color .2s, transform .15s;
        }

        .order-card:hover {
            border-color: #FED7AA;
            transform: translateY(-1px);
        }

        .order-id {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #9CA3AF;
        }

        .order-name {
            font-size: 15px;
            font-weight: 600;
            color: #111;
            margin-top: 2px;
        }

        .order-foot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #F3F4F6;
        }

        .order-time {
            font-size: 11px;
            color: #9CA3AF;
            font-style: italic;
        }

        .status-pill {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 100px;
        }

        .s-pending {
            background: #FAEEDA;
            color: #854F0B;
        }

        .s-confirmed {
            background: #E6F1FB;
            color: #185FA5;
        }

        .s-preparing {
            background: #FFF7ED;
            color: #C2410C;
        }

        .s-ready {
            background: #EAF3DE;
            color: #3B6D11;
        }

        .status-select-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            border-radius: 100px;
            padding: 4px 8px 4px 10px;
            gap: 4px;
            cursor: pointer;
            transition: filter 0.15s;
        }

        .status-select-wrap:hover {
            filter: brightness(0.95);
        }

        .status-select {
            appearance: none;
            -webkit-appearance: none;
            background: transparent;
            border: none;
            outline: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: inherit;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .status-chevron {
            width: 8px;
            height: 8px;
            flex-shrink: 0;
            color: inherit;
            opacity: 0.7;
            pointer-events: none;
        }

        /* Bottom two-col */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        @media (max-width: 640px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        /* Reviews */
        .review-item {
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #F3F4F6;
            margin-bottom: 8px;
            background: #FAFAF9;
        }

        .review-item:last-child {
            margin-bottom: 0;
        }

        .reviewer-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .review-text {
            font-size: 12px;
            color: #6B7280;
            font-style: italic;
            margin-top: 3px;
            line-height: 1.5;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .star svg {
            width: 11px;
            height: 11px;
        }

        .star-on {
            color: #BA7517;
        }

        .star-off {
            color: #D1D5DB;
        }

        /* Bestseller */
        .bestseller-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 14px;
            background: #FFF7ED;
            border: 1px solid #FED7AA;
        }

        .bs-icon {
            width: 52px;
            height: 52px;
            background: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #FED7AA;
            flex-shrink: 0;
            font-size: 22px;
        }

        .bs-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: #C2410C;
            margin-bottom: 3px;
        }

        .bs-name {
            font-size: 16px;
            font-weight: 700;
            color: #7C2D12;
            line-height: 1.2;
        }

        .bs-sub {
            font-size: 11px;
            color: #C2410C;
            margin-top: 4px;
        }

        .divider {
            height: 1px;
            background: #F3F4F6;
            margin: 1rem 0;
        }

        .runner-up-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .runner-up {
            padding: 10px 12px;
            border-radius: 10px;
            background: #FAFAF9;
            border: 1px solid #F3F4F6;
        }

        .runner-up-rank {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #9CA3AF;
            margin-bottom: 3px;
        }

        .runner-up-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .runner-up-qty {
            font-size: 11px;
            color: #9CA3AF;
            margin-top: 2px;
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            background: #FFF7ED;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .empty-icon svg {
            width: 24px;
            height: 24px;
            color: #F97316;
        }

        .empty-title {
            font-size: 15px;
            font-weight: 600;
            color: #111;
        }

        .empty-sub {
            font-size: 13px;
            color: #9CA3AF;
            margin-top: 4px;
            max-width: 240px;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="dash">

        {{-- Top bar --}}
        <div class="topbar">
            <div>
                <h1 class="welcome-h font-sora">
                    Welcome back, <span class="name">{{ $restaurant->name }}</span>
                </h1>
                <p class="welcome-sub">Here's your restaurant at a glance today.</p>
            </div>
            <div class="topbar-right">
                <div class="pill accent">
                    <svg class="w-3 h-3 text-orange-500" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                        </polygon>
                    </svg>
                    {{ number_format($restaurant->avg_rating ?? 0, 1) }} Rating
                </div>
                <div class="pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    {{ date('M d, Y') }}
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="stat-grid">

            {{-- Revenue --}}
            <div class="stat-card">
                <div class="stat-icon" style="background:#FFF7ED">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                </div>
                <p class="stat-label">Total Revenue</p>
                <h2 class="stat-value">৳{{ number_format($stats->total_revenue ?? 0, 0) }}</h2>
            </div>

            {{-- Completed Orders --}}
            <div class="stat-card">
                <div class="stat-icon" style="background:#E6F1FB">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#185FA5" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                </div>
                <p class="stat-label">Completed Orders</p>
                <h2 class="stat-value">{{ $stats->total_completed_orders ?? 0 }}</h2>
                <p class="stat-sub">Avg ৳{{ number_format($stats->average_order_value ?? 0, 0) }} per order</p>
            </div>

            {{-- Menu Inventory --}}
            <div class="stat-card">
                <div class="stat-icon" style="background:#F3F4F6">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                        <path d="M3 3h18v18H3z" />
                        <path d="M3 9h18" />
                        <path d="M9 21V9" />
                    </svg>
                </div>
                <p class="stat-label">Menu Items</p>
                <h2 class="stat-value">{{ $itemCount }}</h2>
                <div class="stat-sub" style="display:flex; gap:10px; font-weight:500;">
                    <span style="color:#059669"><span
                            style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#059669;margin-right:2px;"></span>{{ $availableItems }}
                        Live</span>
                    <span style="color:#DC2626"><span
                            style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#DC2626;margin-right:2px;"></span>{{ $unavailableItems }}
                        Hidden</span>
                </div>
            </div>

            {{-- Active Now --}}
            <div class="stat-card active-card">
                <p class="stat-label">Active Now</p>
                <h2 class="stat-value">{{ count($activeOrders) }}</h2>
                <p class="stat-sub" style="display:flex;align-items:center;gap:6px">
                    <span class="pulse-dot"></span>
                    Orders needing attention
                </p>
            </div>

        </div>

        {{-- Pending Orders --}}
        <div class="section-card">
            <div class="section-head">
                <div>
                    <h3 class="section-title">Pending Orders</h3>
                    <p class="section-meta">Waiting for preparation or confirmation</p>
                </div>
                <a href="{{ route('restaurant.orders', ['filter' => 'pending']) }}" class="sec-link">Manage all →</a>
            </div>

            @if(count($activeOrders) > 0)
                <div class="orders-grid">
                    @foreach($activeOrders as $order)
                        @php
                            $statusClass = match ($order->order_status) {
                                'pending' => 's-pending',
                                'confirmed' => 's-confirmed',
                                'preparing' => 's-preparing',
                                'ready' => 's-ready',
                                default => 's-pending',
                            };
                        @endphp
                        <div class="order-card">
                            <div class="order-id">Order #{{ $order->order_id }}</div>
                            <div class="order-name">{{ $order->customer_name }}</div>
                            <div class="order-foot">
                                @if($order->order_status === 'pending')
                                    <span class="status-pill s-pending">Pending</span>
                                @else
                                    <form action="{{ route('restaurant.updateOrderStatus', $order->order_id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <div class="status-select-wrap {{ $statusClass }}">
                                            <select name="status" onchange="this.form.submit()" class="status-select">
                                                <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}
                                                    disabled hidden>Confirmed</option>
                                                <option value="preparing" {{ $order->order_status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                                <option value="ready" {{ $order->order_status === 'ready' ? 'selected' : '' }}>Ready
                                                </option>
                                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <svg class="status-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </form>
                                @endif
                                <span class="order-time">
                                    {{ \Carbon\Carbon::parse($order->order_datetime)->diffForHumans() }} ·
                                    ৳{{ number_format($order->subtotal, 0) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <h4 class="empty-title">Kitchen is peaceful</h4>
                    <p class="empty-sub">No pending orders right now. A great time to update your menu or check analytics.
                    </p>
                </div>
            @endif
        </div>

        {{-- Bottom row --}}
        <div class="two-col">

            {{-- Recent Feedback --}}
            <div class="section-card" style="margin-bottom:0">
                <div class="section-head">
                    <h3 class="section-title">Recent Feedback</h3>
                </div>
                @if(count($recentReviews) > 0)
                    @foreach(array_slice($recentReviews, 0, 5) as $review)
                        <div class="review-item">
                            <div style="display:flex;justify-content:space-between;align-items:center">
                                <span class="reviewer-name">{{ $review->reviewer_name }}</span>
                                <div class="stars">
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $review->customer_rating)
                                                <svg class="w-3 h-3 text-orange-500" viewBox="0 0 24 24" fill="currentColor"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                    </polygon>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="review-text">"{{ $review->comment ?? 'No comment left.' }}"</p>
                        </div>
                    @endforeach
                @else
                    <p style="text-align:center;font-size:13px;color:#9CA3AF;font-style:italic;padding:2rem 0">No recent
                        feedback yet.</p>
                @endif
            </div>

            {{-- Bestseller --}}
            <div class="section-card" style="margin-bottom:0">
                <div class="section-head">
                    <h3 class="section-title">Bestseller</h3>
                    <a href="{{ route('restaurant.analytics') }}" class="sec-link">Analytics →</a>
                </div>
                @if(count($topItems) > 0)
                    <div class="bestseller-card">
                        <div class="flex-none w-32 h-32 rounded-xl overflow-hidden bg-gray-100 relative"
                            style="min-width: 8rem;">
                            <img src="{{ $topItems[0]->item_image }}" alt="{{ $topItems[0]->item_name }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="bs-label">Most ordered</div>
                            <div class="bs-name">{{ $topItems[0]->item_name }}</div>
                            <div class="bs-sub">{{ $topItems[0]->total_quantity_sold }} portions sold this month</div>
                        </div>
                    </div>
                    @if(count($topItems) > 1)
                        <div class="divider"></div>
                        <div class="runner-up-grid">
                            @foreach(array_slice((array) $topItems, 1, 4) as $i => $item)
                                @php
                                    $rank = match ($i) {
                                        0 => '2nd place',
                                        1 => '3rd place',
                                        2 => '4th place',
                                        3 => '5th place',
                                        default => ($i + 2) . 'th place'
                                    };
                                @endphp
                                <div class="runner-up">
                                    <div class="runner-up-rank">{{ $rank }}</div>
                                    <div class="runner-up-name">{{ $item->item_name }}</div>
                                    <div class="runner-up-qty">{{ $item->total_quantity_sold }} portions</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <p style="text-align:center;font-size:13px;color:#9CA3AF;font-style:italic;padding:2rem 0">No sales data
                        yet.</p>
                @endif
            </div>

        </div>
    </div>

</body>

</html>