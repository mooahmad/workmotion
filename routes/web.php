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

$router->get('/aa', function () use ($router) {
    return 'mo Sala';});




$router->get('countries', 'SalaryController@getCountries');

$router->get('/category_positions', 'SalaryController@getPostions');



$router->get('/country/{country}/position/{catpos}/advanced', 'SalaryController@getResutl');

$router->post('/calculate_it', 'SarayCalcultorController@calculate');
$router->get('/getCountry', 'SarayCalcultorController@getCountry');
$router->get('/main_currency', 'SarayCalcultorController@getMainCurrency');


