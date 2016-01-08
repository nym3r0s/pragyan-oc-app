<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JSONResponse;
use App\User;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_roll = $request->input('user_roll');
        $user_secret = $request->input('user_secret');
        
        $user = User::where('user_roll','=',$user_roll)
                    ->where('user_secret','=',$user_secret)
                    ->get();

        if(count($user) > 0)
        {
            return $next($request);
        }
        return JSONResponse::response(401);
    }
}
