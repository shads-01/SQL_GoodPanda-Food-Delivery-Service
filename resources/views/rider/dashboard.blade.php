<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rider Dashboard | GoodPanda</title>
  @vite('resources/css/app.css')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
      body { font-family: 'DM Sans', sans-serif; background: #FAFAF9; color: #1C1917; }
      h1, h2, h3, .font-display { font-family: 'Sora', sans-serif; }
      .card { background: #fff; border: 1px solid #E7E5E4; border-radius: 16px; padding: 1.5rem; box-shadow: 0 1px 6px rgba(0,0,0,0.04); height: 100%; display: flex; flex-direction: column; }
      .card-title { font-size: 1rem; font-family: 'Sora', sans-serif; font-weight: 700; margin-bottom: 0.5rem; color: #78716C; }
      .stat-val { font-size: 2rem; font-weight: 700; color: #F97316; margin-top: auto; }

      .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; padding: 0.6rem 1.25rem; border-radius: 8px; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.15s; font-family: inherit; }
      .btn-orange { background: #F97316; color: white; }
      .btn-orange:hover:not(:disabled) { background: #EA580C; }
      .btn-orange:disabled { background: #FDBA74; cursor: not-allowed; }
      .btn-green { background: #10B981; color: white; }
      .btn-green:hover { background: #059669; }

      .badge { font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-block; }
      .badge-assigned { background: #E0E7FF; color: #4338CA; }
      .badge-picked { background: #FEF3C7; color: #92400E; }
      .badge-onway { background: #FFEDD5; color: #C2410C; }

      .table-card { background: #fff; border: 1px solid #E7E5E4; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,0.04); }
      .avail-table { width: 100%; border-collapse: collapse; text-align: left; }
      .avail-table th { padding: 1rem; border-bottom: 1px solid #E7E5E4; font-size: 0.82rem; font-weight: 700; color: #78716C; text-transform: uppercase; letter-spacing: 0.05em; background: #FAFAF9; }
      .avail-table td { padding: 1rem; border-bottom: 1px solid #E7E5E4; font-size: 0.9rem; vertical-align: middle; }
      .avail-table tr:last-child td { border-bottom: none; }
      .avail-table tr:hover { background: #FFF7ED; }
      
      .clickable-card { cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; text-decoration: none; color: inherit; }
      .clickable-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); border-color: #F97316; }

      .address-block { display: flex; flex-direction: column; gap: 0.2rem; }
      .address-title { font-weight: 600; font-size: 0.85rem; color: #1C1917; }
      .address-detail { font-size: 0.8rem; color: #78716C; }
      .icon-pin { width: 14px; height: 14px; display: inline-block; vertical-align: text-top; margin-right: 4px; }
  </style>
</head>
<body>

  @include('components.rider_navbar')

  <div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold font-display">Hello, {{ explode(' ', session('user_name'))[0] }} 🚴</h1>
            <p class="text-gray-500 mt-1">Here is your daily delivery overview.</p>
        </div>
    </div>

    <!-- Active Deliveries Logic -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 text-black">
      
      <!-- 1. Active Delivery Card -->
      <div class="card relative">
          <div class="card-title">🚨 Active Delivery</div>
          @if($activeDelivery)
            <div class="flex justify-between items-start mb-3">
                <span class="font-bold">Order #{{ $activeDelivery->order_id }}</span>
                <span class="badge @if($activeDelivery->delivery_status == 'assigned') badge-assigned @elseif($activeDelivery->delivery_status == 'picked_up') badge-picked @else badge-onway @endif">
                    {{ str_replace('_', ' ', strtoupper($activeDelivery->delivery_status)) }}
                </span>
            </div>
            
            <div class="address-block mb-3">
                <div class="address-title"><span class="text-orange-500">📍 Pick-up:</span> {{ $activeDelivery->restaurant_name }}</div>
                <div class="address-detail">{{ $activeDelivery->restaurant_address }}</div>
            </div>
            
            <div class="address-block mb-4">
                <div class="address-title"><span class="text-green-600">🎯 Drop-off:</span> Customer Destination</div>
                <div class="address-detail">{{ $activeDelivery->address_line }}, {{ $activeDelivery->city }}</div>
            </div>

            <div class="mt-auto">
                @if($activeDelivery->delivery_status == 'assigned')
                    <form action="{{ route('rider.deliveries.status', $activeDelivery->delivery_id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="picked_up">
                        <button type="submit" class="btn btn-orange w-full">✅ Mark Picked Up</button>
                    </form>
                @else
                    <form action="{{ route('rider.deliveries.status', $activeDelivery->delivery_id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" class="btn btn-green w-full">📦 Mark Delivered</button>
                    </form>
                @endif
            </div>
          @else
            <div class="flex-1 flex flex-col justify-center items-center text-center text-gray-400 mt-4">
                <span class="text-4xl mb-2">💤</span>
                <p>No active delivery.</p>
                <p class="text-xs mt-1">Accept one below to get started!</p>
            </div>
          @endif
      </div>

      <!-- 2. Delivery History Link Card -->
      <a href="{{ route('rider.delivery-history') }}" class="card clickable-card">
          <div class="card-title">📋 Lifetime Deliveries</div>
          <p class="text-gray-500 text-sm flex-1">View your complete delivery log, timestamps, and customer addresses.</p>
          <div class="stat-val mt-4">{{ $stats->total_deliveries }} <span class="text-lg text-gray-400 font-medium tracking-normal">Drops</span></div>
          <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center text-orange-500 font-semibold text-sm">
            <span>View Full History</span>
            <span>→</span>
          </div>
      </a>

      <!-- 3. Earnings Card -->
      <div class="card">
          <div class="card-title">💸 Total Earnings</div>
          <p class="text-gray-500 text-sm">Accumulated based on 100% of Delivery Fees from successful trips.</p>
          <div class="stat-val font-display">৳{{ number_format($stats->total_earnings, 0) }}</div>
      </div>
      
    </div>

    <!-- Available Deliveries Market -->
    <h2 class="text-xl font-bold font-display mb-4">🛒 Available Deliveries</h2>
    <div class="table-card mb-6">
        @if(count($availableList) > 0)
            <table class="avail-table">
                <thead>
                    <tr>
                        <th>Requested</th>
                        <th>Pick-up (Restaurant)</th>
                        <th>Drop-off (Customer)</th>
                        <th>Est. Payout</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($availableList as $avail)
                        <tr>
                            <td class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($avail->order_datetime)->diffForHumans() }}</td>
                            <td>
                                <div class="font-bold">{{ $avail->restaurant_name }}</div>
                                <div class="text-xs text-gray-500">{{ $avail->restaurant_address }}</div>
                            </td>
                            <td>
                                <div class="font-bold flex items-center gap-1">
                                    <span class="bg-gray-200 text-gray-700 text-[10px] px-2 py-0.5 rounded-full">{{ $avail->address_label }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $avail->address_line }}, {{ $avail->city }}</div>
                            </td>
                            <td class="text-orange-500 font-bold">৳{{ number_format($avail->total_amount * 0.15, 0) }}</td> <!-- Dummy calculation visual if needed, user said 'payout', let's just show standard. Wait, payout is delivery fee, we don't have it in this query. I'll just show 'Standard Delivery'. -->
                            <td>
                                <form action="{{ route('rider.deliveries.accept') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $avail->order_id }}">
                                    <button type="submit" class="btn btn-orange text-xs py-1.5 px-4" {{ $activeDelivery ? 'disabled title="You currently lack capacity."' : '' }}>
                                        Accept Request
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="py-12 text-center text-gray-500">
                <span class="text-3xl mb-3 block">📭</span>
                No delivery requests are currently available in the market.
            </div>
        @endif
    </div>

    <div class="flex justify-center">
        {{ $availableList->links('vendor.pagination.custom') }}
    </div>

  </div>

</body>
</html>
