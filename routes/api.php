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

Route::middleware('auth:api')->group(function () {
    Route::post('/words', 'WordController@store');
    Route::patch('/words/{word}', 'WordController@update');
    Route::delete('/words/{word}', 'WordController@destroy');

    Route::post('/likes', 'LikeController@store');
    Route::delete('/likes/{word_id}', 'LikeController@destroy');

    Route::get('/words/mylist/{page?}', 'WordController@myList');
});

Route::get('/words/toplaved/{page?}', 'WordController@topLaved');
Route::get('/words/tophated/{page?}', 'WordController@topHated');
Route::get('/words/{page?}', 'WordController@index');
Route::get('/word/{word}', 'WordController@show');

Route::patch('/lang/{lang}', 'LanguageController@update');

Route::post('search', 'SearchController@index');