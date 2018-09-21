<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 修改前
//        Broadcast::routes();
        // 修改后
        Broadcast::routes(["middleware" => "auth:api"]);
        require base_path('routes/channels.php');
    }
}
