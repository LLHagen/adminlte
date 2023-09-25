<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param string ...$guards
     * @return Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if ($request->bearerToken()) {
            if (Auth::guard('sanctum')->user()) {
                return response()->json([
                    'error' => 'Not found',
                    'result' => null,
                ], 404);
            }
        }

        return $next($request);
    }
}
