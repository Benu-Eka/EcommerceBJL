<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$barangs = \App\Models\Barang::take(5)->get();
foreach($barangs as $b) {
    echo "{$b->kode_barang}: {$b->foto_produk}\n";
}
