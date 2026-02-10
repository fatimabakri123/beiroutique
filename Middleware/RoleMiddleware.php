<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
  public function handle($request, Closure $next, ...$roles)
{
    if (!Auth::check()) {
        // 🔥 يخزّن الصفحة الحالية ويروح عاللوجين
        return redirect()->guest(route('login'));
    }

    $user = Auth::user();

    foreach ($roles as $role) {
        if ($role === 'admin' && $user->admin()->exists()) {
            return $next($request);
        }

        if ($role === 'shop_owner' && $user->shopOwner()->exists()) {
            return $next($request);
        }

        if ($role === 'customer' && $user->customer()->exists()) {
            return $next($request);
        }
    }

    abort(403, 'Unauthorized');
}

}
