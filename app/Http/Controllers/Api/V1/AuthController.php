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
        return $request->user(); 
    }
    
    public function login(Request $request)
    {
        try {
            $data = $request->all();
            $email = trim($data['email']);
            $password = trim($data['password']);

            if (Auth::attempt(['email' => $email, 'password' => $password])) {

                $user = User::where('email', $email)->first();

                // create token
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'url' => '/home'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect login details'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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
                return response()->json(['success' => false, 'message' => 'Please enter a valid email address']);

            // check if email is registered
            $check = User::where('email', $email)->first();
            if (!empty($check))
                return response()->json(['success' => false, 'message' => 'Account already exists with this email']);

            $register = new Register();
            $user = $register->createUser($name, $surname, $email, $password);

            // login the user
            Auth::login($user);

            // create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'url' => '/home'
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try { 
            Session::flush();
            $request->user()->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
