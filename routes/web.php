<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', /*'middleware' => 'auth:api'*/], function () use ($router) {
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->get('/users', 'UserController@index');
        $router->post('/users', 'UserController@store');
        $router->get('/users/{user}', 'UserController@show');
        $router->put('/users/{user}', 'UserController@update');
        $router->patch('/users/{user}', 'UserController@update');
        $router->delete('/users/{user}', 'UserController@destroy');
        $router->get('me', 'UserController@me');
    });
});
