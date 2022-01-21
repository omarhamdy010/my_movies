<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    protected $guard = 'admin';

    protected $redirectTo = RouteServiceProvider::HOME;

    public function showLoginForm()
    {
        return redirect()->route('dashboard.index');
    }

    protected function guard()
    {
        return Auth::guard($this->guard);
    }

    public function __construct()
    {
        $this->middleware(['admin'])->except('logout');
    }

    public function login(\Illuminate\Http\Request $request)
    {
        $inputVal = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))){
            if (auth()->guard('admin')->user()->check()) {
                return redirect()->route('dashboard.index');
            }else{
                return redirect()->route('front/index');
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email & Password are incorrect.');
        }
    }




}
