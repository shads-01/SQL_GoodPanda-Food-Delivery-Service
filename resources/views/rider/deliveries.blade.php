<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery History | GoodPanda Rider</title>
  @vite('resources/css/app.css')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
      body { font-family: 'DM Sans', sans-serif; background: #FAFAF9; color: #1C1917; }
      h1, h2, h3, .font-display { font-family: 'Sora', sans-serif; }
      .table-card { background: #fff; border: 1px solid #E7E5E4; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
      .avail-table { width: 100%; border-collapse: collapse; text-align: left; }
      .avail-table th { padding: 1rem; border-bottom: 1px solid #E7E5E4; font-size: 0.82rem; font-weight: 700; color: #78716C; text-transform: uppercase; letter-spacing: 0.05em; background: #FAFAF9; }
      .avail-table td { padding: 1rem; border-bottom: 1px solid #E7E5E4; font-size: 0.9rem; vertical-align: middle; }
      .avail-table tr:hover { background: #FFF7ED; }
      .btn-back { display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #F97316; font-weight: 600; margin-bottom: 1.5rem; transition: color 0.15s; }
      .btn-back:hover { color: #EA580C; }
      .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
      .status-delivered { background: #D1FAE5; color: #065F46; }
      .status-failed { background: #FEE2E2; color: #991B1B; }
      .status-assigned, .status-picked_up, .status-on_the_way { background: #FEF3C7; color: #92400E; }
  </style>
</head>
<body>

  @include('components.rider_navbar')

  <div class="max-w-6xl mx-auto px-6 py-8">
    <a href="{{ route('rider.dashboard') }}" class="btn-back">← Back to Dashboard</a>
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold font-display">Lifetime Delivery History 📋</h1>
        <p class="text-gray-500 mt-1">A complete record of all your assigned and completed deliveries.</p>
    </div>

    <div class="table-card mb-6">
        @if(count($deliveries) > 0)
            <table class="avail-table">
                <thead>
                    <tr>
                        <th>Delivery Ref</th>
                        <th>Restaurant (Pick-up)</th>
                        <th>Customer (Drop-off)</th>
                        <th>Timestamps</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveries as $del)
                        <tr>
                            <td>
                                <div class="font-bold">#{{ $del->delivery_id }}</div>
                                <div class="text-xs text-gray-500">Order #{{ $del->order_id }}</div>
                            </td>
                            <td>
                                <div class="font-bold">{{ $del->restaurant_name }}</div>
                            </td>
                            <td>
                                <div class="text-sm font-medium">{{ $del->address_line }}</div>
                                <div class="text-xs text-gray-500">{{ $del->city }}</div>
                            </td>
                            <td class="text-xs text-gray-600">
                                <div><span class="font-semibold">Picked up:</span> {{ $del->pickup_time ? \Carbon\Carbon::parse($del->pickup_time)->format('M d, Y h:i A') : 'Pending' }}</div>
                                <div><span class="font-semibold">Delivered:</span> {{ $del->delivered_time ? \Carbon\Carbon::parse($del->delivered_time)->format('M d, Y h:i A') : 'Pending' }}</div>
                            </td>
                            <td>
                                <span class="badge-status status-{{ $del->delivery_status }}">
                                    {{ str_replace('_', ' ', strtoupper($del->delivery_status)) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="py-12 text-center text-gray-500">
                <span class="text-3xl mb-3 block">📭</span>
                Your delivery history is completely empty.
            </div>
        @endif
    </div>

    <div class="flex justify-center">
        {{ $deliveries->links('vendor.pagination.custom') }}
    </div>

  </div>

</body>
</html>
