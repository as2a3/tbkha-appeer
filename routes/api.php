<?php

use Illuminate\Http\Request;
use \App\Http\Middleware\check_autherization ;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/facebook/login/{token}/{fcm_token?}','API\SocialMediaAPIController@handleProviderLogIn');
Route::get('recipes/list/{page}/{token?}','API\RecipeAPIController@list_all');
Route::get('recipes/category_recipes/{category_id}/{page}','API\RecipeAPIController@category_recipes');
Route::get('recipes/user_recipes/{user_id}/{page}/{state}','API\RecipeAPIController@user_recipes');
Route::get('recipes/featured/','API\RecipeAPIController@featured_recipes');
Route::get('recipes/{id}','API\RecipeAPIController@show');
Route::get('users/user_profile/{id}','API\UserAPIController@user_profile');
Route::post('likes', 'API\likeAPIController@store')->middleware('check_autherization');
Route::resource('categories', 'API\CategoryAPIController');
Route::post('images/upload/{type}', 'API\imageAPIController@store');
// Route::resource('recipes', 'API\RecipeAPIController');
// Route::resource('likes', 'API\likeAPIController');


// Route::resource('images', 'API\imageAPIController');
