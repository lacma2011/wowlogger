<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BattleNet;
use Xklusive\BattlenetApi\Services\WowService;

class BattleNetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('BattleNet', BattleNet::class);
        $this->app->bind('WowService', WowService::class);
    }
}
