<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* | | api routes | | | here is where you can register api routes for your application. these | routes are loaded by the routeserviceprovider within a group which | is assigned the "api" middleware group. enjoy building your api! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
