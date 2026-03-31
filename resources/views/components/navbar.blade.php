<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-logo">
        <span>🐼</span> GoodPanda
    </a>

    <ul class="navbar-links">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#">Restaurants</a></li>
        <li><a href="#">Orders</a></li>
        <li><a href="#">Help</a></li>
    </ul>

    <div style="position:relative; z-index:50;">
        @if(Session::has('user_id'))
            <button class="profile-btn" id="profileBtn">
                <i data-feather="user"></i>
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ route('customer_profile') }}">My Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="danger" style="width:100%; text-align:left; background:none; border:none; padding:0.75rem 1rem; font-size:0.875rem; font-weight:500; font-family:inherit; cursor:pointer;">Logout</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" style="background:#F97316; color:white; padding:0.5rem 1rem; border-radius:999px; text-decoration:none; font-size:0.875rem; font-weight:600;">Login</a>
        @endif
    </div>
</nav>

@if(session('success'))
<div style="background-color: #D1FAE5; border: 1px solid #34D399; color: #065F46; padding: 0.75rem 1rem; border-radius: 0.375rem; max-width: 40rem; margin: 1rem auto; text-align: center; font-weight: 500;">
    {{ session('success') }}
</div>
@endif