<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoodPanda</title>
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
            --surface: #FFFFFF;
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
        h3,
        .font-display {
            font-family: 'Sora', sans-serif;
        }

        .page-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        /* ---- Search Bar ---- */
        .search-wrap {
            margin-bottom: 2.5rem;
            display: flex;
            justify-content: center;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 640px;
        }

        .search-box input {
            width: 100%;
            padding: 0.85rem 7rem 0.85rem 3rem;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            background: #fff;
            font-size: 0.95rem;
            font-family: inherit;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-box input:focus {
            border-color: var(--orange-main);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.12);
        }

        .search-box .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--orange-main);
            color: white;
            border: none;
            padding: 0.55rem 1.3rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
        }

        .search-btn:hover {
            background: #EA580C;
        }

        .search-suggestions {
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

        .search-suggestions.open {
            display: block;
        }

        .search-suggestions li {
            list-style: none;
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-primary);
        }

        .search-suggestions li:hover {
            background: var(--bg);
        }

        .sug-type {
            font-size: 0.7rem;
            background: var(--orange-pale);
            color: var(--orange-main);
            padding: 2px 6px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ---- Section Titles ---- */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .section-link {
            font-size: 0.875rem;
            color: var(--orange-main);
            text-decoration: none;
            font-weight: 500;
        }

        .section-link:hover {
            text-decoration: underline;
        }

        /* ---- Restaurant Cards ---- */
        .rest-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 3rem;
        }

        @media(max-width:700px) {
            .rest-grid {
                grid-template-columns: 1fr;
            }
        }

        .rest-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            transition: transform 0.18s, box-shadow 0.18s;
        }

        .rest-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.11);
        }

        .rest-cover {
            height: 150px;
            background: #FFF7ED;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rest-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rest-cover-ph {
            font-size: 3rem;
        }

        .rest-body {
            padding: 0.9rem;
        }

        .rest-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }

        .rest-loc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
        }

        .rest-rating {
            font-size: 0.8rem;
            color: #F97316;
            font-weight: 600;
        }

        .rest-btn {
            margin-top: 0.6rem;
            background: var(--orange-main);
            color: #fff;
            border: none;
            padding: 0.45rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
        }

        .rest-btn:hover {
            background: #EA580C;
        }

        /* ---- Offer Cards ---- */
        .offer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 3rem;
        }

        /* ---- Footer ---- */
        footer {
            background: #1C1917;
            color: #D6D3D1;
            padding: 2.5rem 2rem 1.5rem;
            margin-top: 2rem;
        }

        .footer-inner {
            max-width: 960px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-logo {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
            margin-bottom: 0.4rem;
        }

        .footer-logo span {
            color: var(--orange-main);
        }

        .footer-tagline,
        .footer-contact {
            font-size: 0.8rem;
            color: #A8A29E;
            margin-bottom: 0.5rem;
            line-height: 1.8;
        }

        .footer-bottom {
            border-top: 1px solid #292524;
            padding-top: 1rem;
            font-size: 0.75rem;
            color: #78716C;
            margin-top: 1rem;
        }

        .footer-bottom a {
            color: #78716C;
            text-decoration: none;
        }
    </style>
</head>

<body>

    @include('components.customer_navbar')

    <div class="page-wrap">



        <!-- Top Restaurants -->
        <div class="section-header">
            <h2 class="section-title">🏆 Top Restaurants</h2>
        </div>
        <div class="rest-grid">
            @forelse($topRestaurants as $r)
            <div class="rest-card">
                <div class="rest-cover">
                    @if(!empty($r->cover_image) && str_starts_with($r->cover_image,'http'))
                    <img src="{{ $r->cover_image }}" alt="{{ $r->name }}">
                    @else
                    <span class="rest-cover-ph">🍽️</span>
                    @endif
                </div>
                <div class="rest-body">
                    <div class="rest-name">{{ $r->name }}</div>
                    <div class="rest-loc">📍 {{ $r->location }}</div>
                    <div class="rest-rating">★ {{ number_format($r->avg_rating,1) }} <span style="color:var(--text-muted);font-weight:400;">({{ $r->total_reviews }} reviews)</span></div>
                    <button class="rest-btn" onclick="window.location='{{ route('home') }}'">Order Now</button>
                </div>
            </div>
            @empty
            <p style="color:var(--text-muted);grid-column:1/-1;">No restaurants yet.</p>
            @endforelse
        </div>

        <!-- Top Offers -->
        <div class="section-header">
            <h2 class="section-title">🏷️ Top Offers</h2>
            <a href="{{ route('customer.offers') }}" class="section-link">Show all offers →</a>
        </div>
        <div class="offer-grid">
            @forelse($topOffers as $item)
            @include('components.menu_item_card', ['item' => $item])
            @empty
            <p style="color:var(--text-muted);grid-column:1/-1;">No offers available right now.</p>
            @endforelse
        </div>

    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-inner">
            <div class="footer-logo">Good<span>Panda</span> 🐼</div>
            <p class="footer-tagline">Fast delivery, great restaurants, happy you.</p>
            <div class="footer-contact">support@goodpanda.com &nbsp;·&nbsp; +880 1234 567890</div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} GoodPanda. All rights reserved.
                &nbsp;·&nbsp; <a href="#">Privacy</a> &nbsp;·&nbsp; <a href="#">Terms</a>
            </div>
        </div>
    </footer>

    @include('components.menu_item_popup')



</body>

</html>