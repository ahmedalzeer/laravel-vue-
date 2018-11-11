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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources(['user'=>'API\UserController',
                    'item'=>'API\ItemController',
                    'category'=>'API\CategoryController',
                    'sale'=>'API\SaleController',
                    'buy'=>'API\BuyController',
                    'outlay'=>'API\OutlayController']);
Route::get('profile','API\UserController@profile');
Route::get('finduser','API\UserController@search');
Route::post('salemount','API\SaleController@mountitem');
Route::get('finditem','API\SaleController@search');
Route::put('profile','API\UserController@updateprofile');
