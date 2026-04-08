<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | GoodPanda Rider</title>
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

        h1, h2, h3, .font-display {
            font-family: 'Sora', sans-serif;
        }

        .page-container {
            max-width: 800px; /* Centered, single column */
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .rider-rating {
            background: #FFFAF0;
            border: 1.5px solid #FDE68A;
            color: #B45309;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
        }

        .card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1rem;
        }

        .card-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.25rem 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media(max-width:600px) {
            .info-grid { grid-template-columns: 1fr; }
        }

        .info-field label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 0.25rem;
        }

        .info-field p {
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .info-field input, .info-field select {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
        }

        .info-field input:focus, .info-field select:focus {
            border-color: var(--orange-main);
        }

        .info-field input.invalid {
            border-color: #EF4444;
        }

        .field-error {
            font-size: 0.75rem;
            color: #EF4444;
            margin-top: 0.2rem;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }

        .btn-ghost {
            background: none;
            border: 1.5px solid var(--border);
            color: var(--text-primary);
        }

        .btn-ghost:hover {
            border-color: var(--orange-main);
            color: var(--orange-main);
        }

        .btn-orange {
            background: var(--orange-main);
            color: #fff;
        }

        .btn-orange:hover {
            background: #EA580C;
        }

        .badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .badge-green { background: #D1FAE5; color: #065F46; }
        .badge-orange { background: var(--orange-pale); color: var(--orange-main); }
        .badge-red { background: #FEE2E2; color: #991B1B; }

        /* Order cards */
        .order-card {
            background: #fdfdfd;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .order-card + .order-card {
            margin-top: 0.75rem;
        }

        .order-id { font-weight: 700; font-size: 0.9rem; }
        .order-rest { font-size: 0.82rem; color: var(--text-secondary); }
        .order-date { font-size: 0.78rem; color: var(--text-muted); }

        .order-status {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
        }
        .status-delivered { background: #D1FAE5; color: #065F46; }
        .status-assigned, .status-picked_up, .status-on_the_way { background: #FEF3C7; color: #92400E; }
        .status-failed { background: #FEE2E2; color: #991B1B; }

        .order-amount {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--orange-main);
            margin-top: 0.3rem;
            text-align: right;
        }

        /* Danger zone */
        .danger-card {
            border: 2px solid #FCA5A5;
            background: #FFF5F5;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .danger-title {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: #DC2626;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .danger-warning {
            font-size: 0.82rem;
            color: #78716C;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .btn-danger {
            background: #EF4444;
            color: #fff;
            border: none;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s;
        }
        .btn-danger:hover { background: #DC2626; }

        #deletePopupOverlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center; justify-content: center;
        }
        #deletePopupOverlay.open { display: flex; }
        .delete-popup {
            background: #fff; border-radius: 18px; padding: 2rem; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        .delete-popup h3 { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.1rem; color: #DC2626; margin-bottom: 0.75rem; }
        .delete-popup p { font-size: 0.875rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 1.5rem; }
        .delete-popup-btns { display: flex; gap: 0.75rem; justify-content: center; }
    </style>
</head>

<body>
    @include('components.rider_navbar')

    <div class="page-container">
        <div class="page-header">
            <div>
                <h1>Rider Profile</h1>
                <p>Manage your account, vehicle, and deliveries.</p>
            </div>
            <div class="rider-rating">
                ⭐ {{ number_format($user->avg_rating, 1) }} Rating
            </div>
        </div>

        <!-- ===== PERSONAL INFO ===== -->
        <div class="card" id="section-profile">
            <div class="card-header">
                <span class="card-title">👤 Personal Information</span>
                @if($user->is_available)
                    <span class="badge badge-green">✓ Available</span>
                @else
                    <span class="badge badge-red">Off-Duty</span>
                @endif
            </div>

            {{-- View Mode --}}
            <div id="profileView">
                <div class="info-grid">
                    <div class="info-field">
                        <label>Full Name</label>
                        <p>{{ $user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="info-field">
                        <label>Email Address</label>
                        <p>{{ $user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="info-field">
                        <label>Phone Number</label>
                        <p>{{ $user->phone_number ?? 'N/A' }}</p>
                    </div>
                    <div class="info-field">
                        <label>Rider Since</label>
                        <p>{{ isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('F Y') : 'N/A' }}</p>
                    </div>
                </div>
                <hr class="card-divider">
                <button class="btn btn-ghost" onclick="toggleEditProfile(true)">✏️ Edit Information</button>
            </div>

            {{-- Edit Mode --}}
            <div id="profileEdit" style="display:none;">
                <form action="{{ route('rider.profile.update') }}" method="POST" id="profileForm">
                    @csrf @method('PUT')
                    <div class="info-grid">
                        <div class="info-field">
                            <label>Full Name</label>
                            <input type="text" name="name" id="editName" value="{{ $user->name ?? '' }}">
                            <div class="field-error" id="errName">Name must be at least 2 characters.</div>
                        </div>
                        <div class="info-field">
                            <label>Email Address</label>
                            <input type="email" name="email" id="editEmail" value="{{ $user->email ?? '' }}">
                            <div class="field-error" id="errEmail">Enter a valid email address.</div>
                        </div>
                        <div class="info-field">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" id="editPhone" value="{{ $user->phone_number ?? '' }}">
                            <div class="field-error" id="errPhone">Enter a valid 11-digit number.</div>
                        </div>
                    </div>
                    @if($errors->any() && !session('vehicle_error'))
                    <div style="background:#FEE2E2;border:1px solid #FCA5A5;color:#991B1B;padding:0.6rem 1rem;border-radius:8px;font-size:0.82rem;margin-top:0.75rem;">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                    @endif
                    <hr class="card-divider">
                    <div style="display:flex;gap:0.5rem;">
                        <button type="button" class="btn btn-ghost" onclick="toggleEditProfile(false)">Cancel</button>
                        <button type="button" class="btn btn-orange" onclick="submitProfileForm()">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== VEHICLE DETAILS ===== -->
        <div class="card" id="section-vehicle">
            <div class="card-header">
                <span class="card-title">🛵 Vehicle & Status</span>
            </div>

            {{-- View Mode --}}
            <div id="vehicleView">
                <div class="info-grid">
                    <div class="info-field">
                        <label>Vehicle Type</label>
                        <p style="text-transform: capitalize;">{{ $user->vehicle_type ?? 'N/A' }}</p>
                    </div>
                    <div class="info-field">
                        <label>Current Status</label>
                        <p>{{ $user->is_available ? 'Available for Orders' : 'Off-Duty' }}</p>
                    </div>
                </div>
                <hr class="card-divider">
                <button class="btn btn-ghost" onclick="toggleEditVehicle(true)">✏️ Update Ride Details</button>
            </div>

            {{-- Edit Mode --}}
            <div id="vehicleEdit" style="display:none;">
                <form action="{{ route('rider.vehicle.update') }}" method="POST" id="vehicleForm">
                    @csrf @method('PUT')
                    <div class="info-grid">
                        <div class="info-field">
                            <label>Vehicle Type</label>
                            <select name="vehicle_type" id="editVehicleType">
                                <option value="bike" {{ $user->vehicle_type == 'bike' ? 'selected' : '' }}>Bike</option>
                                <option value="scooter" {{ $user->vehicle_type == 'scooter' ? 'selected' : '' }}>Scooter</option>
                                <option value="bicycle" {{ $user->vehicle_type == 'bicycle' ? 'selected' : '' }}>Bicycle</option>
                                <option value="car" {{ $user->vehicle_type == 'car' ? 'selected' : '' }}>Car</option>
                            </select>
                        </div>
                        <div class="info-field">
                            <label>Current Status</label>
                            <select name="is_available" id="editStatus">
                                <option value="1" {{ $user->is_available == 1 ? 'selected' : '' }}>Available for Orders</option>
                                <option value="0" {{ $user->is_available == 0 ? 'selected' : '' }}>Off-Duty</option>
                            </select>
                        </div>
                    </div>
                    @if($errors->any() && session('vehicle_error'))
                    <div style="background:#FEE2E2;border:1px solid #FCA5A5;color:#991B1B;padding:0.6rem 1rem;border-radius:8px;font-size:0.82rem;margin-top:0.75rem;">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                    @endif
                    <hr class="card-divider">
                    <div style="display:flex;gap:0.5rem;">
                        <button type="button" class="btn btn-ghost" onclick="toggleEditVehicle(false)">Cancel</button>
                        <button type="submit" class="btn btn-orange">Save Ride Details</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ===== DELIVERY HISTORY ===== -->
        <div class="card" id="section-orders">
            <div class="card-header" style="margin-bottom:0.75rem;">
                <span class="card-title">📋 Delivery History</span>
            </div>
            
            @forelse($deliveries as $del)
                <div class="order-card">
                    <div>
                        <div class="order-id">Delivery #{{ $del->delivery_id }} (Order #{{ $del->order_id }})</div>
                        <div class="order-rest">Restaurant: {{ $del->restaurant_name }}</div>
                        <div class="order-rest" style="margin-top:2px;">To: {{ $del->address_line }}, {{ $del->city }}</div>
                        <div class="order-date" style="margin-top:6px;">
                            @if($del->delivered_time) Delivered: {{ \Carbon\Carbon::parse($del->delivered_time)->format('M d, h:i A') }}
                            @elseif($del->pickup_time) Picked up: {{ \Carbon\Carbon::parse($del->pickup_time)->format('M d, h:i A') }}
                            @else Pending pickup...
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="order-status status-{{ $del->delivery_status }}" style="text-align:right;">{{ str_replace('_', ' ', ucfirst($del->delivery_status)) }}</div>
                        <div class="order-amount">৳{{ number_format($del->total_amount, 0) }}</div>
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:0.9rem;">
                    No past deliveries to show.
                </div>
            @endforelse

            <div style="margin-top: 1rem; display:flex; justify-content:center; gap:0.5rem;">
                {{ $deliveries->links('vendor.pagination.custom') }}
            </div>
        </div>

        <!-- ===== DANGER ZONE ===== -->
        <div class="danger-card" id="section-danger">
            <div class="danger-title">⚠️ Danger Zone</div>
            <div class="danger-warning">
                Permanently delete your Rider account. This will remove your access to the GoodPanda platform. Your historical delivery records will be preserved anonymously for logging. This action cannot be undone.
            </div>
            <button class="btn-danger" onclick="openDeletePopup()">Delete Account</button>
        </div>

    </div>

    <!-- Delete Confirmation Popup -->
    <div id="deletePopupOverlay">
        <div class="delete-popup">
            <h3>Delete Account?</h3>
            <p>Are you absolutely sure you want to permanently close your GoodPanda rider account? You will lose access immediately.</p>
            <div class="delete-popup-btns">
                <button class="btn btn-ghost" onclick="closeDeletePopup()">Cancel</button>
                <form action="{{ route('rider.account.delete') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Profile Edit
        function toggleEditProfile(show) {
            document.getElementById('profileView').style.display = show ? 'none' : 'block';
            document.getElementById('profileEdit').style.display = show ? 'block' : 'none';
        }
        function submitProfileForm() {
            let valid = true;
            const nm = document.getElementById('editName');
            const em = document.getElementById('editEmail');
            const ph = document.getElementById('editPhone');

            if (nm.value.trim().length < 2) { nm.classList.add('invalid'); document.getElementById('errName').classList.add('show'); valid = false; }
            else { nm.classList.remove('invalid'); document.getElementById('errName').classList.remove('show'); }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(em.value.trim())) { em.classList.add('invalid'); document.getElementById('errEmail').classList.add('show'); valid = false; }
            else { em.classList.remove('invalid'); document.getElementById('errEmail').classList.remove('show'); }

            const phoneRegex = /^01[0-9]{9}$/;
            if (!phoneRegex.test(ph.value.trim())) { ph.classList.add('invalid'); document.getElementById('errPhone').classList.add('show'); valid = false; }
            else { ph.classList.remove('invalid'); document.getElementById('errPhone').classList.remove('show'); }

            if (valid) document.getElementById('profileForm').submit();
        }

        // Vehicle Edit
        function toggleEditVehicle(show) {
            document.getElementById('vehicleView').style.display = show ? 'none' : 'block';
            document.getElementById('vehicleEdit').style.display = show ? 'block' : 'none';
        }

        // Popup logic
        function openDeletePopup() { document.getElementById('deletePopupOverlay').classList.add('open'); }
        function closeDeletePopup() { document.getElementById('deletePopupOverlay').classList.remove('open'); }
    </script>
</body>
</html>
