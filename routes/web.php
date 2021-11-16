<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return \Illuminate\Support\Facades\App::getLocale();
});

$router->group(['namespace'=>'Cart\GuestCart'],function () use ($router){

$router->get('create_guest_cart', 'GuestCartController@createEmptyCart');
});
