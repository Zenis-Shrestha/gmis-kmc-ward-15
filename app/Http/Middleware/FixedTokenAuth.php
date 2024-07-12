<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log;

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

      if($request->has('token')) {
        $token = $request->get('token');
        Log::info($token);
        $user = User::where('api_token', $token)->first();
        Log::info(print_r($user, 1));
          // If user exists, authenticate the user
          if ($user) {
              Auth::login($user); // Log in the user
              return $next($request);
          } else {
              return response()->json(['error' => 'Token mismatched.'], 401);
          }
      } else if ($authorizationHeader && Str::startsWith($authorizationHeader, 'Bearer ')) {
          // Extract token
          $token = Str::substr($authorizationHeader, 7); // Remove 'Bearer ' from token

          // Find user by token in database
          $user = User::where('api_token', $token)->first();

          // If user exists, authenticate the user
          if ($user) {
              Auth::login($user); // Log in the user
          } else {
              return response()->json(['error' => 'Token mismatched'], 401);
          }
      } else {
          return response()->json(['error' => 'Unauthorized '], 401);
      }

      return $next($request);
    }
    
}
