<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserController@list');
    Route::get('/me', 'UserController@me');
    Route::post('/{id}', 'UserController@update');
    Route::get('/{id}', 'UserController@get');
});

Route::prefix('badge')->middleware('auth:api')->group(function () {
    Route::get('/', 'BadgeController@list');
    Route::post('/', 'BadgeController@create');
    Route::post('/{id}', 'BadgeController@update');

    Route::get('/types', 'BadgeController@types');
    Route::get('/classifications', 'BadgeController@classifications');

    Route::get('/{id}', 'BadgeController@get');
});

Route::prefix('point')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserPointBadgeController@list');
    Route::post('/', 'UserPointBadgeController@create');
    Route::get('/status', 'UserPointBadgeController@listStatus');
    Route::get('/{id}', 'UserPointBadgeController@get');
    Route::post('/{id}', 'UserPointBadgeController@update');
});

Route::prefix('dashboard')->middleware('auth:api')->group(function () {
    Route::get('/user-point-badge', 'DashboardController@listUserPointBadge');
    Route::get('/user-badge', 'DashboardController@listUserBadge');
    Route::get('/ranking', 'DashboardController@ranking');
});