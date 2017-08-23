<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $phone = $request->get('phone');
        $phone = str_replace(['+', '(', ')', ' ', '-'], '', $phone);
        $phone = preg_replace('/^[78]/', '7', $phone);

        $user = User::where('phone', $phone)->firstOrFail();
        if ($user != null) {
            $password = md5($request->get('password') . $user->salt);
            if ($password === $user->password) {
                if ($user->role == 'admin') {
                    Auth::login($user, true);
                    return $this->sendLoginResponse($request);
                }
            }
        }

        return $this->sendFailedLoginResponse($request);

    }
}
