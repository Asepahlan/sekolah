<?php

namespace App\Http\Controllers\Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated($request, $user)
    {
        if($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        else if($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        }
        else if($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }
        else if($user->hasRole('ortu')) {
            return redirect()->route('ortu.dashboard');
        }
    }
}