<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\LogEmail;
use App\Mail\LoginLink;
use App\Models\Contact;
use App\Helpers\Helpers;
use App\Classes\Register;
use App\Mail\UserWelcome;
use App\Jobs\BroadcastJob;
use App\Mail\AdminWelcome;
use App\Models\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_token($token)
    {
        $login = LoginRequest::where('token', $token)->first();

        if (empty($login)) {
            return view('pages.invalid-link');
        }

        $user_id = $login->user_id;

        $user = User::find($user_id);

        Auth::login($user);

        if ($user_id != 167) {
            LoginRequest::where('user_id', $user->id)->delete();
        }

        return redirect('/home');
    }

    public function redirect()
    {
        $ip      = Helpers::getIpAddress();
        $ipinfo  = Helpers::getIpInfo($ip);
        $code    = $ipinfo->code ?? null;
        $country = Helpers::getCountryByCode($code);
        $message = 'Service not available in ' . $country;
        $mailData = [
            'message' => 'Service not available',
            'country' => $country,
            'ip' => $ip
        ];

        /*
        if (!in_array($country, Helpers::allowedCountries())) {
            Mail::mailer('cpanel')->to(config('app.support_email'))->send(new LogEmail(json_encode($mailData)));
            return view('pages.error', ['message' => $message]);
        }
        */

        return Socialite::driver('google')->redirect();
    }

    public function login_post(Request $request)
    {
        try {
            $data = $request->all();
            $email = trim($data['email']);

            $user = User::where('email', $email)->first();

            if (empty($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not registered'
                ]);
            }

            // send login link
            $token = md5(uniqid(random_int(1,1000000), true));
            Mail::to($user->email)->send(new LoginLink($user, $token));

            return response()->json([
                'success' => true,
                'message' => "<b>$email</b><br>Please check your email for login link"
            ]);
            
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function security_post(Request $request)
    {
        $data = $request->all();
        $submitted_answer = trim($data['submitted_answer']);
        $correct_answer = $data['correct_answer'];
        $url = (empty(request()->cookie('redirect'))) ? '/' : request()->cookie('redirect');

        // check if answer is correct
        if ($submitted_answer != $correct_answer) {
            return response()->json([
                'success' => false,
                'message' => 'Wrong answer, please try again'
            ]);
        }

        // if answer is correct set cookie called 'human' to true for 12 months
        $cookie = cookie('human', 'true', 525601);
        return response()->json([
            'success' => true,
            'url' => $url
        ])->withCookie($cookie);
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

            // check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                return response()->json(['success' => false, 'message' => 'Please enter a valid email address']);

            // check if email is registered
            $check = User::where('email', $email)->first();
            if (!empty($check))
                return response()->json(['success' => false, 'message' => 'Account already exists with this email']);

            $register = new Register();
            $user = $register->createUser($name, $surname, $email);

            // login the user
            Auth::login($user);

            return response()->json([
                'success' => true,
                'url' => "/home"
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        $cookie = cookie()->forget('referral');

        return Redirect('/')->withCookie($cookie);
    }
}
