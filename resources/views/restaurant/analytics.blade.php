<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="p-8">

<h2 class="text-xl font-bold mb-6">Analytics</h2>

<div class="grid grid-cols-3 gap-6">

<div class="bg-white p-5 rounded shadow">
<p>Total Sales</p>
<h2 class="text-xl font-bold">$12K</h2>
</div>

<div class="bg-white p-5 rounded shadow">
<p>Orders</p>
<h2 class="text-xl font-bold">320</h2>
</div>

</div>

</div>

</body>
</html>