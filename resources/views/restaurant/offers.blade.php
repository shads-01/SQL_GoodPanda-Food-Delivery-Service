<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers Management | {{ $restaurant->name ?? 'Restaurant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1a1612;
            --cream: #faf7f2;
            --mist: #ede8df;
            --ember: #e85d2f;
            --ember-deep: #c44a20;
            --ink-faint: #3d3730;
            --ink-mid: #7a7268;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(ellipse 70% 50% at 100% 0%, rgba(232,93,47,0.05) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .page-wrap { position: relative; z-index: 1; }

        /* ── Header ── */
        .eyebrow {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ember);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }
        .eyebrow::before {
            content: '';
            display: block;
            width: 18px;
            height: 2px;
            background: var(--ember);
            border-radius: 2px;
        }

        /* ── Create button ── */
        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 11px 20px;
            border-radius: 12px;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 3px 14px rgba(26,22,18,0.15);
        }
        .btn-create:hover {
            background: var(--ember);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(232,93,47,0.3);
        }

        /* ── Alert banners ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .alert-error  { background: #fff5f3; border: 1px solid #fad5cc; color: #c44a20; }
        .alert-success { background: #f0faf4; border: 1px solid #bbdfc8; color: #2d6a4a; }

        /* ── Offer card ── */
        .offer-card {
            background: #fff;
            border: 1px solid var(--mist);
            border-radius: 20px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .offer-card:hover {
            box-shadow: 0 6px 28px rgba(26,22,18,0.08);
            border-color: #ddd7ce;
        }

        /* Icon block */
        .offer-icon {
            flex-shrink: 0;
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #fff8f5;
            border: 1px solid #fde8df;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ember);
        }

        /* Body */
        .offer-body { flex: 1; min-width: 0; }

        .offer-title {
            font-family: 'DM Sans';
            font-size: 17px;
            font-weight: 700;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 6px;
        }

        .offer-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 8px;
        }

        /* Pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 100px;
            white-space: nowrap;
        }
        .pill-target   { background: var(--mist);   color: var(--ink-faint); }
        .pill-active   { background: #e8f5ed; color: #2d6a4a; }
        .pill-expired  { background: #fff0ee; color: #b94030; }
        .pill-upcoming { background: #eef4ff; color: #2b52a0; }
        .pill-min      { background: #f0f0ff; color: #4a44a0; border: 1px solid #dcdaff; }

        .offer-date {
            font-size: 12px;
            color: var(--ink-mid);
            font-weight: 500;
        }

        /* Discount badge */
        .discount-badge {
            flex-shrink: 0;
            text-align: right;
            padding: 0 8px;
        }
        .discount-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-mid);
            margin-bottom: 2px;
        }
        .discount-value {
            font-family:  serif;
            font-size: 22px;
            font-weight: 900;
            color: var(--ember);
            line-height: 1;
            white-space: nowrap;
        }

        /* Actions */
        .offer-actions {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--mist);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-mid);
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
            text-decoration: none;
        }
        .action-btn:hover         { background: #fff8f5; color: var(--ember); border-color: #fde8df; }
        .action-btn.danger:hover  { background: #fff5f3; color: #c44a20; border-color: #fad5cc; }
        .action-btn button {
            all: unset;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Empty state */
        .empty-state {
            padding: 64px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid var(--mist);
            border-radius: 20px;
            color: var(--ink-mid);
            text-align: center;
        }
        .empty-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #fff8f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ember);
            margin-bottom: 16px;
            opacity: 0.6;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 6px;
            justify-content: center;
            margin-top: 28px;
        }
        .pagination a,
        .pagination span {
            padding: 6px 12px;
            border: 1px solid var(--mist);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            color: var(--ink-faint);
            background: #fff;
            transition: border-color 0.15s, color 0.15s;
        }
        .pagination a:hover { border-color: var(--ember); color: var(--ember); }
        .pagination span[aria-current="page"] span,
        .pagination .active {
            background: var(--ink);
            color: #fff;
            border-color: var(--ink);
        }

        /* Animate in */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeUp 0.4s ease both; }
        .delay-1 { animation-delay: 0.06s; }
        .delay-2 { animation-delay: 0.12s; }
    </style>
</head>

<body>
    <x-restaurant_navbar :restaurant="$restaurant" />

    <div class="page-wrap max-w-4xl mx-auto px-4 md:px-8 py-10 pb-20">

        {{-- Header --}}
        <div class="mb-8 flex items-end justify-between gap-6 animate-in">
            <div>
                <p class="eyebrow">Promotions</p>
                <h1 style="font-family:'DM Sans'; font-size:clamp(2rem,5vw,2.8rem); font-weight:900; line-height:1.05; color:var(--ink);">
                    Active Offers
                </h1>
            </div>
            <a href="{{ route('restaurant.add_offer') }}" class="btn-create">
                <i data-feather="zap" class="w-4 h-4"></i> New Offer
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('error'))
            <div class="alert alert-error animate-in delay-1">
                <i data-feather="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success animate-in delay-1">
                <i data-feather="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Offer list --}}
        <div class="flex flex-col gap-3 animate-in delay-2">
            @forelse($offers as $offer)
                @php
                    $now   = \Carbon\Carbon::now();
                    $start = \Carbon\Carbon::parse($offer->start_datetime);
                    $end   = \Carbon\Carbon::parse($offer->end_datetime);
                @endphp
                <div class="offer-card">

                    {{-- Icon --}}
                    <div class="offer-icon">
                        <i data-feather="gift" class="w-5 h-5"></i>
                    </div>

                    {{-- Body --}}
                    <div class="offer-body">
                        <div class="offer-title">{{ $offer->offer_title }}</div>
                        <div class="offer-meta">
                            {{-- Target --}}
                            <span class="pill pill-target">
                                {{ strtoupper($offer->target_type) }}
                                @if($offer->target_type === 'item' && $offer->item_name)
                                    · {{ $offer->item_name }}
                                @elseif($offer->target_type === 'category' && $offer->category_name)
                                    · {{ $offer->category_name }}
                                @endif
                            </span>
                            {{-- Status --}}
                            @if($end < $now)
                                <span class="pill pill-expired"><i data-feather="clock" class="w-3 h-3"></i> Expired</span>
                            @elseif($start > $now)
                                <span class="pill pill-upcoming"><i data-feather="calendar" class="w-3 h-3"></i> Upcoming</span>
                            @else
                                <span class="pill pill-active"><i data-feather="activity" class="w-3 h-3"></i> Active</span>
                            @endif
                            {{-- Min order --}}
                            @if($offer->min_order_amount)
                                <span class="pill pill-min">Min ৳{{ number_format($offer->min_order_amount, 0) }}</span>
                            @endif
                        </div>
                        <p class="offer-date">
                            {{ $start->format('M d, Y') }} → {{ $end->format('M d, Y') }}
                        </p>
                    </div>

                    {{-- Discount value --}}
                    <div class="discount-badge">
                        <p class="discount-label">{{ str_replace('_', ' ', $offer->discount_type) }}</p>
                        <p class="discount-value">
                            @if($offer->discount_type === 'percentage')
                                {{ rtrim(rtrim($offer->discount_value, '0'), '.') }}%
                            @elseif($offer->discount_type === 'flat')
                                ৳{{ rtrim(rtrim($offer->discount_value, '0'), '.') }}
                            @else
                                Free<br><span style="font-size:13px; color:var(--ink-mid); font-family:'DM Sans',sans-serif; font-weight:600;">Delivery</span>
                            @endif
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="offer-actions">
                        @if (!($end < $now))
                            <a href="#" onclick="alert('Offer editing coming soon.'); return false;" class="action-btn" title="Edit">
                                <i data-feather="edit-2" class="w-4 h-4"></i>
                            </a>
                        @endif
                        <form action="{{ route('restaurant.deleteOffer', $offer->offer_id) }}" method="POST"
                            onsubmit="return confirm('Delete this offer permanently?');" class="m-0">
                            @csrf
                            @method('DELETE')
                            <div class="action-btn danger">
                                <button type="submit" title="Delete">
                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i data-feather="sun" class="w-6 h-6"></i>
                    </div>
                    <p style="font-size:18px; font-weight:700; color:var(--ink-faint); margin-bottom:4px;">No offers yet</p>
                    <p style="font-size:13px; color:var(--ink-mid);">Create one to start boosting your sales.</p>
                </div>
            @endforelse
        </div>

        @if($offers->hasPages())
            <div class="pagination">
                {{ $offers->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace({ 'stroke-width': 2 });
        });
    </script>
</body>
</html>