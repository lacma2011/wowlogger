<?php

namespace App\Traits;
use Auth;

trait RedirectsHome
{
    /**
     * go to user's home page if authenticated. Otherwise go to general home page
     */
    public function redirectHome()
    {
        $user = Auth::user();
        if (NULL === $user) {
            return redirect()->route('home');
        }
        return redirect()->route('myhome',['user_id'=>$user->id]);
    }
    
    public function printHome()
    {
        $user = Auth::user();
        if (NULL === $user) {
            return route('home');
        }
        return route('myhome',['user_id'=>$user->id]);

    }
}
