<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 

class FixedTokenAuth
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
        // Extract the Authorization header
        $authorizationHeader = $request->header('Authorization');
    
        if (Str::startsWith($authorizationHeader, 'Bearer ')) {
            // Remove 'Bearer ' from the start to get the actual token
            $token = Str::substr($authorizationHeader, 7); // 7 is the length of 'Bearer '
            $user = User::where('api_token', $token)->first();
                if (!$user) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
        
                // Authenticate the user
                Auth::login($user);
        
            }
    
        return $next($request);
    }
    
}
