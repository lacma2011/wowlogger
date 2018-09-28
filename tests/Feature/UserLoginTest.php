<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;
use App\User;

class UserLoginTest extends TestCase
{
    /**
     * 
     *
     * @return void
     */
    public function testHomeLoggedIn()
    {
        Auth::login(User::find(1)->first());

        $response = $this->get('/user/1');
        $response->assertSee('You are glucas#1948');
    }

    /**
     * 
     *
     * @return void
     */
    public function testHomeLoggedOut()
    {
        $response = $this->get('/user/1');
        $response->assertSee('ot logged in'); // ex. "Not logged in."
    }
}
