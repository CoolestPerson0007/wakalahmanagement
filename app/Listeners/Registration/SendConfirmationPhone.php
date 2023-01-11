<?php

namespace App\Listeners\Registration;

use Twilio\Rest\Client as TwilioClient;
use App\Events\User\Registered;
use App\Notifications\EmailConfirmation;
use App\Repositories\User\UserRepository;

class SendConfirmationPhone
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->getRegisteredUser();

        if (! setting('reg_phone_confirmation')) 
        {
            return;
        }

        $code = rand(100000, 999999);

        $this->users->update($user->id, [
            'confirmation_code' => $code,
            'confirmation_expiry' => time() + (60 * env('OTP_EXPIRY', 5))
        ]);

        if (config('twilio.account_sid') && config('twilio.auth_token') && config('twilio.app_sid') && config('twilio.from')) 
        {
            $this->sendSMS($user->phone, $code);
        }
    }

    /**
     * Send SMS for confirmation.
     *
     * @param  Registered  $event
     * @return void
     */
    public function sendSMS($to, $code)
    {
        $accountSid = config('twilio.account_sid');
        $authToken  = config('twilio.auth_token');
        $appSid     = config('twilio.app_sid');

        $client     = new TwilioClient($accountSid, $authToken);

        try
        {
            $client->messages->create(
                $to,
                array(
                    'from' => config('twilio.from'),
                    'body' => 'Your OTP code is: ' . $code
                )
            );
        }

        catch (Exception $e)
        {

        }
    }    
}
