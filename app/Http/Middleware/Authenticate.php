<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Jika akses route admin
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Jika pelanggan
            return route('pelanggan.login.form');
        }
    }
}
