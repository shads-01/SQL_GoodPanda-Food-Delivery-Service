<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$restaurantId = 1; // Assuming restaurant 1
$filter = 'all';

$sql = file_get_contents(base_path('database/sql/queries/restaurant/get_restaurant_orders.sql'));
$rawRecords = DB::select($sql, [
    $restaurantId, 
    $filter, 
    $filter, 
    $filter,
    $filter
]);

print_r($rawRecords);
