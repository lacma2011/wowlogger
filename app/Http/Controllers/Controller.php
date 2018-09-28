<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\Traits\LoginLinker;
use App\Services\BattleNet;
use Illuminate\Http\Request;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, LoginLinker;

    /*
     * home page
     */
    public function home()
    {
        return $this->printLoginLink();
    }
    
    /*
     * User's home page
     */
    public function user(User $user, $user_id)
    {

        $u = $user->find($user_id);
        $logged_in = Auth::user();

        return view('user', [
            'user' => $u,
            'logged_in' => $logged_in,
            'login_link' => $this->printLoginLink(),
        ]);
    }
    
    public function userPost(BattleNet $bnet, Request $request)
    {
        $user = Auth::user();
        $region = $request->input('region');
        $token = $request->session()->get('access_token');
        if (!empty($request->input('update'))) {
            $added = $bnet->updateCharacters($token, $user->id, $region);
            return $added . " characters added.";
        }
    }
}
