<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

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
    }


    /**
      * Redirect the user to the OAuth Provider.
      *
      * @return Response
      */
    public function redirectToProvider($provider)
    {
        echo "OK";exit;
//TODO: check config for region
        return Socialite::driver($provider)
                ->scopes('wow.profile')
                ->redirect();
    }

    /**
            * Obtain the user information from provider.  Check if the user already exists in our
            * database by looking up their provider_id in the database.
            * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
            * redirect them to the authenticated users homepage.
            *
            * @return Response
            */
    public function handleProviderCallback(Request $request, $provider)
    {
        // check if user didnt finish
        if (TRUE == TRUE) {
            //auth/linkedin/callback?error=user_cancelled_login&error_description=
            //auth/twitter/callback?denied=derssXEderERz2-fejLM
            $query = $request->query();
            $hasError = FALSE;
            if (array_key_exists('error', $query) && !empty($query['error'])) {
                $hasError = TRUE;
            } else if (array_key_exists('denied', $query) && !empty($query['denied'])) {
                $hasError = TRUE;
            }

            if ($hasError) {
                return redirect()->route('login')->withErrors(["error" => "Couldn't authenticate ATM. Try alternative methods."
                ]);
            }
        }

        $user = Socialite::driver($provider)->user();

//TODO: include region that user selected for redirectToProvider()
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    /**
            * If a user has registered before using social auth, return the user
            * else, create a new user object.
            * @param  $user Socialite user object
            * @param $provider Social auth provider
            *  @return  User
            */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = \App\User::where([
            ['provider_id', '=', $user->id],
            ['provider', '=', $provider]
        ])->first();

        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name'     => !$user->name && property_exists($user, 'nickname') ? $user->nickname : $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }

}
