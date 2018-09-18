<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BattleNetApi;

class OAuthController extends Controller
{
    public function redirectToProvider_BattleNet()
    {
        return redirect(BattleNetApi::authenticationURL()); // redirect to BattleNet login page
    }

    public function handleProviderCallback_BattleNet()
    {
        $social_type = "BattleNet";

        if (isset($_GET['code'])) {
            $code = $_GET['code'];

            $token = BattleNetApi::requestToken($code);

            $account = BattleNetApi::authenticatedUser($token);

            echo "Logged in with:";
            var_dump($account);
        } else {
            return redirect('/')->withErrors('failed.');
        }
    }
}