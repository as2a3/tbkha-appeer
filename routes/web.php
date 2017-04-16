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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/facebook/logInto/','socialMediaController@redirectToProvider');
Route::get('/facebook/callBack','socialMediaController@handleProviderCallback');


Route::resource('users', 'UserController');
Route::group(['middleware' => 'auth'], function () {
  Route::resource('categories', 'CategoryController');
  Route::resource('recipes', 'RecipeController');
  Route::resource('ingredients', 'IngredientController');
  Route::resource('steps', 'StepController');
  Route::post('ingredients/delete/{id}', 'IngredientController@destroy');
  Route::post('steps/delete/{id}', 'StepController@destroy');
  Route::post('recipes/upload-image','RecipeController@upload_image');


});


Route::resource('likes', 'likeController');

Route::resource('images', 'imageController');