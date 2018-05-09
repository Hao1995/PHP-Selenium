<?php

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

Route::get('/test', function(){

    $cmdOutput = exec('chcp 65001 & taskkill /IM cmd.exe /fi "WINDOWTITLE eq SeleniumServer*"');
    $splitString = explode(":", $cmdOutput);

    $status = $splitString[0];

    if ($status == 'SUCCESS'){
        return $status;
    }
    
    $cmdOutput = exec('chcp 65001 & taskkill /IM cmd.exe /fi "WINDOWTITLE eq 選取 SeleniumServer*"');
    $splitString = explode(":", $cmdOutput);

    $status = $splitString[0];

    if ($status == 'SUCCESS'){
        return $status;
    }

    return "[ERROR]:" . $cmdOutput;
});
