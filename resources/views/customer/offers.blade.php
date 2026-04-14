<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers – GoodPanda</title>
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

        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.75rem;
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

        .filter-panel {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            min-width: 200px;
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

        /* Restaurant group */
        .rest-group {
            margin-bottom: 2.5rem;
        }

        .rest-group-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1.5px solid var(--border);
        }

        .rest-group-img {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
            background: #FFF7ED;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .rest-group-img img {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: cover;
        }

        .rest-group-name {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 1rem;
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
    </style>
</head>

<body>
    @include('components.customer_navbar')

    <div class="page-wrap">
        <a href="{{ route('home') }}" class="back-btn">← Back to Home</a>
        <h1 class="page-title">🏷️ Available Offers</h1>

        <!-- Filter Toolbar -->
        <div class="toolbar">
            <div style="position:relative;">
                <button class="filter-btn" id="filterToggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25" />
                    </svg>
                    Filter by Cuisine
                </button>
                <div class="filter-panel" id="filterPanel">
                    <form method="GET" action="{{ route('customer.offers') }}">
                        <p style="font-size:0.75rem;font-weight:700;color:var(--text-muted);margin-bottom:0.5rem;text-transform:uppercase;">Cuisine</p>
                        @foreach($cuisines as $c)
                        <label>
                            <input type="checkbox" name="cuisine[]" value="{{ $c->cuisine_id }}"
                                {{ in_array($c->cuisine_id, request()->input('cuisine',[]) ) ? 'checked' : '' }}>
                            {{ $c->cuisine_name }}
                        </label>
                        @endforeach
                        <button type="submit" style="margin-top:0.75rem;width:100%;background:var(--orange-main);color:white;border:none;padding:0.5rem;border-radius:8px;font-size:0.85rem;cursor:pointer;">Apply</button>
                    </form>
                </div>
            </div>
            <span style="font-size:0.85rem;color:var(--text-muted);">{{ $totalItems }} offer items across {{ count($groupedOffers) }} restaurants</span>
        </div>

        <!-- Grouped by Restaurant -->
        @forelse($groupedOffers as $group)
        <div class="rest-group">
            <div class="rest-group-header">
                <div class="rest-group-img">
                    @if(!empty($group['cover_image']) && str_starts_with($group['cover_image'],'http'))
                    <img src="{{ $group['cover_image'] }}" alt="">
                    @else
                    🍽️
                    @endif
                </div>
                <span class="rest-group-name">{{ $group['name'] }}</span>
            </div>
            <div class="items-grid">
                @foreach($group['items'] as $item)
                @include('components.menu_item_card', ['item' => $item])
                @endforeach
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
            <p style="font-size:2rem;margin-bottom:0.5rem;">🏷️</p>
            <p>No offers available right now.</p>
        </div>
        @endforelse

        <!-- Pagination -->
        <div class="pagination">
            {{ $paginatedItems->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>

    @include('components.menu_item_popup')

    <script>
        const ft = document.getElementById('filterToggle');
        const fp = document.getElementById('filterPanel');
        ft.addEventListener('click', e => {
            e.stopPropagation();
            fp.classList.toggle('open');
        });
        document.addEventListener('click', e => {
            if (!fp.contains(e.target) && !ft.contains(e.target)) fp.classList.remove('open');
        });
    </script>
</body>

</html>