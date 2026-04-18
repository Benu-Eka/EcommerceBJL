<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Type of 'quantity' in order_items: " . \Illuminate\Support\Facades\Schema::getColumnType('order_items', 'quantity') . "\n";
echo "Type of 'jumlah' in stok_barangs: " . \Illuminate\Support\Facades\Schema::getColumnType('stok_barangs', 'jumlah') . "\n";
