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

Route::post('user/question/remove', ['uses' => 'MainController@removeQuestion', 'as' => 'remove_question']);


Route::get('edit_profile', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'MainController@editProfile',
    'as' => 'edit_profile'
]);

Route::post('edit_profile/upload_photo', [
    'uses' => 'MainController@uploadPhoto',
    'as' => 'upload_photo'
]);

Route::post('edit_profile/edit_user_info', [
    'uses' => 'MainController@editUserInfo',
    'as' => 'edit_user_info'
]);

Route::post('edit_profile/edit_general_user_info', [
    'uses' => 'MainController@editGeneralUserInfo',
    'as' => 'edit_general_user_info'
]);

Route::post('friends/addfriend', [
    'uses' => 'FriendController@addFriend',
    'as' => 'add_friend'
]);

Route::post('friends/accept_request_friend', [
    'uses' => 'FriendController@acceptRequestFriend',
    'as' => 'accept_request_friend'
]);

Route::post('friends/reject_request_friend', [
    'uses' => 'FriendController@rejectRequestFriend',
    'as' => 'reject_request_friend'
]);

Route::post('friends/remove_friend', [
    'uses' => 'FriendController@rejectRequestFriend',
    'as' => 'remove_friend'
]);

Route::get('friends', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'FriendController@userFriends',
    'as' => 'user_friends'
]);

Route::get('friends/ajax', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'FriendController@userFriendsAjax',
    'as' => 'user_friends_ajax'
]);