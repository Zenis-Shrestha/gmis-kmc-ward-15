<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log;
use App\Models\Token; 
use Illuminate\Support\Facades\App;
use Lcobucci\JWT\Parser;
use Laravel\Passport\TokenRepository;

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
        $token = $request->bearerToken();

            // If Bearer token is not present, try to get it from request input
            if (!$token) {
                $token = $request->input('token');
        
            }

            // If both Bearer token and request input are not present, set $token to null
            if (!$token) {
                $token = null;
             
            }

        if (isset($token)) {
            try {
               
                $jwt = (new Parser())->parse($token); // Parse the token
            
                    $tokenId = $jwt->getHeader('jti');
                // Retrieve the token from the repository
                $tokenRepository = app(TokenRepository::class);
                $tokenModel = $tokenRepository->find($tokenId);

                if ($tokenModel && $tokenModel->user_id) {
                    // Retrieve the associated user
                    $user = User::find($tokenModel->user_id);
                    if ($user->api_token == $token) {
                        // Authenticate the user
                        Auth::login($user);

                    } else {
                        // Handle case where user associated with token does not exist
                        return response()->json([
                            'status' => 'false',
                            'error' => 'Token Mismatched']);
                    }
                } else {
                    // Handle case where token is valid but no associated user found
                    return response()->json(['status' => 'false','error' => 'Unauthorized']);
                }
            } catch (ExpiredException $e) {
                // Handle expired token
                return response()->json(['status' => 'false','error' => 'Token expired']);
            } catch (\Exception $e) {
                // Handle other token parsing or repository errors
                return response()->json(['status' => 'false','error' => 'Token invalid']);
            }
        } else {
            // Handle case where $token is null or not set
            return response()->json(['status' => 'false','error' => 'Token not provided']);
        }

        // Proceed to the next middleware or route handler
        return $next($request);
    }
}

    

