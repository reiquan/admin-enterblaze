<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\CustomPersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsNotExpired
{
        /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token) {
            $accessToken = CustomPersonalAccessToken::findToken($token);

            if ($accessToken && $accessToken->expires_at && $accessToken->expires_at->isPast()) {
                return response()->json(['message' => 'Token has expired.'], 401);
            }
        }

        return $next($request);
    }
}