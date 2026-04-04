<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rider Dashboard – GoodPanda</title>
  @vite('resources/css/app.css')
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- Navbar -->
  <nav class="flex items-center justify-between px-8 py-4 text-white shadow-lg" style="background: linear-gradient(135deg, #FDBA74, #FB923C);">
    <span class="text-2xl font-extrabold tracking-tight">🐼 GoodPanda</span>
    <div class="flex items-center gap-4">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="bg-white text-orange-500 px-4 py-1.5 rounded-full font-semibold shadow hover:bg-orange-50 transition">Logout</button>
      </form>
    </div>
  </nav>

  <!-- Flash -->
  @if(session('success'))
    <div id="flash-msg" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded max-w-2xl mx-auto mt-6 text-center shadow-sm">
      {{ session('success') }}
    </div>
  @endif

  <!-- Content -->
  <div class="max-w-4xl mx-auto mt-12 px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Rider Dashboard 🏍️</h1>
    <p class="text-gray-500 mb-8">You're logged in as a <span class="font-semibold text-orange-500">Delivery Partner</span>.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center opacity-60 cursor-not-allowed">
        <i data-feather="package" class="w-10 h-10 text-orange-400 mb-3"></i>
        <h2 class="font-bold text-lg text-gray-700">Active Deliveries</h2>
        <p class="text-sm text-gray-400 mt-1 text-center">Coming soon</p>
      </div>
      <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center opacity-60 cursor-not-allowed">
        <i data-feather="check-circle" class="w-10 h-10 text-orange-400 mb-3"></i>
        <h2 class="font-bold text-lg text-gray-700">Delivery History</h2>
        <p class="text-sm text-gray-400 mt-1 text-center">Coming soon</p>
      </div>
      <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center opacity-60 cursor-not-allowed">
        <i data-feather="dollar-sign" class="w-10 h-10 text-orange-400 mb-3"></i>
        <h2 class="font-bold text-lg text-gray-700">Earnings</h2>
        <p class="text-sm text-gray-400 mt-1 text-center">Coming soon</p>
      </div>
    </div>
  </div>

  <script>
    feather.replace();
    const flash = document.getElementById('flash-msg');
    if (flash) {
      setTimeout(() => { 
        flash.style.transition = 'opacity 0.5s ease-out';
        flash.style.opacity = '0'; 
      }, 4000);
      setTimeout(() => { flash.remove(); }, 4600);
    }
  </script>
</body>
</html>
