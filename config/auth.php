<?php

return [
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'pelanggan' => [
        'driver' => 'session',
        'provider' => 'pelanggans',
    ],
],

'providers' => [

    'pelanggans' => [
        'driver' => 'eloquent',
        'model' => App\Models\Pelanggan::class,
    ],
],


];
