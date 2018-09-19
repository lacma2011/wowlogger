<?php

namespace App\Traits;

use Auth;

trait LoginLinker
{
    
    public function printLoginLink()
    {
        $user = Auth::user();

        if (NULL === $user) {
            $url = route('loginsocial',['provider'=>config('fish.login.default_socialite_provider')]);
            return "(You are not logged in. <a href=\"$url\">Login</a>)";
        }
        
        return "(You are {$user->name}) <form method=\"post\" action=\"" . route('logout') . "\"><input type=\"submit\" value=\"Logout\">" . csrf_field() . "</form>";
    }
}
