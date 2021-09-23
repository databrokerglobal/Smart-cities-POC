<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     *  Validate Email
     * 
     * 
     * 
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
    /**
     * 
     * 
     *  Login credentials paramameter 
     * 
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }
    /**
     * 
     *  Send link success response
     * 
     * 
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return view('auth.passwords.email_success')->with('message', 'We have e-mailed your password reset link!');
    }

    /**
     * 
     * Send link fail response
     * 
     * 
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }
}
