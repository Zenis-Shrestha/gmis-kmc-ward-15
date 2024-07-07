<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class FixedTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle($request, Closure $next)
    // {
    //     $token = $request->header('Authorization');

    //     // Replace with the token generated in the seeder
    //     $fixedToken = '8yHEEFVhEzqozp0VjalXqaeihuPkpjMvVGIE2ho8GjaPMCgMuuHDdbPcW6Vq';

    //     if ($token !== $fixedToken) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     // Find the user with the fixed token
    //     $user = User::where('api_token', $fixedToken)->first();
    //     if (!$user) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     // Authenticate the user
    //     Auth::login($user);

    //     return $next($request);
    // }


    public function handle($request, Closure $next)
    {
       
        $token = $request->bearerToken();
      
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
