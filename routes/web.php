<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/EnChuKong', 'EnChuKongController');

Route::post('/EnChuKong/selenium/server', 'EnChuKongController@startSeleniumServer');
Route::delete('/EnChuKong/selenium/server', 'EnChuKongController@stopSeleniumServer');

Route::get('/crawler', 'EnChuKongController@webdriver')->name('crawler');


Route::get('/test', function(){
    return $_ENV['MAIL_TARGET'];
});
