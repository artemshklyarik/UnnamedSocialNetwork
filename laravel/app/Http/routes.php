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

/*Main Page Route*/
Route::get('/', ['uses' => 'MainController@index', 'as' => 'main']);


//auth
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'logout']);
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


//user page
Route::get('user/{id}', ['middleware' => 'App\Http\Middleware\UserCheck', 'uses' => 'MainController@showProfile', 'as' => 'user']);

//questions
Route::post('user/ask/{id}', ['uses' => 'MainController@askQuestion', 'as' => 'ask_question']);
Route::post('user/answer/{id}', ['uses' => 'MainController@answerQuestion', 'as' => 'answer_question']);
Route::post('user/question/remove', ['uses' => 'MainController@removeQuestion', 'as' => 'remove_question']);
Route::get('myquestions', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'QuestionController@getPage',
    'as' => 'myquestions'
]);

Route::get('myquestions/ajax', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'QuestionController@QuestionAjax',
    'as' => 'myquestions_ajax'
]);

//edit_profile
Route::get('edit_profile', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'MainController@editProfile',
    'as' => 'edit_profile'
]);

Route::get('edit_profile/save_thumbnail', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'MainController@saveThumbnailAjax',
    'as' => 'save_thumbnail'
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

Route::get('geo_ajax', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'MainController@geoAjax',
    'as' => 'geoAjax'
]);

//friends
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

// search
Route::get('search/people', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'SearchController@searchPeople',
    'as' => 'search_people'
]);

Route::get('search/people/ajax', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'SearchController@searchPeopleAjax',
    'as' => 'search_people_ajax'
]);

//newsletter
Route::get('newsletter', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'NewsletterController@getPage',
    'as' => 'newsletter'
]);

Route::get('newsletter/ajax', [
    'middleware' => 'App\Http\Middleware\UserCheck',
    'uses' => 'NewsletterController@NewsletterAjax',
    'as' => 'newsletter_ajax'
]);
