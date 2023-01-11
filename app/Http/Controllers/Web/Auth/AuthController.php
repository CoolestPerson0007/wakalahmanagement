<?php

namespace App\Http\Controllers\Web\Auth;

use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Events\User\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Auth\TwoFactor\Contracts\Authenticatable;
use App\Support\Enum\UserStatus;
use App\Support\Library\ActiveDirectory;
use App\User;
use Auth;
use Authy;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * Create a new authentication controller instance.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('guest', ['except' => ['getLogout']]);
        $this->middleware('auth', ['only' => ['getLogout']]);
        $this->middleware('registration', ['only' => ['getRegister', 'postRegister']]);
        $this->users = $users;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $socialProviders = config('auth.social.providers');

        return view('auth.login', compact('socialProviders'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|AuthController
     */
    public function postLogin(LoginRequest $request)
    {
        // In case that request throttling is enabled, we have to check if user can perform this request.
        // We'll key this by the username and the IP address of the client making these requests into this application.
        $throttles = setting('throttle_enabled');

        //Redirect URL that can be passed as hidden field.
        $to = $request->has('to') ? "?to=" . $request->get('to') : '';

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->getCredentials();

        if (setting('ldap_enabled'))
        {
            if (! $profile = $this->ldapAuthentication($credentials)) {
                if ($throttles) {
                    $this->incrementLoginAttempts($request);
                }

                return redirect()->to('login' . $to)
                    ->withErrors(trans('auth.failed'));
            }

            // check disabled account
            if (isset($profile->is_blocked) && $profile->is_blocked === "TRUE")
            {
                return redirect()->to('login' . $to)
                    ->withErrors(trans('app.your_account_is_banned'));
            }

            // internal lookup
            $user = User::where('username', $credentials['username'])->first();

            // the user doesn't exist in the local database, so we have to create one
            if (!$user)
            {
                if (setting('ldap_create_user'))
                {
                    $user = new User();
                    $user->username = $credentials['username'];
                    $user->password = app('hash')->make($credentials['password']);
                    $user->email = strtolower($profile->email);
                    $user->first_name = $profile->name;
                    $user->phone = $profile->mobile ?? '';
                    $user->country_id = 458; // Force Malaysia
                    $user->role_id = 2;
                    $user->hash = app('hash')->make($profile->email);
                    $user->status = 'Active';
                    $user->save();
                }
                else
                {
                    return redirect()->to('login' . $to)
                        ->withErrors(trans('app.please_activate_your_account_first'));
                }
            }
        }

        else
        {
            if (! Auth::validate($credentials)) {
                if ($throttles) {
                    $this->incrementLoginAttempts($request);
                }

                return redirect()->to('login' . $to)
                    ->withErrors(trans('auth.failed'));
            }

            $user = Auth::getProvider()->retrieveByCredentials($credentials);

            if ($user->isUnconfirmed()) {
                return redirect()->to('login' . $to)
                    ->withErrors(trans('app.please_confirm_your_email_first'));
            }
        }

        // banned using internal management
        if ($user->isBanned()) {
            return redirect()->to('login' . $to)
                ->withErrors(trans('app.your_account_is_banned'));
        }

        Auth::login($user, setting('remember_me') && $request->get('remember'));

        return $this->handleUserWasAuthenticated($request, $throttles, $user);
    }

    /**
     * Making LDAP authentication with credential using tmpunch api
     *
     * @param  array $credentials user credential
     * @return bool
     */
    private function ldapAuthentication($credentials)
    {
        $native_auth = setting('ldap_native_auth') ?? false;

        if ($native_auth)
        {
            if ((new ActiveDirectory)->validate($credentials))
            {
                return (new ActiveDirectory)->getProfile($credentials['username']);
            }
        }
        else
        {
            try
            {
                $client = new \GuzzleHttp\Client();
                $response = $client->request('POST', 'https://api.tmpunch.com/auth/idss', [
                    'json' => $credentials
                ]);

                return json_decode($response->getBody())->profile;
            }

            catch (\GuzzleHttp\Exception\ClientException $ex)
            {
                \Log::debug($ex->getResponse()->getBody(true));
            }
        }

        return false;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  Request $request
     * @param  bool $throttles
     * @param $user
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles, $user)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (setting('2fa.enabled') && Authy::isEnabled($user)) {
            return $this->logoutAndRedirectToTokenPage($request, $user);
        }

        event(new LoggedIn);

        if ($request->has('to')) {
            return redirect()->to($request->get('to'));
        }

        return redirect()->intended();
    }

    protected function logoutAndRedirectToTokenPage(Request $request, Authenticatable $user)
    {
        Auth::logout();

        $request->session()->put('auth.2fa.id', $user->id);

        return redirect()->route('auth.token');
    }

    public function getToken()
    {
        return session('auth.2fa.id') ? view('auth.token') : redirect('login');
    }

    public function postToken(Request $request)
    {
        $this->validate($request, ['token' => 'required']);

        if (! session('auth.2fa.id')) {
            return redirect('login');
        }

        $user = $this->users->find(
            $request->session()->pull('auth.2fa.id')
        );

        if (! $user) {
            throw new NotFoundHttpException;
        }

        if (! Authy::tokenIsValid($user, $request->token)) {
            return redirect()->to('login')->withErrors(trans('app.2fa_token_invalid'));
        }

        Auth::login($user);

        event(new LoggedIn);

        return redirect()->intended('/');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        event(new LoggedOut);

        Auth::logout();

        return redirect('login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'username';
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $request->input($this->loginUsername()).$request->ip(),
            $this->maxLoginAttempts()
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function incrementLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->hit(
            $request->input($this->loginUsername()).$request->ip(),
            $this->lockoutTime() / 60
        );
    }

    /**
     * Determine how many retries are left for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function retriesLeft(Request $request)
    {
        $attempts = app(RateLimiter::class)->attempts(
            $request->input($this->loginUsername()).$request->ip()
        );

        return $this->maxLoginAttempts() - $attempts + 1;
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $request->input($this->loginUsername()).$request->ip()
        );

        return redirect('login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getLockoutErrorMessage($seconds),
            ]);
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds)
    {
        return trans('auth.throttle', ['seconds' => $seconds]);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->clear(
            $request->input($this->loginUsername()).$request->ip()
        );
    }

    /**
     * Get the maximum number of login attempts for delaying further attempts.
     *
     * @return int
     */
    protected function maxLoginAttempts()
    {
        return setting('throttle_attempts', 5);
    }

    /**
     * The number of seconds to delay further login attempts.
     *
     * @return int
     */
    protected function lockoutTime()
    {
        $lockout = (int) setting('throttle_lockout_time');

        if ($lockout <= 1) {
            $lockout = 1;
        }

        return 60 * $lockout;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $socialProviders = config('auth.social.providers');

        return view('auth.register', compact('socialProviders'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @param RoleRepository $roles
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterRequest $request, RoleRepository $roles)
    {
        // Determine user status. User's status will be set to UNCONFIRMED
        // if he has to confirm his email or to ACTIVE if email confirmation is not required
        $status = setting('reg_email_confirmation')
            ? UserStatus::UNCONFIRMED
            : UserStatus::ACTIVE;

        $role = $roles->findByName('User');

        // Add the user to database
        $user = $this->users->create(array_merge(
            $request->only('email', 'username', 'password'),
            ['status' => $status, 'role_id' => $role->id, 'hash' => sha1($request->email)]
        ));

        event(new Registered($user));

        $message = setting('reg_email_confirmation')
            ? trans('app.account_create_confirm_email')
            : trans('app.account_created_login');

        return redirect('login')->with('success', $message);
    }

    /**
     * Confirm user's email.
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmEmail($token)
    {
        if ($user = $this->users->findByConfirmationToken($token)) {
            $this->users->update($user->id, [
                'status' => UserStatus::ACTIVE,
                'confirmation_token' => null
            ]);

            return redirect()->to('login')
                ->withSuccess(trans('app.email_confirmed_can_login'));
        }

        return redirect()->to('login')
            ->withErrors(trans('app.wrong_confirmation_token'));
    }
}
