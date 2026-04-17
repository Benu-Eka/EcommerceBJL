<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SAMPLE FOTO_PRODUK VALUES ===\n";
$products = DB::table('barangs')->whereNotNull('foto_produk')->limit(5)->get(['kode_barang', 'nama_barang', 'foto_produk']);
foreach ($products as $p) {
    echo "$p->kode_barang | $p->nama_barang | foto: $p->foto_produk\n";
}

echo "\n=== CHECK STORAGE LINK ===\n";
$storagePath = public_path('storage');
echo "storage link exists: " . (file_exists($storagePath) ? 'YES' : 'NO') . "\n";
echo "storage path: $storagePath\n";
