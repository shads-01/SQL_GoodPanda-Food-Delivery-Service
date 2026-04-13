<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | GoodPanda</title>
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

        /* Navbar CSS already in customer_navbar component */
        .page-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        .page-header {
            margin-bottom: 2rem;
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

        .layout-grid {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 2rem;
        }

        @media(max-width:700px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            position: sticky;
            top: 72px;
            align-self: start;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 0.85rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--orange-pale);
            color: var(--orange-main);
        }

        /* Cards */
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

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media(max-width:600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
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

        /* Edit mode fields */
        .info-field input,
        .info-field textarea {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .info-field input:focus,
        .info-field textarea:focus {
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

        /* Buttons */
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

        .btn-text-orange {
            background: none;
            border: none;
            color: var(--orange-main);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-family: inherit;
        }

        .btn-text-orange:hover {
            background: var(--orange-pale);
        }

        /* Badges */
        .badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-green {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-orange {
            background: var(--orange-pale);
            color: var(--orange-main);
        }

        /* Address cards */
        .address-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .address-card {
            display: flex;
            gap: 0.85rem;
            align-items: flex-start;
            padding: 1rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            transition: border-color 0.15s;
        }

        .address-card.default {
            border-color: var(--orange-light);
            background: var(--orange-pale);
        }

        .address-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .address-icon.orange {
            background: var(--orange-light);
        }

        .address-icon.gray {
            background: #F5F5F4;
        }

        .address-body {
            flex: 1;
        }

        .address-name {
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.2rem;
        }

        .address-line {
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .address-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.4rem;
        }

        .btn-edit {
            color: #3B82F6;
            background: none;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }

        .btn-edit:hover {
            color: #2563EB;
        }

        .btn-delete {
            color: #EF4444;
            background: none;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }

        .btn-delete:hover {
            color: #DC2626;
        }

        .btn-setdefault {
            color: var(--text-muted);
            background: none;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }

        .btn-setdefault:hover {
            color: var(--orange-main);
        }

        /* Address edit form */
        .addr-form {
            display: none;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border);
        }

        .addr-form.open {
            display: block;
        }

        .addr-form .form-group {
            margin-bottom: 0.6rem;
        }

        .addr-form label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 0.2rem;
            display: block;
        }

        .addr-form input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .addr-form input:focus {
            border-color: var(--orange-main);
        }

        .addr-form input.invalid {
            border-color: #EF4444;
        }

        .addr-form .fe {
            font-size: 0.72rem;
            color: #EF4444;
            margin-top: 0.15rem;
            display: none;
        }

        .addr-form .fe.show {
            display: block;
        }

        .addr-form-btns {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }

        /* Order cards */
        .order-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .order-card+.order-card {
            margin-top: 0.75rem;
        }

        .order-id {
            font-weight: 700;
            font-size: 0.9rem;
        }

        .order-rest {
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .order-date {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .order-status {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: inline-block;
        }

        .status-pending    { background: #FEF3C7; color: #92400E; }
        .status-confirmed  { background: #E0E7FF; color: #3730A3; }
        .status-preparing  { background: #DBEAFE; color: #1E40AF; }
        .status-ready      { background: #F3E8FF; color: #6B21A8; }
        .status-on_the_way { background: #FFF7ED; color: #9A3412; border: 1px solid #FED7AA; }
        .status-delivered  { background: #D1FAE5; color: #065F46; }
        .status-cancelled  { background: #FEE2E2; color: #991B1B; }

        .order-amount {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--orange-main);
            margin-top: 0.3rem;
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

        .btn-danger:hover {
            background: #DC2626;
        }

        /* Delete Confirm Popup */
        #deletePopupOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        #deletePopupOverlay.open {
            display: flex;
        }

        .delete-popup {
            background: #fff;
            border-radius: 18px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .delete-popup h3 {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: #DC2626;
            margin-bottom: 0.75rem;
        }

        .delete-popup p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .delete-popup-btns {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        /* Footer */
        footer {
            background: var(--text-primary);
            color: #D6D3D1;
            padding: 2.5rem 2rem 1.5rem;
            margin-top: 3rem;
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
            line-height: 1.8;
            margin-bottom: 0.4rem;
        }

        .footer-bottom {
            border-top: 1px solid #292524;
            padding-top: 1rem;
            font-size: 0.75rem;
            color: #78716C;
            margin-top: 0.75rem;
        }

        .footer-bottom a {
            color: #78716C;
            text-decoration: none;
        }
    </style>
</head>

<body>
    @include('components.customer_navbar')

    <div class="page-container">
        <div class="page-header">
            <h1>My Account</h1>
            <p>Manage your personal info, addresses, and settings.</p>
        </div>

        <div class="layout-grid">

            <!-- Sidebar -->
            <aside class="sidebar">
                <a href="#section-profile" onclick="customScrollTo(event, 'section-profile')" class="active">👤 Profile</a>
                <a href="#section-address" onclick="customScrollTo(event, 'section-address')">📍 Addresses</a>
                <a href="#section-orders" onclick="customScrollTo(event, 'section-orders')">📋 Orders</a>
                <a href="#section-danger" onclick="customScrollTo(event, 'section-danger')">⚠️ Account</a>
            </aside>

            <!-- Content -->
            <div>

                <!-- ===== PERSONAL INFO ===== -->
                <div class="card" id="section-profile">
                    <div class="card-header">
                        <span class="card-title">👤 Personal Information</span>
                        <span class="badge badge-green">✓ Active</span>
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
                                <label>Member Since</label>
                                <p>{{ isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('F Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <hr class="card-divider">
                        <button class="btn btn-ghost" onclick="toggleEditProfile(true)">✏️ Edit Information</button>
                    </div>

                    {{-- Edit Mode --}}
                    <div id="profileEdit" style="display:none;">
                        <form action="{{ route('customer.profile.update') }}" method="POST" id="profileForm">
                            @csrf
                            @method('PUT')
                            <div class="info-grid">
                                <div class="info-field">
                                    <label>Full Name</label>
                                    <input type="text" name="name" id="editName" value="{{ $user->name ?? '' }}" placeholder="Full Name">
                                    <div class="field-error" id="errName">Name must be at least 2 characters.</div>
                                </div>
                                <div class="info-field">
                                    <label>Email Address</label>
                                    <input type="email" name="email" id="editEmail" value="{{ $user->email ?? '' }}" placeholder="Email">
                                    <div class="field-error" id="errEmail">Enter a valid email address.</div>
                                </div>
                                <div class="info-field">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone_number" id="editPhone" value="{{ $user->phone_number ?? '' }}" placeholder="01XXXXXXXXX">
                                    <div class="field-error" id="errPhone">Enter a valid 11-digit Bangladeshi number (01X...).</div>
                                </div>
                            </div>
                            @if($errors->any())
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

                <!-- ===== ADDRESSES ===== -->
                <div class="card" id="section-address">
                    <div class="card-header">
                        <span class="card-title">📍 Saved Addresses</span>
                        <button class="btn-text-orange" onclick="toggleNewAddrForm()">＋ Add New</button>
                    </div>

                    {{-- Add New Form --}}
                    <div class="addr-form" id="newAddrForm">
                        <form action="{{ route('customer.address.store') }}" method="POST" id="newAddrFormEl">
                            @csrf
                            <div class="form-group">
                                <label>Label (e.g. Home, Office)</label>
                                <input type="text" name="label" id="naLabel" placeholder="Label">
                                <div class="fe" id="na-errLabel">Label is required.</div>
                            </div>
                            <div class="form-group">
                                <label>Address Line</label>
                                <input type="text" name="address_line" id="naLine" placeholder="Street address">
                                <div class="fe" id="na-errLine">Address line is required.</div>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" id="naCity" placeholder="City">
                                <div class="fe" id="na-errCity">City is required.</div>
                            </div>
                            <div class="addr-form-btns">
                                <button type="button" class="btn btn-ghost" onclick="toggleNewAddrForm()">Cancel</button>
                                <button type="button" class="btn btn-orange" onclick="submitNewAddress()">Save</button>
                            </div>
                        </form>
                    </div>

                    <div class="address-list" id="addressList">
                        @forelse($addresses as $addr)
                        <div class="address-card {{ $addr->is_default ? 'default' : '' }}" id="addr-{{ $addr->address_id }}">
                            <div class="address-icon {{ $addr->is_default ? 'orange' : 'gray' }}">
                                {{ $addr->is_default ? '🏠' : '📋' }}
                            </div>
                            <div class="address-body">
                                {{-- View --}}
                                <div class="address-name" id="addrView-{{ $addr->address_id }}">
                                    {{ $addr->label }}
                                    @if($addr->is_default)<span class="badge badge-orange">Default</span>@endif
                                </div>
                                <div class="address-line">{{ $addr->address_line }}<br>{{ $addr->city }}</div>
                                <div class="address-actions">
                                    <button class="btn-edit" onclick="openAddrEdit({{ $addr->address_id }}, '{{ addslashes($addr->label) }}', '{{ addslashes($addr->address_line) }}', '{{ addslashes($addr->city) }}', {{ $addr->is_default }})">Edit</button>
                                    @if(!$addr->is_default)
                                    <button class="btn-setdefault" onclick="setDefault({{ $addr->address_id }})">Set Default</button>
                                    @endif
                                    <button class="btn-delete" onclick="deleteAddress({{ $addr->address_id }})">Delete</button>
                                </div>

                                {{-- Edit Form --}}
                                <div class="addr-form" id="editAddrForm-{{ $addr->address_id }}">
                                    <form action="{{ route('customer.address.update', $addr->address_id) }}" method="POST" id="editAddrFormEl-{{ $addr->address_id }}">
                                        @csrf @method('PUT')
                                        <div class="form-group">
                                            <label>Label</label>
                                            <input type="text" name="label" id="ea-label-{{ $addr->address_id }}" value="{{ $addr->label }}">
                                            <div class="fe" id="ea-errLabel-{{ $addr->address_id }}">Label is required.</div>
                                        </div>
                                        <div class="form-group">
                                            <label>Address Line</label>
                                            <input type="text" name="address_line" id="ea-line-{{ $addr->address_id }}" value="{{ $addr->address_line }}">
                                            <div class="fe" id="ea-errLine-{{ $addr->address_id }}">Address line is required.</div>
                                        </div>
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" id="ea-city-{{ $addr->address_id }}" value="{{ $addr->city }}">
                                            <div class="fe" id="ea-errCity-{{ $addr->address_id }}">City is required.</div>
                                        </div>
                                        <div class="addr-form-btns">
                                            <button type="button" class="btn btn-ghost" onclick="closeAddrEdit({{ $addr->address_id }})">Cancel</button>
                                            <button type="button" class="btn btn-ghost" onclick="setDefaultInForm({{ $addr->address_id }})">Set as Default</button>
                                            <button type="button" class="btn btn-orange" onclick="submitEditAddress({{ $addr->address_id }})">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="font-size:0.9rem;color:var(--text-muted);padding:1rem 0;">No addresses saved yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- ===== ORDER HISTORY ===== -->
                <div class="card" id="section-orders">
                    <div class="card-header">
                        <span class="card-title">📋 Order History</span>
                        <a href="{{ route('customer.order_history') }}" class="btn-text-orange">Show all →</a>
                    </div>

                    @forelse($recentOrders as $order)
                    <div class="order-card">
                        <div>
                            <div class="order-id">Order #{{ $order->order_id }}</div>
                            <div class="order-rest">{{ $order->restaurant_name }}</div>
                            <div class="order-date">{{ \Carbon\Carbon::parse($order->order_datetime)->format('d M Y') }}</div>
                            @if($order->partner_name)
                                <div style="font-size: 0.75rem; color: var(--orange-main); font-weight: 600; margin-top: 4px;">🚴 Rider: {{ $order->partner_name }}</div>
                            @endif
                        </div>
                        <div style="text-align:right;">
                            <span class="order-status status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
                            <div class="order-amount">৳{{ number_format($order->total_amount,0) }}</div>
                            @if($order->order_status == 'delivered')
                                <div style="margin-top: 0.5rem;">
                                    @if(!$order->review_id)
                                        <button class="btn-text-orange" style="white-space: nowrap;" 
                                                onclick="openReviewModal({{ $order->order_id }}, {{ $order->restaurant_id }}, {{ $order->partner_id ?? 'null' }}, '{{ addslashes($order->restaurant_name) }}', '{{ addslashes($order->partner_name) }}')">
                                            ⭐ Review
                                        </button>
                                    @else
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">⭐ Reviewed</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p style="font-size:0.9rem;color:var(--text-muted);">No orders yet.</p>
                    @endforelse
                </div>

                <!-- ===== DANGER ZONE ===== -->
                <div class="danger-card" id="section-danger">
                    <div class="danger-title">⚠️ Account Deletion</div>
                    <p class="danger-warning">
                        <strong>This action is irreversible.</strong> Deleting your account will permanently deactivate it and you will not be able to sign in again with this account.
                        You may register a new account with the same email address, but all previous data will be inaccessible.
                    </p>
                    <button class="btn-danger" onclick="document.getElementById('deletePopupOverlay').classList.add('open')">
                        Delete My Account
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Delete Confirm Popup -->
    <div id="deletePopupOverlay">
        <div class="delete-popup">
            <h3>⚠️ Delete Account?</h3>
            <p>This will permanently deactivate your account. You will be logged out and cannot sign in with this account again. This <strong>cannot be undone</strong>.</p>
            <div class="delete-popup-btns">
                <button class="btn btn-ghost" onclick="document.getElementById('deletePopupOverlay').classList.remove('open')">Cancel</button>
                <form action="{{ route('customer.account.delete') }}" method="POST" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger">Yes, Delete Account</button>
                </form>
            </div>
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

    @include('components.review_modal')

    <script>
        // ---- Smooth scroll to section ----
        function scrollTo(id) {
            event.preventDefault();
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // ---- Profile Edit Toggle ----
        function toggleEditProfile(editing) {
            document.getElementById('profileView').style.display = editing ? 'none' : 'block';
            document.getElementById('profileEdit').style.display = editing ? 'block' : 'none';
        }

        function validateField(inputId, errId, regex, min) {
            const inp = document.getElementById(inputId);
            const err = document.getElementById(errId);
            let valid = true;
            if (regex && !regex.test(inp.value.trim())) valid = false;
            if (min && inp.value.trim().length < min) valid = false;
            inp.classList.toggle('invalid', !valid);
            err.classList.toggle('show', !valid);
            return valid;
        }

        function submitProfileForm() {
            const v1 = validateField('editName', 'errName', null, 2);
            const v2 = validateField('editEmail', 'errEmail', /^[^\s@]+@[^\s@]+\.[^\s@]+$/, 0);
            const v3 = validateField('editPhone', 'errPhone', /^01[0-9]{9}$/, 11);
            if (v1 && v2 && v3) document.getElementById('profileForm').submit();
        }

        // ---- New Address ----
        function toggleNewAddrForm() {
            const f = document.getElementById('newAddrForm');
            f.classList.toggle('open');
        }

        function validateAddrField(inputId, errId) {
            const inp = document.getElementById(inputId);
            const err = document.getElementById(errId);
            const valid = inp.value.trim().length > 0;
            inp.classList.toggle('invalid', !valid);
            err.classList.toggle('show', !valid);
            return valid;
        }

        function submitNewAddress() {
            const v1 = validateAddrField('naLabel', 'na-errLabel');
            const v2 = validateAddrField('naLine', 'na-errLine');
            const v3 = validateAddrField('naCity', 'na-errCity');
            if (v1 && v2 && v3) document.getElementById('newAddrFormEl').submit();
        }

        // ---- Edit Address ----
        function openAddrEdit(id, label, line, city, isDef) {
            document.getElementById('editAddrForm-' + id).classList.add('open');
        }

        function closeAddrEdit(id) {
            document.getElementById('editAddrForm-' + id).classList.remove('open');
        }

        function submitEditAddress(id) {
            const v1 = validateAddrField('ea-label-' + id, 'ea-errLabel-' + id);
            const v2 = validateAddrField('ea-line-' + id, 'ea-errLine-' + id);
            const v3 = validateAddrField('ea-city-' + id, 'ea-errCity-' + id);
            if (v1 && v2 && v3) document.getElementById('editAddrFormEl-' + id).submit();
        }

        function setDefaultInForm(id) {
            // Create hidden form and submit
            const f = document.createElement('form');
            f.method = 'POST';
            f.action = '/customer/address/' + id + '/default';
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            f.appendChild(csrf);
            document.body.appendChild(f);
            f.submit();
        }

        function setDefault(id) {
            setDefaultInForm(id);
        }

        function customScrollTo(e, id) {
            e.preventDefault();
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
                e.currentTarget.classList.add('active');
                history.pushState(null, null, '#' + id);
            }
        }

        function deleteAddress(id) {
            if (!confirm('Delete this address?')) return;
            const f = document.createElement('form');
            f.method = 'POST';
            f.action = '/customer/address/' + id;
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            f.appendChild(csrf);
            f.appendChild(method);
            document.body.appendChild(f);
            f.submit();
        }

        // Profile edit auto-open on validation errors
        @if($errors->any())
        toggleEditProfile(true);
        @endif
    </script>

</body>

</html>