<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Classes\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_post(Request $request)
    {
        try {
            $data = $request->all();
            $email = trim($data['email']);
            $password = trim($data['password']);

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'success' => true,
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

    public function register()
    {
        return view('auth.register');
    }

    public function register_post(Request $request)
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

            return response()->json([
                'success' => true,
                'url' => '/home'
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
