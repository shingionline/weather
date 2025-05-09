<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\User;
use App\Classes\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function user(Request $request) 
    {   
        // get user info
        return $request->user(); 
    }
    
    public function login(Request $request)
    {
        try {
            $data = $request->all();
            $email = trim($data['email']);
            $password = trim($data['password']);

            // try to login
            if (Auth::attempt(['email' => $email, 'password' => $password])) {

                $user = User::where('email', $email)->first();

                // create token
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'url' => '/home'
                ]);
            } else {
                return response()->json([
                    'message' => 'Incorrect login details'
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json(
                [ 'message' => $e->getMessage() ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $data = $request->all();

            $name = trim($data['name']);
            $surname = trim($data['surname']);
            $email = trim($data['email']);
            $password = trim($data['password']);

            // check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                return response()->json(
            [ 'message' => 'Please enter a valid email address'], 400);

            // check if email is registered
            $check = User::where('email', $email)->first();
            if (!empty($check))
                return response()->json([ 'message' => 'Account already exists with this email'], 400);

            $register = new Register();
            $user = $register->createUser($name, $surname, $email, $password);

            // create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'url' => '/home'
            ]);
        } catch (Exception $e) {
            return response()->json([ 'message' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try { 
            Session::flush();
            $request->user()->tokens()->delete();
            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([ 'message' => $e->getMessage()], 500);
        }
    }
}