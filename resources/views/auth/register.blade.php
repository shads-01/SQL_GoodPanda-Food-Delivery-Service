<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register</title>
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- FULL SCREEN FLEX -->
  <div class="flex flex-col md:flex-row w-full h-full min-h-screen">

    <!-- LEFT SIDE -->
    <div class="md:w-1/2 flex flex-col items-center justify-center p-10 text-center"
      style="background: linear-gradient(135deg, #FDBA74, #FB923C);">

      <!-- Heading -->
      <h2 class="text-5xl md:text-6xl font-extrabold text-white mb-16">
        GoodPanda
      </h2>

      <!-- Circle with panda image fully visible + bounce animation -->
      <div
        class="w-64 h-64 rounded-full bg-white flex items-center justify-center mb-6 shadow-xl overflow-hidden animate-bounce-slow">
        <img
          src="https://images.fineartamerica.com/images/artworkimages/mediumlarge/3/kawaii-cute-anime-panda-otaku-japanese-ramen-noodles-finnly-maria.jpg"
          class="w-full h-full object-cover" alt="Panda">
      </div>

      <!-- Subheading and text -->
      <h3 class="text-xl font-semibold text-white mb-2">
        Join our community of food lovers
      </h3>

      <p class="text-white text-sm max-w-xs">
        Register today to order or sell your favorite meals.
      </p>

    </div>

    <!-- RIGHT SIDE -->
    <div class="md:w-1/2 flex flex-col justify-center items-center p-10 bg-white">

      <!-- LOGIN REGISTER SWITCH -->
      <div class="flex bg-gray-200 rounded-full p-1 w-fit mb-8 mx-auto">

        <a href="/login" class="px-6 py-2 rounded-full text-gray-600 font-semibold">
          Login
        </a>

        <a href="/register" class="px-6 py-2 rounded-full bg-white text-orange-500 font-semibold">
          Register
        </a>

      </div>

      <h2 class="text-3xl font-bold mb-2">
        Create account
      </h2>

      <p class="text-gray-500 mb-6">
        Fill in your details to sign up.
      </p>

      <div class="w-full max-w-md">
        <form method="POST" action="/register">
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

          <!-- NAME -->
          <div class="mb-3 text-left">
            <label class="text-sm text-gray-600">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
              class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>

          <!-- EMAIL -->
          <div class="mb-3 text-left">
            <label class="text-sm text-gray-600">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}"
              class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>

          <!-- PHONE NUMBER -->
          <div class="mb-3 text-left">
            <label class="text-sm text-gray-600">Phone Number</label>
            <input type="text" name="number" value="{{ old('number') }}"
              class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>

          <!-- ADDRESS-->
          <div class="mb-3 text-left">
            <label class="text-sm text-gray-600">Address</label>
            <input type="text" name="address" value="{{ old('address') }}"
              class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>

          <!-- PASSWORD -->
          <div class="mb-6 text-left">
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password"
              class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
          </div>


          <div class="mb-8">
            <p class="text-sm text-gray-500 mb-4 text-center">
              Choose your role
            </p>
            <div class="flex gap-3 justify-center">
              <!-- Customer -->
              <label class="relative flex-1 cursor-pointer group">
                <input type="radio" name="role" value="customer" class="peer hidden" checked>
                <div
                  class="flex flex-col items-center p-3 border-2 rounded-xl transition-all duration-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 group-hover:border-orange-200">
                  <div
                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2 peer-checked:bg-orange-100 transition-colors">
                    <i data-feather="user"
                      class="w-5 h-5 text-gray-500 group-hover:text-orange-500 peer-checked:text-orange-600 transition-colors"></i>
                  </div>
                  <span class="text-xs font-bold text-gray-600 peer-checked:text-orange-600">Customer</span>
                </div>
              </label>

              <!-- Owner -->
              <label class="relative flex-1 cursor-pointer group">
                <input type="radio" name="role" value="restaurant_owner" class="peer hidden">
                <div
                  class="flex flex-col items-center p-3 border-2 rounded-xl transition-all duration-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 group-hover:border-orange-200">
                  <div
                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2 peer-checked:bg-orange-100 transition-colors">
                    <i data-feather="home"
                      class="w-5 h-5 text-gray-500 group-hover:text-orange-500 peer-checked:text-orange-600 transition-colors"></i>
                  </div>
                  <span class="text-xs font-bold text-gray-600 peer-checked:text-orange-600">Owner</span>
                </div>
              </label>

              <!-- Rider -->
              <label class="relative flex-1 cursor-pointer group">
                <input type="radio" name="role" value="delivery_partner" class="peer hidden">
                <div
                  class="flex flex-col items-center p-3 border-2 rounded-xl transition-all duration-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 group-hover:border-orange-200">
                  <div
                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mb-2 peer-checked:bg-orange-100 transition-colors">
                    <i data-feather="truck"
                      class="w-5 h-5 text-gray-500 group-hover:text-orange-500 peer-checked:text-orange-600 transition-colors"></i>
                  </div>
                  <span class="text-xs font-bold text-gray-600 peer-checked:text-orange-600">Rider</span>
                </div>
              </label>
            </div>
          </div>

          <!-- REGISTER BUTTON WITH ORANGE GRADIENT + hover animation -->
          <button
            class="w-full text-white py-3 rounded-lg font-semibold transition-transform duration-300 transform hover:scale-105 hover:shadow-lg"
            style="background: linear-gradient(to right,  #FDBA74, #FB923C);">
            Register
          </button>

        </form>
      </div>


      <p class="text-center text-sm mt-6 text-gray-500">
        Already have an account?
        <a href="/login" class="text-orange-500 font-semibold">
          Switch to Login
        </a>
      </p>

    </div>

  </div>

  <!-- Tailwind Custom Animations -->
  <style>
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
      animation: bounce-slow 4.5s ease-in-out;
    }

    /* Style for our custom selector when native styling is needed */
    input[type="radio"]:checked+div i {
      color: #F97316 !important;
    }

    input[type="radio"]:checked+div {
      border-color: #F97316 !important;
      background-color: #FFF7ED !important;
    }

    input[type="radio"]:checked+div span {
      color: #F97316 !important;
    }

    input[type="radio"]:checked+div .w-10 {
      background-color: #FFEDD5 !important;
    }
  </style>

</body>

</html>