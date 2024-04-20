<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiSecurityKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $securityKey = $request->header('X-Api-Key');
        $expectedSecurityKey = env('API_SECURITY_KEY');

        if(!$securityKey){
            return response()->json([
                'error' => 'Please provide api key.'
            ],401);
        }

        if ($securityKey !== $expectedSecurityKey) {
            return response()->json([
                'error' => 'Invalid api key.'
            ], 401);
        }

        return $next($request);
    }
}
