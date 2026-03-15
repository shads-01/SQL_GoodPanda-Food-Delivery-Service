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
    <div class="w-64 h-64 rounded-full bg-white flex items-center justify-center mb-6 shadow-xl overflow-hidden animate-bounce-slow">
      <img src="https://images.fineartamerica.com/images/artworkimages/mediumlarge/3/kawaii-cute-anime-panda-otaku-japanese-ramen-noodles-finnly-maria.jpg" 
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

      <a href="/login"
         class="px-6 py-2 rounded-full text-gray-600 font-semibold">
        Login
      </a>

      <a href="/register"
         class="px-6 py-2 rounded-full bg-white text-orange-500 font-semibold">
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

      <!-- NAME -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Full Name</label>
        <input type="text" name="name"
               class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
      </div>

      <!-- EMAIL -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Email Address</label>
        <input type="email" name="email"
               class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
      </div>

      <!-- PHONE NUMBER -->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Phone Number</label>
        <input type="text" name="number"
               class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
      </div>

      <!-- ADDRESS-->
      <div class="mb-3">
        <label class="text-sm text-gray-600">Address</label>
        <input type="text" name="address"
               class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
      </div>

      <!-- PASSWORD -->
      <div class="mb-6">
        <label class="text-sm text-gray-600">Password</label>
        <input type="password" name="password"
               class="w-full border rounded-lg px-3 py-1.5 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm">
      </div>

      <!-- REGISTER BUTTON WITH ORANGE GRADIENT + hover animation -->
      <button
        class="w-full text-white py-3 rounded-lg font-semibold transition-transform duration-300 transform hover:scale-105 hover:shadow-lg"
        style="background: linear-gradient(to right,  #FDBA74, #FB923C);">
        Register
      </button>
    
    </form>
    </div>

    <!-- PORTAL CHOOSE -->
    <div class="mt-8 text-center">

      <p class="text-sm text-gray-500 mb-4">
        Choose your portal
      </p>

      <div class="flex gap-4 justify-center">

        <a href="/customer/register"
           class="border rounded-xl p-4 w-32 text-center hover:border-orange-500">
          <p class="text-sm font-semibold">Customer</p>
        </a>

        <a href="/owner/register"
           class="border rounded-xl p-4 w-32 text-center hover:border-orange-500">
          <p class="text-sm font-semibold">Owner</p>
        </a>

      </div>

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
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
}
.animate-bounce-slow {
  animation: bounce-slow 4.5s ease-in-out;
}
</style>

</body>
</html>