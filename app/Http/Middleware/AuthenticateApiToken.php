<?php

namespace App\Http\Middleware;

use App\Models\Candidate;
use App\Models\PersonalAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateApiToken
{
    /**
     * Handle an incoming API request by authenticating Bearer token.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (empty($token)) {
            // Check if already authenticated via session
            if (Auth::guard('web')->check()) {
                return $next($request);
            }

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Bearer token missing.',
            ], 401);
        }

        $accessToken = null;
        if (class_exists(\Laravel\Sanctum\PersonalAccessToken::class)) {
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        }

        if (! $accessToken) {
            $accessToken = PersonalAccessToken::findToken($token);
        }

        if (! $accessToken || ! $accessToken->tokenable) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token.',
            ], 401);
        }

        /** @var Candidate $candidate */
        $candidate = $accessToken->tokenable;

        // Associate token with candidate
        if (method_exists($candidate, 'withAccessToken')) {
            $candidate->withAccessToken($accessToken);
        }

        // Set user on request and Auth guard
        Auth::setUser($candidate);
        $request->setUserResolver(fn () => $candidate);

        // Update token last used at timestamp
        $accessToken->forceFill(['last_used_at' => now()])->save();

        return $next($request);
    }
}
