<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $accountType
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $accountType): mixed
    {
        if ($request->user()->account_type !== $accountType) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => 'You do not have the required account type to access this resource.'
            ], 403);
        }

        return $next($request);
    }
}
