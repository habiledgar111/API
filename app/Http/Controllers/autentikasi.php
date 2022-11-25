<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Contract\Auth;

class autentikasi extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function register(Request $request){
        //connect to firebase
        $factory = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_key.json');
        $auth = $factory->createAuth();

        $userProperties = [
            'email' => $request->email,
            'password' => $request->password,
            'displayName' => $request->name
        ];

        $createduser = $auth->createUser($userProperties);
        var_dump($createduser);
    }

    public function login(Request $request){
        $factory = (new Factory)
        ->withServiceAccount(__DIR__.'/firebase_key.json');
        $auth = $factory->createAuth();

        //login
        $signInResult = $auth->signInWithEmailAndPassword($request->email, $request->password);
        if($signInResult != null){
            $user = $auth->getUserByEmail($request->email);
            $uid = $user->uid;
            $token = ['token' => 'ini token'];
            $customtoken = $auth->createCustomToken($uid,$token);
            $customtokenstring = $customtoken->toString();
            // var_dump($customtoken);
            echo $user->uid;
            var_dump($customtokenstring);

        }else{
        // var_dump($signInResult->uid);
        }
    }

    public function home(Request $request){
        $user = $request->user;
        return response()->json([
        'status' => 'Success',
        'message' => 'selamat datang ' . $user->displayName,
        ],200);
    }
}
