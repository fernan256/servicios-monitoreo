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
Route::get('api/domains/show', 'DomainsController@show');
Route::post('api/domains/newMasterZone', 'ZonesController@store');
Route::delete('api/domains/{id}', 'ZonesController@destroy');
//Route::group(['prefix' => 'api'], function()
//{
  //Route::resource('domains', 'DomainsController');

//});
