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

$app->get('/', ['as' => 'main', function () use ($app) {
    //return $app->version();
    return view('main');
}]);


//$app->post('user/create', 'UserController@create');

$app->get('login', ['as' => 'login', function() {
    return view('login');
}]);
$app->post('login', 'AuthController@login');
$app->post('logout', 'AuthController@logout');


$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('dashboard', ['as' => 'dashboard', function() {
        return view('dashboard');
    }]);
});

$app->post('note/create', 'NoteController@create');

$app->delete('note/{id}', 'NoteController@delete');
$app->get('note/{id}', 'NoteController@get');
$app->put('note/{id}', 'NoteController@update');

$app->get('notes', 'NoteController@all');
