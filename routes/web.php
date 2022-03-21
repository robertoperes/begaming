<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/google-redirect', 'Auth\LoginController@redirectToGoogleProvider')->name('login-google');
Route::get('/google-callback', 'Auth\LoginController@handleGoogleProviderCallback')->name('app-strava');
Route::get('/strava-redirect', 'StravaController@redirectToStravaProvider')->name('app-strava');
Route::get('/strava-callback', 'StravaController@handleStravaProviderCallback');

Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function (){
        return view('auth.register');
    });
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::post('/register', 'Auth\LoginController@register')->name('register');
});