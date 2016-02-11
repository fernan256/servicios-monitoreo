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
Route::get('api/domains/records/{id}', 'DomainsController@showRecord');
Route::get('api/domains/{id}', 'DomainsController@show');
Route::post('api/domains/newMasterZone', 'ZonesController@store');
Route::post('api/domains/newSlaveZone', 'ZonesController@storeSlave');
Route::delete('api/domains/{id}', 'DomainsController@destroy');
Route::patch('api/domains/{id}', 'DomainsController@edit');

Route::get('api/records/{id}', 'RecordsController@show');
Route::post('api/records', 'RecordsController@store');
Route::patch('api/records', 'RecordsController@update');
Route::delete('api/records/{id}', 'RecordsController@destroy');

Route::get('api/mailboxs', 'MailboxController@index');
Route::get('api/mailboxs/domains', 'MailDomainController@index');
Route::post('api/mailboxs/newMailbox', 'MailboxController@store');
Route::delete('api/mailboxs/{address}', 'MailboxController@destroy');
Route::get('api/mailboxs/{id}', 'MailboxController@show');
Route::patch('api/mailboxs', 'MailboxController@edit');

Route::post('api/mailDomain/new', 'MailDomainController@store');
Route::get('api/mailDomain/{id}', 'MailDomainController@show');
Route::delete('api/mailDomain/{id}', 'MailDomainController@destroy');
Route::patch('api/mailDomain', 'MailDomainController@update');
//Route::group(['prefix' => 'api'], function()
//{
  //Route::resource('domains', 'DomainsController');

//});
