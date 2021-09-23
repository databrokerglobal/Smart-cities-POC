<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

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

    /**
     *  
     * 
     * Display Login form
     * 
     */
    public function showLoginForm()
    {
        $action = "your account";

        return view('auth.login')->with('action', $action);
    }
    /**
     * 
     * Login 
     * 
     * 
     */
    public function login(Request $request)
    {        

        $this->validateLogin($request);
        $user = User::select('userStatus')->where('email',$request->email)->first();
        if( $user && $user->userStatus!=1){
            return redirect()->back()->with('error', trans('auth.inactive'));
        }
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $request->password = Hash::check($request->password, 'password');

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    /**
     *  Send login response
     * 
     * 
     * 
     */
    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        
        return $this->authenticated($request, auth()->user())
                ?redirect(back()): redirect()->intended($this->redirectPath());
    }
    /**
     * 
     * 
     *  Logout
     * 
     */
    public function logout(Request $request){
        Auth::logout();

        session()->forget('curCommunity');

        return view('auth.logout_success')
            ->with('message', 'You have been successfully logged out.');
    }
    /**
     * 
     * 
     *  Validate login
     * 
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email'     => 'required|email|string',
            'password'  => 'required|string',
        ]);
    }
    /**
     * 
     *  Return which field is set for username
     * 
     * 
     */
    public function username()
    {
        return 'email';
    }
}
