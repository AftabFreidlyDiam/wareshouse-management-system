<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class TransformResponseMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only transform if expecting JSON
        if ($request->expectsJson()) {
            $original = $response->getOriginalContent();

            // // Handle validation errors (422)
            // since it is exception, it is handled inhandler.php
            // if ($response->getStatusCode() === 422 && is_array($original)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Validation failed',
            //         'errors' => $original['errors'] ?? $original
            //     ], 422);
            // }

            // Standardize all successful responses
            if ($response->isSuccessful()) {
                return response()->json([
                    'success' => true,
                    'data' => $original,
                ], $response->getStatusCode());
            }

            // Optionally handle 404, 500 etc. here too
        }

        return $response;
    }
}
