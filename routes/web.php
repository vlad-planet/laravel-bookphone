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

Route::group(['prefix' => 'bookphone'], function()
{
	Route::get('', 'BookphoneController@readItems');
	Route::post('addFav', 'BookphoneController@addFav');
	Route::post('addItem', 'BookphoneController@addItem');
	Route::post('editItem', 'BookphoneController@editItem');
	Route::post('deleteItem', 'BookphoneController@deleteItem');
});
Route::get('favourites', 'BookphoneController@favItems');
Route::get('downloadExcel', 'BookphoneController@downloadExcel');


Route::get('/users', 'UserController@index');
//Route::get('/generateusers', 'DatabaseSeeder@run');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');



/*
    API Routes REST

curl --user admin:admin localhost/api/pages/index/xml 
curl --user admin:admin -d 'title=sample&slug=abc' localhost/api/pages/store
curl --user admin:admin localhost/api/pages/show/json/2
curl -i -X PUT --user admin:admin -d 'title=Updated Title' localhost/api/pages/update/2
curl -i -X DELETE --user admin:admin localhost/api/pages/destroy/1
*/

Route::group(['prefix' => 'api', 'before' => 'auth.basic'], function()
{
	Route::group(['prefix' => 'pages'], function()
	{
		//index/{type}  xml|json // index/xml // index/json 
		Route::get('index/{type}', 'BookphoneController@index');
		Route::post('store', 'BookphoneController@store');
		Route::post("show/{type}/{id}', 'BookphoneController@show");
		Route::post('update', 'BookphoneController@update');
		Route::post('destroy', 'BookphoneController@destroy');
	});
	Route::resource('users', 'UserController');
});
