<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/ ';
    /**
     * 
     * 
     *  Display reset form
     * 
     */
    public function showResetForm(Request $request, $token = null)
    {
        $user = User::where('forgottenPasswordToken', $token)->first();
        if($user){
            $email = $user->email;
            return view('auth.passwords.reset')->with(
                    ['token'    => $token, 
                    'email'     => $email]
            );
        }
    }
    /**
     * 
     * 
     * Rules for Field
     * 
     */
    protected function rules()
    {
        return [
            'token'                 => 'required',
            'password'              => 'required|min:8|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' =>'same:password'
        ];
    }
    /**
     * 
     * 
     *  Validate error message
     * 
     */
    protected function validationErrorMessages()
    {
        return [
            'password.required'         =>'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password.min'              =>'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password.regex'            =>'Your password must contain at least 8 characters, including 1 uppercase letter and 1 digit.',
            'password_confirmation.same'=>'Passwords do not match.'
        ];
    }
    /**
     * 
     *  Credentials
     * 
     * 
     */
    protected function credentials(Request $request)
    {
        return $request->only(
                        'email', 
                        'password', 
                        'password_confirmation', 
                        'token'
                        );
    }
    /**
     *  Send reset failed response
     * 
     * 
     * 
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
    }
}
