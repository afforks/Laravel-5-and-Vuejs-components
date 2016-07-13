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
Route::get('/', ['as'=>'index','uses'=>'VueController@index']);
Route::get('/dependency', 'VueController@dependency');
Route::get('/test', 'VueController@test');
Route::get('/add-more', 'VueController@addmore');
Route::get('/item', 'VueController@getItem');
Route::get('/items', ['as'=>'all_items','uses'=>'VueController@allItems']);
Route::post('/item', ['as'=>'item.post','uses'=>'VueController@saveItem']);
Route::delete('item/{id}','VueController@deleteItem');
Route::put('item/{id}','VueController@updateItem');
Route::get('item/{id}','VueController@fetchItem');
Route::get('multi-select','VueController@multiSelect');
Route::get('select2','VueController@select2');
Route::get('excel','VueController@excel');
Route::get('csv','VueController@csv');
Route::get('lern','VueController@lern');
Route::get('tabs','VueController@tabs');
Route::get('images','VueController@images');
Route::post('images','VueController@postImages');
Route::post('multi-images','VueController@postMultiImages');
Route::get('vue-table','VueController@vueTable');
Route::post('/save-csv','VueController@saveCsv');
Route::get('/error-page','VueController@errorPage');
Route::get('/key-events','VueController@keyEvents');

//
Route::get('/api/exceptions','VueController@getExceptions');

Route::get('api/countries','VueController@getCountries');
Route::get('api/states','VueController@getStates');
Route::get('api/cities','VueController@getCities');
Route::get('api/items','VueController@getItems');
Route::get('api/all-items',function(){
	return App\Item::select('name','price','no_of_items','discount','total')->get();
});

