<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        return 'username'; // اسم الحقل الذي من خلالة سيتم تسجيل الدخول
    }

    public function redirectTo()
    {
        if (auth()->user()->roles->first()->allowed_route != '') {
            return $this->redirectTo = auth()->user()->roles->first()->allowed_route . '/index';
        }
    }

    public function showLoginForm()
    {
        return view('backend.admin-login'); // Redirect to the custom login view
    }

    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect('/admin/login');
    }
}
