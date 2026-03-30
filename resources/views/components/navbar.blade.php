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

    <div style="position:relative">
        <button class="profile-btn" id="profileBtn">
            <i data-feather="user"></i>
        </button>
        <div class="profile-dropdown" id="profileDropdown">
            <a href="{{ route('customer_profile') }}">My Profile</a>
            <a href="#" class="danger">Logout</a>
        </div>
    </div>
</nav>