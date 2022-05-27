<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});



Route::group(['namespace' => 'Api'] , function(){

    Route::apiResource('employee' , 'EmployeeController');
    Route::apiResource('supplier' , 'SupplierController');
    Route::apiResource('category' , 'CategoryController');
});