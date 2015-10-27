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

Route::pattern('tenant', '[A-Za-z0-9_]+');
Route::pattern('item_id', '[A-Za-z0-9_]+');

Route::get('/', 'TenantsController@index');
Route::get('home', 'TenantsController@index');

Route::group(['prefix' => 'api'], function() {
    Route::get('tenant/{tenant}/item/{item_id}', ['as' => 'api.{tenant}.item.{item_id}', 'uses' => 'ItemsController@show']);
});

Route::get('tenants', ['as' => 'tenants', 'uses' => 'TenantsController@index']);
Route::group(['prefix' => 'tenant'], function() {
    Route::get('{name}/items', ['as' => 'demo.{tenant}.items', 'uses' => 'TenantsItemsController@index']);
    Route::get('{tenant}/item/{item_id}/detail', ['as' => 'demo.{tenant}.item.{item_id}.detail', 'uses' => 'TenantsItemsController@show']);
});
