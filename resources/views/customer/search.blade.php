<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search – GoodPanda</title>
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
            max-width: 1100px;
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

        /* Search bar */
        .search-row {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 600px;
        }

        .search-box input {
            width: 100%;
            padding: 0.8rem 6.5rem 0.8rem 2.75rem;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            background: #fff;
            font-size: 0.92rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: var(--orange-main);
        }

        .search-box .si {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box .sbtn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--orange-main);
            color: #fff;
            border: none;
            padding: 0.5rem 1.1rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
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
            justify-content: space-between;
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

        /* Toolbar */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            border: 1.5px solid var(--border);
            background: #fff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            position: relative;
        }

        .filter-btn:hover {
            border-color: var(--orange-main);
        }

        .filter-panel {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            min-width: 220px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
            z-index: 300;
            display: none;
        }

        .filter-panel.open {
            display: block;
        }

        .filter-panel label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .filter-panel input[type=checkbox] {
            accent-color: var(--orange-main);
        }

        .sort-select {
            border: 1.5px solid var(--border);
            background: #fff;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: inherit;
            outline: none;
            cursor: pointer;
        }

        .sort-select:focus {
            border-color: var(--orange-main);
        }

        .result-count {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-left: auto;
        }

        /* Results */
        .results-section {
            margin-bottom: 2rem;
        }

        .results-section h3 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-secondary);
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 1rem;
        }

        .rest-result-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .rest-result-card {
            background: #fff;
            border-radius: 14px;
            padding: 1rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            cursor: pointer;
            transition: transform 0.15s;
        }

        .rest-result-card:hover {
            transform: translateX(3px);
        }

        .rest-result-img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            background: #FFF7ED;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .rest-result-img img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        .rest-result-info .rname {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .rest-result-info .rloc {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .rest-result-info .rrating {
            font-size: 0.8rem;
            color: #F97316;
            font-weight: 600;
        }

        /* Pagination */
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

        .no-results {
            text-align: center;
            padding: 3rem 0;
            color: var(--text-muted);
            font-size: 1rem;
        }
    </style>
</head>

<body>
    @include('components.customer_navbar')

    <div class="page-wrap">
        <!-- Back -->
        <a href="{{ route('home') }}" class="back-btn">
            ← Back to Home
        </a>

        @if(!empty($q))
        <!-- Toolbar: Filter + Sort -->
        <div class="toolbar">
            <div style="position:relative;">
                <button class="filter-btn" id="filterToggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 18 21 13.5M11.25 6.75h.008v.008h-.008V6.75Z" />
                    </svg>
                    Filter
                </button>
                <div class="filter-panel" id="filterPanel">
                    <form method="GET" action="{{ route('customer.search') }}">
                        <input type="hidden" name="q" value="{{ $q }}">
                        <input type="hidden" name="sort" value="{{ request('sort','popular') }}">
                        <p style="font-size:0.75rem;font-weight:700;color:var(--text-muted);margin-bottom:0.5rem;text-transform:uppercase;">Cuisine</p>
                        @foreach($cuisines as $c)
                        <label>
                            <input type="checkbox" name="cuisine[]" value="{{ $c->cuisine_id }}"
                                {{ in_array($c->cuisine_id, request()->input('cuisine',[]) ) ? 'checked' : '' }}>
                            {{ $c->cuisine_name }}
                        </label>
                        @endforeach
                        <label style="margin-top:0.5rem;">
                            <input type="checkbox" name="offers_only" value="1" {{ request('offers_only') ? 'checked' : '' }}>
                            Offers only
                        </label>
                        <button type="submit" style="margin-top:0.75rem;width:100%;background:var(--orange-main);color:white;border:none;padding:0.5rem;border-radius:8px;font-size:0.85rem;cursor:pointer;">Apply</button>
                    </form>
                </div>
            </div>

            <select class="sort-select" onchange="applySortChange(this.value)">
                <option value="popular" {{ request('sort','popular')=='popular'  ? 'selected' : '' }}>Sort: Popularity</option>
                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High → Low</option>
            </select>

            <span class="result-count">
                {{ ($items->total() + $restaurants->total()) }} result(s) for "<strong>{{ $q }}</strong>"
            </span>
        </div>

        <!-- Item Results -->
        @if($items->count())
        <div class="results-section">
            <h3>Menu Items</h3>
            <div class="items-grid">
                @foreach($items as $item)
                @include('components.menu_item_card', ['item' => $item])
                @endforeach
            </div>
            <div class="pagination">
                {{ $items->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
        @endif

        <!-- Restaurant Results -->
        @if($restaurants->count())
        <div class="results-section">
            <h3>Restaurants</h3>
            <div class="rest-result-list">
                @foreach($restaurants as $r)
                <div class="rest-result-card">
                    <div class="rest-result-img">
                        @if(!empty($r->cover_image) && str_starts_with($r->cover_image,'http'))
                        <img src="{{ $r->cover_image }}" alt="{{ $r->name }}">
                        @else
                        🍽️
                        @endif
                    </div>
                    <div class="rest-result-info flex-1">
                        <div class="rname text-lg font-bold text-gray-900 mb-0.5">{{ $r->name }}</div>
                        <div class="rloc text-sm text-gray-500 mb-2">📍 {{ $r->location }}</div>
                        <div class="rrating text-orange-500 font-bold text-sm flex items-center gap-1">
                            ★ {{ number_format($r->avg_rating ?? 0, 1) }}
                            <span class="text-gray-400 font-normal ml-1">({{ $r->total_reviews ?? 0 }} reviews)</span>
                        </div>
                    </div>
                    <div class="pl-8 border-l border-gray-100/80 ml-4 py-2">
                        <a href="{{ route('restaurant.details', $r->restaurant_id) }}" 
                           class="bg-orange-500 text-white px-12 py-4 rounded-2xl text-base font-black shadow-xl shadow-orange-100/50 hover:bg-orange-600 hover:-translate-y-0.5 transition-all uppercase tracking-widest active:scale-95 whitespace-nowrap block text-center min-w-[200px]">
                           Order Now
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="pagination">
                {{ $restaurants->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
        @endif

        @if(!$items->count() && !$restaurants->count())
        <div class="no-results">
            <p style="font-size:2rem;margin-bottom:0.5rem;">🔍</p>
            <p>No results found for "<strong>{{ $q }}</strong>".</p>
            <p style="margin-top:0.5rem;font-size:0.875rem;">Try searching for something else.</p>
        </div>
        @endif
        @endif
    </div>

    @include('components.menu_item_popup')

    <script>
        const ft = document.getElementById('filterToggle');
        const fp = document.getElementById('filterPanel');
        if (ft && fp) {
            ft.addEventListener('click', e => {
                e.stopPropagation();
                fp.classList.toggle('open');
            });
            document.addEventListener('click', e => {
                if (!fp.contains(e.target) && !ft.contains(e.target)) fp.classList.remove('open');
            });
        }

        function applySortChange(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            window.location = url.toString();
        }
    </script>
</body>

</html>