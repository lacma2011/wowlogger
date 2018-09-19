<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\Traits\LoginLinker;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, LoginLinker;
    
    /*
     * User's home page
     */
    public function user(User $user, $user_id = NULL)
    {
        $return = '';
        if (NULL !== $user_id) {
            $u = $user->find($user_id);            
            $return .= "this is user {$u->name}'s page. ";
        }

        return $return . $this->printLoginLink();
    }
}
