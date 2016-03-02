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

Route::group(['prefix' => 'api'], function()
{
  Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
  Route::post('authenticate', 'AuthenticateController@authenticate');
  Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

  Route::get('domains', 'DomainsController@index');
	Route::get('domains/records/{id}', 'DomainsController@showRecord');
	Route::get('domains/{id}', 'DomainsController@show');
	Route::post('domains/newMasterZone', 'ZonesController@store');
	Route::post('domains/newSlaveZone', 'ZonesController@storeSlave');
	Route::delete('domains/{id}', 'DomainsController@destroy');
	Route::patch('domains/{id}', 'DomainsController@edit');

	Route::get('records/{id}', 'RecordsController@show');
	Route::post('records', 'RecordsController@store');
	Route::patch('records', 'RecordsController@update');
	Route::delete('records/{id}', 'RecordsController@destroy');

	Route::get('mailboxs', 'MailboxController@index');
	Route::get('mailboxs/domains', 'MailDomainController@index');
	Route::post('mailboxs/newMailbox', 'MailboxController@store');
	Route::delete('mailboxs/{address}', 'MailboxController@destroy');
	Route::get('mailboxs/{id}', 'MailboxController@show');
	Route::patch('mailboxs', 'MailboxController@edit');

	Route::post('mailDomain/new', 'MailDomainController@store');
	Route::get('mailDomain/{id}', 'MailDomainController@show');
	Route::delete('mailDomain/{id}', 'MailDomainController@destroy');
	Route::patch('mailDomain', 'MailDomainController@update');

	Route::resource('process', 'ProcessController', ['only' => [
		'index', 'update', 'store', 'destroy', 'show'
	]]);
});
