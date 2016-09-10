<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

/*Main Page Route*/
Route::get('/', ['uses' => 'MainController@index', 'as' => 'main']);

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'logout']);

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('user/{id}', ['middleware' => 'App\Http\Middleware\UserCheck', 'uses' => 'MainController@showProfile', 'as' => 'user']);

Route::post('user/ask/{id}', ['uses' => 'MainController@askQuestion', 'as' => 'ask_question']);
Route::post('user/answer/{id}', ['uses' => 'MainController@answerQuestion', 'as' => 'answer_question']);

Route::get('edit_profile', [
//    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'MainController@editProfile',
    'as' => 'edit_profile'
]);
