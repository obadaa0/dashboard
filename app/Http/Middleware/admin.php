<?php

namespace App\Http\Middleware;

use App\Helpers\AuthHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = AuthHelper::getUserFromToken($request);
        if(!$user){
            return response()->json(['message' => 'login Please'],401);
        }
        if($user->role === "user"){
            return $next($request);
        }
        else{
            return response()->json(['message' => "You don't have this permission"],401);
        }
    }
}
