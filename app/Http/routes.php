<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//Route::group(['middleware' => ['web']], function () {
    //
//});
Route::get('api/domains', 'DomainsController@index');
Route::get('api/domains/showRecord', 'DomainsController@showRecord');
Route::get('api/domains/showDomain', 'DomainsController@showDomain');
Route::post('api/domains/newMasterZone', 'ZonesController@store');
Route::delete('api/domains/{id}', 'DomainsController@destroy');
Route::get('api/mailboxs', 'MailboxController@index');
Route::get('api/mailboxs/domains', 'MailDomainController@index');
Route::post('api/mailboxs/newMailbox', 'MailboxController@store');
Route::delete('api/mailboxs/{address}', 'MailboxController@destroy');
Route::get('api/mailboxs/{id}', 'MailboxController@show');
Route::patch('api/mailboxs/{address}', 'MailboxController@update');
//Route::group(['prefix' => 'api'], function()
//{
  //Route::resource('domains', 'DomainsController');

//});
