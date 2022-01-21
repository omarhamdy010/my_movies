<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{

    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('dashboard/dashboard');

        }

        return redirect('home')->with('error',"Only admin can access!");    }
}
