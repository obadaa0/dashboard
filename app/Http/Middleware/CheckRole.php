<?php

namespace App\Http\Middleware;

use App\Helpers\AuthHelper;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        $user = AuthHelper::getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'قم بتسجيل الدخول اولا']);
        }
        if (!($user->role === 'police' || $user->role === 'admin')) {
            return response()->json(['message' => 'غير مصرح بالدخول هنا'], 401);
        }
        return $next($request);
    }
}
