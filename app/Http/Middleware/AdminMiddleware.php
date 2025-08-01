<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to perform this action. (Admin only)'
        ], 403);
    }
}
