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
//Cors
$router->get('/', function() use ($router){
    return $router->app->version();

});

$router->group(['middleware' => 'cors'], function ($router){

//stuff
//struktur : $router->method('/path', 'NamaController@namaFunction');

//static 

//index
$router->get('stuffs', 'StuffController@index');
$router->get('users', 'UserController@index');
$router->get('/inbound-stuffs/data', 'InboundstuffController@index');
$router->get('/lendings', 'LendingController@index');

// Store
$router->post('/stuffs/store', 'StuffController@store');
$router->post('/users/store', 'UserController@store');
$router->post('/inbound-stuffs/store','InboundstuffController@store');
$router->post('/lendings/store', 'LendingController@store');
$router->post('/restorations/{lending_id}', 'RestorationController@store');

// trash
$router->get('/stuffs/trash', 'StuffController@trash');
$router->get('/users/trash', 'UserController@trash');
$router->get('/inbound-stuffs/trash', 'InboundstuffController@trash');

//Auth
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/profile', 'AuthController@me');

//dinamis

//show
$router->get('/stuffs/{id}', 'StuffController@show');
$router->get('/users/{id}', 'UserController@show');
$router->get('/lendings/{id}', 'LendingController@show');

//update
$router->patch('/stuffs/update/{id}', 'StuffController@update');
$router->patch('/users/update/{id}', 'UserController@update');

//destroy
$router->delete('/stuffs/delete/{id}', 'StuffController@destroy');
$router->delete('/users/delete/{id}', 'UserController@destroy');
$router->delete('/inbound-stuffs/delete/{id}', 'InboundstuffController@destroy');
$router->delete('/lendings/delete/{id}', 'LendingController@destroy');

//restore
$router->get('/stuffs/trash/restore/{id}', 'StuffController@restore');
$router->get('/users/trash/restore/{id}', 'UserController@restore');
$router->get('/restore/{id}', 'InboundstuffController@restore');

//permdel
$router->get('/stuffs/trash/permanent-delete/{id}','Stuffcontroller@permanentDelete');
$router->get('/users/trash/permanent-delete/{id}','Usercontroller@permanentDelete'); 
$router->delete('/inbound-stuffs/permanent-delete/{id}', 'InboundstuffController@permanentDelete');
});
