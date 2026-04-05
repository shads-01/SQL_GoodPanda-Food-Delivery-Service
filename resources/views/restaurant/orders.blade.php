<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="p-8">

<h2 class="text-xl font-bold mb-4">Orders</h2>

<table class="w-full bg-white shadow rounded">

<tr class="border-b">
<th class="p-3">Order ID</th>
<th>Customer</th>
<th>Status</th>
<th></th>
</tr>

<tr class="border-b">
<td class="p-3">#123</td>
<td>John</td>
<td class="text-yellow-500">Pending</td>
<td><button class="text-green-500">Accept</button></td>
</tr>

</table>

</div>

</body>
</html>