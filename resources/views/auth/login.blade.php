<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  @vite('resources/css/app.css')
  <style>
    /* Slow bounce animation for panda */
    @keyframes bounce-slow {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-15px);
      }
    }

    .animate-bounce-slow {
      animation: bounce-slow 4.5s ease-in-out infinite;
    }
  </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- FULL SCREEN FLEX -->
  <div class="flex flex-col md:flex-row w-full h-full min-h-screen">

    <!-- LEFT SIDE -->
    <div class="md:w-1/2 flex flex-col items-center justify-center p-10 text-center fade-in-left"
      style="background: linear-gradient(135deg, #FDBA74, #FB923C);">

      <!-- Heading -->
      <h2 class="text-5xl md:text-6xl font-extrabold text-white mb-16">
        GoodPanda
      </h2>

      <!-- Circle with panda image fully visible + bounce animation -->
      <div class="w-64 h-64 rounded-full bg-white flex items-center justify-center mb-6 shadow-xl overflow-hidden animate-bounce-slow">
        <img src="https://images.fineartamerica.com/images/artworkimages/mediumlarge/3/kawaii-cute-anime-panda-otaku-japanese-ramen-noodles-finnly-maria.jpg"
          class="w-full h-full object-cover" alt="Panda">
      </div>

      <!-- Subheading and text -->
      <h3 class="text-xl font-semibold text-white mb-2">
        Your favorite meals, delivered by a friend.
      </h3>

      <p class="text-white text-sm max-w-xs">
        Join our community of food lovers and get exclusive discounts every day.
      </p>

    </div>

    <!-- RIGHT SIDE -->
    <div class="md:w-1/2 flex flex-col justify-center items-center p-10 bg-white fade-in-right">



      <!-- LOGIN REGISTER SWITCH -->
      <div class="flex bg-gray-200 rounded-full p-1 w-fit mb-8 mx-auto">
        @php
        // Determine the prefix (customer or owner) based on the URL
        $prefix = request()->is('owner*') ? 'owner' : 'customer';
        $isLogin = request()->is('*/login');
        @endphp

        <a href="/{{ $prefix }}/login"
          class="px-6 py-2 rounded-full font-semibold transition-all {{ $isLogin ? 'bg-white text-orange-500 shadow-sm' : 'text-gray-600' }}">
          Login
        </a>

        <a href="/{{ $prefix }}/register"
          class="px-6 py-2 rounded-full font-semibold transition-all {{ !$isLogin ? 'bg-white text-orange-500 shadow-sm' : 'text-gray-600' }}">
          Register
        </a>
      </div>

      <h2 class="text-3xl font-bold mb-2">
        Welcome back
      </h2>

      <p class="text-gray-500 mb-6">
        Please enter your details to sign in.
      </p>

      <div class="w-full max-w-md">
        <form method="POST" action="{{ request()->is('owner*') ? '/owner/login' : '/customer/login' }}">
          @csrf

          @if($errors->any())
          <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm text-left">
            <strong>Whoops! Something went wrong.</strong>
            <ul class="list-disc pl-5 mt-1">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <!-- EMAIL -->
          <div class="mb-3">
            <label class="text-sm text-gray-600">Email Address</label>
            <input type="email" name="email"
              class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>

          <!-- PASSWORD -->
          <div class="mb-6">
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password"
              class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>

          <!-- SIGN IN BUTTON WITH ORANGE GRADIENT + hover animation -->
          <button
            class="w-full text-white py-3 rounded-lg font-semibold transition-transform duration-300 transform hover:scale-105 hover:shadow-lg"
            style="background: linear-gradient(to right,  #FDBA74, #FB923C);">
            Sign In
          </button>

        </form>
      </div>

      <p class="text-center text-sm mt-6 text-gray-500">
        {{ $isLogin ? "Don't have an account?" : "Already have an account?" }}
        <a href="/{{ $prefix }}/{{ $isLogin ? 'register' : 'login' }}" class="text-orange-500 font-semibold">
          Switch to {{ $isLogin ? 'Register' : 'Login' }}
        </a>
      </p>

    </div>

  </div>

</body>

</html>