<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RoleEnum;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

class Company
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->role == 'admin') {
            return $next($request);
        }

        if(Auth::user() &&  Auth::user()->role == 'company'){
            if (Auth::user()->profile->is_active == 1 && Auth::user()->role == 'company') {
                $status = ucwords(str_replace("_", " ",Auth::user()->profile->status));

                switch(Auth::user()->profile->status) {
                    case 'active':
                        return $next($request);
                        break;
                    case 'pending_approval':
                        return Response::error(403, "Unauthorized!, Your Account is still '{$status}'");
                        break;
                    default:
                        return Response::error(403, "Unauthorized!, You cannot perform this Action now");
                        break;
                }
            }

            if (Auth::user()->profile->is_active == 0 && Auth::user()->role == 'company') {
                $status = ucwords(str_replace("_", " ",Auth::user()->profile->status));
                return Response::error(403, "Unauthorized!, Your Account is still '{$status}'");
            }
        }
    }
}
