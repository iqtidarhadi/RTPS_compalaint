<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CitizenGuard
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        /**
         * Check authentication
         */
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.'
            ], 401);
        }

        /**
         * Check citizen role using Spatie
         */
        if (!$user->hasRole('citizen')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. This resource is only for citizens.'
            ], 403);
        }

        /**
         * Check if account active
         */
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. Please contact support.'
            ], 403);
        }

        /**
         * Check email verified
         */
        if (!$user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email address first.'
            ], 403);
        }

        /**
         * Check profile completed
         */
        if (!$user->firstname || !$user->password) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your profile registration first.'
            ], 403);
        }

        return $next($request);
    }
}