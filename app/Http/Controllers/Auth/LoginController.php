<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Traits\RedirectsHome;

class LoginController extends Controller
{
    use RedirectsHome;
    use AuthenticatesUsers;


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
     * @param string $provider
     * @param string $region
     * @return Response
     * @throws Exception
     */
    public function redirectToProvider(string $provider, string $region = NULL)
    {
        // socialite enabled providers
        $enabled_providers = explode(',', env('SOCIALITE_PROVIDERS'));
        if (! in_array($provider, $enabled_providers)) {
            throw new \Exception('That provider is not available');
        }
        
        $socialite = Socialite::driver($provider)
                ->scopes('wow.profile');
        $socialite->withRegion($region); // for OAuth2 state
        // if not using region default in .env...
        if (NULL !== $region) {
            // for the API endpoint
            $socialite->setRegion($region);
        }

        return $socialite->redirect();
    }

    /**
    * Obtain the user information from provider.  Check if the user already exists in our
    * database by looking up their provider_id in the database.
    * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
    * redirect them to the authenticated users homepage.
    *
     * @param Request $request
     * @param string $provider OAuth2 provider
     * @return Response
     */
    public function handleProviderCallback(Request $request, String $provider)
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

        $socialite_user = Socialite::driver($provider)->user();
        $request->session()->put('access_token', $socialite_user->token);
        $authUser = $this->findOrCreateUser($socialite_user, $provider);
        Auth::login($authUser, true);
        return $this->redirectHome();
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
        $region = strtolower($user->region);
        $authUser = \App\User::where([
            ['provider_id', '=', $user->id],
            ['provider', '=', $provider],
        ]);

        // difference in logging in between cn and us/eu/apac regions:
        if ($region === 'cn') {
            $authUser = $authUser->where(['battlenet_region_default', '=', $region])
                    ->first();
        } else {
            // all other regions share the same battlenet group so technically they can log in from any of those regions
            $authUser = $authUser->where(function ($query) {
                $query->where('battlenet_region_default', '=', 'us')
                      ->orWhere('battlenet_region_default', '=', 'eu')
                      ->orWhere('battlenet_region_default', '=', 'apac');
            })->first();
        }

        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name'     => !$user->name && property_exists($user, 'nickname') ? $user->nickname : $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'battlenet_region_default' => $region,
        ]);
    }

}
