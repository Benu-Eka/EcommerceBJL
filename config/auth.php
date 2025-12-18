<?php

return [
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'pelanggans', // jika login default adalah pelanggan Breeze
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'users', // untuk admin
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
