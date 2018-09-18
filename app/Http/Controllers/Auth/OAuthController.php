<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BattleNetApi;
use App\Services\BattleNet;

class OAuthController extends Controller
{
    public function redirectToProvider_BattleNet()
    {
        return redirect(BattleNetApi::authenticationURL()); // redirect to BattleNet login page
    }

    public function handleProviderCallback_BattleNet(BattleNet $bnet, Request $request)
    {
        $social_type = "BattleNet";

        if (isset($_GET['code'])) {
            $code = $_GET['code'];

            $token = BattleNetApi::requestToken($code);

            $account = BattleNetApi::authenticatedUser($token);

            echo "Logged in with:\n";
            var_dump($account);
            echo "\nTrying API:\n\n";
            var_dump($bnet->getCurrentUser($token));

        } else {
            return redirect('/')->withErrors('failed.');
        }
    }
}