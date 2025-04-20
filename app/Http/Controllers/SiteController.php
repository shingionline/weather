<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        return view('pages.home', compact('user'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
}
