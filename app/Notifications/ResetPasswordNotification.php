<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class ResetPasswordNotification extends ResetPassword
{
    public $token, $firstname, $email;

    public function __construct($token, $firstname, $email)
    {
        $this->token = $token;
        $this->firstname = $firstname;
        $this->email = $email;
    }
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = User::where('email', '=', $this->email)->first();
        if($user){
            $user->fill(['forgottenPasswordToken'=>$this->token]);
            $user->save();
        }

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token, $this->firstname, $this->email);
        }

        return (new MailMessage)
            ->view(
                'email.password', [
                    'token' => $this->token,
                    'firstname'=>$this->firstname,
                    'email'=>$this->email
                ]
            )
            ->subject(APPLICATION_NAME.' Password Reset');
    }
}
?>