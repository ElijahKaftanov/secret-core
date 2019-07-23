<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => [],
    'namespace' => 'Api\\Controller',
], function ()  {
    Route::get('key', 'ServerController@getPublicKey');
    Route::post('register', 'UserController@register');
    Route::get('secret', 'SecretController@view');
    Route::post('secret', 'SecretController@store');
});
