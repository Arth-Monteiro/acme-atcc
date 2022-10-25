<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAndPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (RedirectResponse)  $next
     * @return RedirectResponse|Response
     */
    public function handle(Request $request, Closure $next): RedirectResponse | Response
    {
        $role_permissions = Roles::find(Auth::user()->role_id)->permissions;
        foreach ($role_permissions as $permission) {
            if ($request->routeIs($permission)) {
                return $next($request);
            }
        }

        return redirect('home');
    }
}
