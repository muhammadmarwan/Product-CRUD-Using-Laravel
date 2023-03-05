<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;

Route::middleware('randomUser')->group(function(){

    Route::group(['prefix'=>'products'],function(){
        Route::apiResource('products',ProductController::class);
    });

});
