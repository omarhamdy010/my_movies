<?php

namespace App\Http\Controllers\Auth;

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
        $this->middleware('guest:admin')->except('logout');
//        $this->middleware('auth:admin')->except('login');
    }

    public function showAdminLoginForm()
    {
        return view('adminauth.adminlogin', ['url' => 'admin']);
    }

    public function login(\Illuminate\Http\Request $request)
    {
        $inputVal = $request->all();
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))) {

            return redirect('front/fronts');
        }
        return back()->withInput($request->only('email', 'remember'));
    }


    public function loginAdmin(\Illuminate\Http\Request $request)
    {
        $inputVal = $request->all();
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('admin')->attempt(array('email' => $inputVal['email'], 'password' => $inputVal['password']))) {

            return redirect()->route('dashboard.index');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

}


