<?php

namespace Fully\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use Flash;

class SentinelPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check()) {
            if (!Sentinel::inRole('superadmin')) {


                if (!$request->route()->getName()) {
                    return $next($request);
                }
                $route_name=$request->route()->getName();
                $clean_route_name=str_replace(getLang().'.','',$route_name);

                if ($clean_route_name != 'admin.dashboard' && !Sentinel::hasAccess($clean_route_name)) {
                    Flash::error('You are not permitted to access this area');
                    return Redirect::route('admin.dashboard')->withErrors('Permission denied.');
                }
            }
        }

        return $next($request);
    }
}
