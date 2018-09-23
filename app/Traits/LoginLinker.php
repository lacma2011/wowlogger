<?php

namespace App\Traits;

use Auth;

trait LoginLinker
{
    
    public function printLoginLink()
    {
        $user = Auth::user();

        if (NULL === $user) {
            $str = '(You are not logged in. Login ';
            $regions = config('fish.battlenet.regions');
            array_walk($regions, function(&$region, &$key) use (&$str){
                $url = route('loginsocial', [
                    'provider' => config('fish.login.default_socialite_provider'),
                    'region' => strtolower($region),
                ]);
                $str .= '<a href="' . $url. '">(' . $region . ')</a> ';
            });
            return $str;
        }
        
        return "(You are {$user->name}) <form method=\"post\" action=\"" . route('logout') . "\"><input type=\"submit\" value=\"Logout\">" . csrf_field() . "</form>";
    }
}
