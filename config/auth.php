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
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'pelanggans' => [
        'driver' => 'eloquent',
        'model' => App\Models\Pelanggan::class,
    ],
],


];
