<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class JWTMiddleware
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
        $factory = (new Factory)
        ->withServiceAccount('App\Http\Controllers/firebase_key.json');
        $auth = $factory->createAuth();

        $token = $request->header('token')??$request->query('token');

        if(!$token){
            return response()->json([
                'error' => 'Token not provded.'
                ], 401);
        }
        try{
            $verifiedtoken = $auth->verifyIdToken($token);
        }catch (FailedToVerifyToken $e){
            echo 'The token is invalid: '.$e->getMessage();
        }
        $uid = $verifiedIdToken->claims()->get('sub');

        $user = $auth->getUser($uid);
        $request->user = $user;
        return $next($request);
    }
}
