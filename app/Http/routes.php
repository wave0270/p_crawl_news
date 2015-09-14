<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/'              				, ['uses' => 'WelcomeController@index', 	'as'   => 'index']);
Route::get('/news_list'              		, ['uses' => 'WelcomeController@show_news_list', 	'as'   => 'news_list']);
Route::get('/news_detail'              		, ['uses' => 'WelcomeController@show_news_detail', 	'as'   => 'news_detail']);

// Route::post('/getUrlContent', 	'WelcomeController@getUrlContent');

Route::get('home', 'HomeController@index');
Route::get('/crawlData'              		, ['uses' => 'HomeController@crawlData', 	'as'   => 'crawlData']);
Route::post('/aj_save_news'      			, ['uses' => 'HomeController@save_news']);

// Route::post('/aj_save_news', function()
    // {
        // return 'Success! ajax in laravel 5';
    // });

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
