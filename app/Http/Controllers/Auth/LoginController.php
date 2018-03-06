<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('displays.login');
    }

    public function shibboleth()
    {
        if (app()->environment() == 'local') {
            return redirect('/');
        } elseif (app()->environment() == 'production') {
            $url = config('app.url');
            $server = request()->server('SERVER_NAME');
            return redirect()->away("https://{$server}/Shibboleth.sso/Login?target={$url}");
        }
    }

    public function logout(Request $request)
    {
        session()->flush();
        auth()->logout();
        return redirect()->route('login');
    }
}
