<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

@include('restaurant.navbar')

<div class="p-8">

<h2 class="text-xl font-bold mb-4">Orders</h2>

<table class="w-full bg-white shadow rounded text-left">

<tr class="border-b bg-gray-50">
<th class="p-3">Order ID</th>
<th class="p-3">Customer</th>
<th class="p-3">Status</th>
<th class="p-3"></th>
</tr>

<tr class="border-b">
<td class="p-3">#123</td>
<td>John</td>
<td class="text-yellow-500">Pending</td>
<td class="p-3"><button class="text-green-500">Accept</button></td>
</tr>

</table>

</div>

</body>
</html>