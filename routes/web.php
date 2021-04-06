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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'Controller@test');
Route::get('/tradepage/{trade_id}', 'Controller@tradepage');
Route::get('/off/{trade_id}', 'Controller@off');
Route::get('/on/{trade_id}', 'Controller@on');

Route::get('/macd/newrobot', 'MACDController@newrobotpage');
Route::get('/macd/newrobotexecute', 'MACDController@newrobotexecute');
Route::get('/macd/robot/{robot_id}', 'MACDController@robotpage');
Route::get('/macd/off/{trade_id}', 'MACDController@off');
Route::get('/macd/on/{trade_id}', 'MACDController@on');
Route::get('/macd/remove/{trade_id}', 'MACDController@remove');
Route::get('/macd/test', 'MACDController@test');