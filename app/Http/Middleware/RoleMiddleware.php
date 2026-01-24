<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
   public function handle($request, Closure $next, ...$roles)
{
    $user = Auth::user();
    if (!$user) return redirect('/login');

    foreach ($roles as $role) {
        if ($role === 'admin'      && $user->admin)     return $next($request);
        if ($role === 'shop_owner' && $user->shopOwner) return $next($request);
        if ($role === 'customer'   && $user->customer)  return $next($request);
    }

    abort(403, 'Unauthorized');
}

}
