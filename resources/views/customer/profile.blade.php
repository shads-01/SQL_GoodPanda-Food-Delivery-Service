<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Account | GoodPanda</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

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
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Sora', sans-serif;
        }

        /* ---- NAVBAR ---- */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-logo {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--orange-main);
            text-decoration: none;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .navbar-logo span {
            display: inline-block;
            font-size: 1.3rem;
        }

        .navbar-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .navbar-links a {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .navbar-links a:hover {
            color: var(--text-primary);
        }

        .profile-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--orange-pale);
            border: 1.5px solid var(--orange-light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s;
            position: relative;
        }

        .profile-btn:hover {
            background: var(--orange-light);
            transform: scale(1.05);
        }

        .profile-btn svg {
            color: var(--orange-main);
            width: 16px;
            height: 16px;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            width: 180px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: none;
        }

        .profile-dropdown.open {
            display: block;
        }

        .profile-dropdown a {
            display: block;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            transition: background 0.1s;
        }

        .profile-dropdown a:not(:last-child) {
            border-bottom: 1px solid var(--border);
        }

        .profile-dropdown a:hover {
            background: var(--bg);
        }

        .profile-dropdown a.danger:hover {
            color: #DC2626;
            background: #FFF5F5;
        }

        /* ---- LAYOUT ---- */
        .page-container {
            max-width: 960px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.625rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text-primary);
        }

        .page-header p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        /* ---- SIDEBAR ---- */
        .sidebar {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 0.5rem;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 0.875rem;
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s;
        }

        .sidebar a svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        .sidebar a:hover {
            background: var(--bg);
            color: var(--text-primary);
        }

        .sidebar a.active {
            background: var(--orange-pale);
            color: var(--orange-main);
            font-weight: 600;
        }

        /* ---- CARDS ---- */
        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.75rem;
        }

        .card+.card {
            margin-top: 1rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .card-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.01em;
        }

        .card-title svg {
            width: 15px;
            height: 15px;
            color: var(--text-muted);
        }

        /* ---- INFO GRID ---- */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .info-field label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            display: block;
            margin-bottom: 0.25rem;
        }

        .info-field p {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .info-field p svg {
            width: 13px;
            height: 13px;
            color: #3B82F6;
        }

        .card-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.25rem 0;
        }

        /* ---- BADGES ---- */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.625rem;
            border-radius: 999px;
        }

        .badge svg {
            width: 10px;
            height: 10px;
        }

        .badge-green {
            background: #D1FAE5;
            color: #059669;
        }

        .badge-orange {
            background: var(--orange-pale);
            color: var(--orange-main);
        }

        /* ---- BUTTONS ---- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn svg {
            width: 13px;
            height: 13px;
        }

        .btn-ghost {
            background: var(--bg);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            background: var(--border);
            color: var(--text-primary);
        }

        .btn-orange {
            background: var(--orange-main);
            color: white;
        }

        .btn-orange:hover {
            background: #EA6C0A;
        }

        .btn-text-orange {
            background: none;
            color: var(--orange-main);
            padding: 0;
            font-size: 0.8125rem;
        }

        .btn-text-orange:hover {
            color: #EA6C0A;
        }

        /* ---- AVATAR SECTION ---- */
        .avatar-section {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .avatar-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--orange-pale);
            border: 2px solid var(--orange-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar-circle svg {
            color: #FDBA74;
            width: 24px;
            height: 24px;
        }

        .avatar-inputs {
            flex: 1;
        }

        .avatar-inputs label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .file-input-wrapper input[type="file"] {
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        .file-input-wrapper input[type="file"]::file-selector-button {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            margin-right: 0.75rem;
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
        }

        .file-input-wrapper input[type="file"]::file-selector-button:hover {
            background: var(--border);
            color: var(--text-primary);
        }

        /* ---- ADDRESS CARDS ---- */
        .address-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .address-card {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            padding: 1rem 1.125rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: all 0.15s;
            position: relative;
        }

        .address-card:hover {
            border-color: var(--orange-light);
            box-shadow: 0 2px 12px rgba(249, 115, 22, 0.06);
        }

        .address-card.default {
            border-color: #FED7AA;
            background: #FFFBF7;
        }

        .address-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .address-icon.orange {
            background: var(--orange-pale);
            color: var(--orange-main);
        }

        .address-icon.gray {
            background: var(--bg);
            color: var(--text-muted);
        }

        .address-icon svg {
            width: 15px;
            height: 15px;
        }

        .address-body {
            flex: 1;
        }

        .address-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.2rem;
        }

        .address-line {
            font-size: 0.8125rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .address-actions {
            margin-top: 0.6rem;
            display: flex;
            gap: 0.875rem;
        }

        .address-actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0;
            transition: color 0.15s;
        }

        .btn-edit {
            color: #3B82F6;
        }

        .btn-edit:hover {
            color: #2563EB;
        }

        .btn-delete {
            color: #EF4444;
        }

        .btn-delete:hover {
            color: #DC2626;
        }

        .btn-setdefault {
            color: var(--text-muted);
        }

        .btn-setdefault:hover {
            color: var(--orange-main);
        }

        /* ---- FOOTER ---- */
        footer {
            background: var(--text-primary);
            color: #D6D3D1;
            padding: 2.5rem 2rem 1.5rem;
            margin-top: 3rem;
        }

        .footer-inner {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-logo {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
            margin-bottom: 0.5rem;
        }

        .footer-logo span {
            color: var(--orange-main);
        }

        .footer-tagline {
            font-size: 0.8rem;
            color: #A8A29E;
            margin-bottom: 1.25rem;
        }

        .footer-contact {
            font-size: 0.8rem;
            line-height: 1.8;
            color: #A8A29E;
            margin-bottom: 1.5rem;
        }

        .footer-bottom {
            border-top: 1px solid #292524;
            padding-top: 1.25rem;
            font-size: 0.75rem;
            color: #78716C;
            width: 100%;
            text-align: center;
        }

        .footer-bottom a {
            color: #78716C;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: var(--text-muted);
        }

        @media (max-width: 700px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .avatar-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .sidebar {
                position: static;
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    @include('components.navbar')

    <!-- Page -->
    <div class="page-container">

        <div class="page-header">
            <h1>My Account</h1>
            <p>Manage your personal info, addresses, and settings.</p>
        </div>

        <div class="layout-grid">

            <!-- Sidebar -->
            <aside class="sidebar">
                <a href="#" class="active">
                    <i data-feather="user"></i> Profile
                </a>
                <a href="#">
                    <i data-feather="map-pin"></i> Addresses
                </a>
                <a href="#">
                    <i data-feather="shopping-bag"></i> Orders
                </a>
                <a href="#">
                    <i data-feather="settings"></i> Settings
                </a>
            </aside>

            <!-- Content -->
            <div>

                <!-- Personal Info -->
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i data-feather="user"></i> Personal Information
                        </span>
                        <span class="badge badge-green">
                            <i data-feather="check-circle"></i> Active
                        </span>
                    </div>

                    <div class="info-grid">
                        <div class="info-field">
                            <label>Full Name</label>
                            <p>John Doe</p>
                        </div>
                        <div class="info-field">
                            <label>Email Address</label>
                            <p>
                                johndoe@example.com
                                <i data-feather="check-circle" style="color:#3B82F6;width:13px;height:13px"></i>
                            </p>
                        </div>
                        <div class="info-field">
                            <label>Phone Number</label>
                            <p>+880 1711 223344</p>
                        </div>
                        <div class="info-field">
                            <label>Member Since</label>
                            <p>March 2026</p>
                        </div>
                    </div>

                    <hr class="card-divider">

                    <button class="btn btn-ghost">
                        <i data-feather="edit-2"></i> Edit Information
                    </button>
                </div>

                <!-- Profile Picture -->
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i data-feather="camera"></i> Profile Picture
                        </span>
                    </div>

                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="avatar-section">
                            <div class="avatar-circle">
                                <i data-feather="user"></i>
                            </div>
                            <div class="avatar-inputs" style="flex:1">
                                <label>Choose an image</label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="avatar" accept="image/*" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-orange" style="flex-shrink:0">
                                <i data-feather="upload-cloud"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Saved Addresses -->
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i data-feather="map-pin"></i> Saved Addresses
                        </span>
                        <button class="btn btn-text-orange">
                            <i data-feather="plus" style="width:13px;height:13px"></i> Add New
                        </button>
                    </div>

                    <div class="address-list">
                        <!-- Default -->
                        <div class="address-card default">
                            <div class="address-icon orange">
                                <i data-feather="home"></i>
                            </div>
                            <div class="address-body">
                                <div class="address-name">
                                    Home
                                    <span class="badge badge-orange">Default</span>
                                </div>
                                <div class="address-line">
                                    Apt 4B, 123 Panda Delivery Ave.<br>Dhaka City
                                </div>
                                <div class="address-actions">
                                    <button class="btn-edit">Edit</button>
                                    <button class="btn-delete">Delete</button>
                                </div>
                            </div>
                        </div>

                        <!-- Office -->
                        <div class="address-card">
                            <div class="address-icon gray">
                                <i data-feather="briefcase"></i>
                            </div>
                            <div class="address-body">
                                <div class="address-name">Office</div>
                                <div class="address-line">
                                    Floor 9, Tech Tower Road<br>Dhaka City
                                </div>
                                <div class="address-actions">
                                    <button class="btn-edit">Edit</button>
                                    <button class="btn-setdefault">Set Default</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-inner">
            <div class="footer-logo">Good<span>Panda</span> 🐼</div>
            <p class="footer-tagline">Fast delivery, great restaurants, happy you.</p>
            <div class="footer-contact">
                support@goodpanda.com &nbsp;·&nbsp; +880 1234 567890
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} GoodPanda. All rights reserved.
                &nbsp;·&nbsp; <a href="#">Privacy</a>
                &nbsp;·&nbsp; <a href="#">Terms</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace();

            const btn = document.getElementById('profileBtn');
            const dropdown = document.getElementById('profileDropdown');

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('open');
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });
    </script>

</body>

</html>