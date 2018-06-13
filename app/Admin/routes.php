<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('xpaths', XpathController::class);
    $router->resource('applies', ApplyController::class);
    $router->get('users', 'UserController@users');
    $router->resource('emails', EmailController::class);
});
