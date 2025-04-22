<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;

class WebController extends Controller
{
    public function home_page()
    {
        $user = Auth::user();
        return view('pages.home', compact('user'));
    }

    public function login_page()
    {
        return view('auth.login');
    }

    public function register_page()
    {
        return view('auth.register');
    }

    public function web_login(Request $request)
    {
        try {
            $auth_token = $request->auth_token;

            // Find the token model from database
            $token = PersonalAccessToken::findToken($auth_token);

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token'
                ]);
            }

            // Get the user from the token
            $user = $token->tokenable;

            Auth::login($user);

            return response()->json([
                'success' => true,
                'url' => '/home'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function web_logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
