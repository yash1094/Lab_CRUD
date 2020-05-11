<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//List All the labs
Route::get('labs', 'LabController@index');

//List single lab
Route::get('lab/{id}', 'LabController@show');

// Create new lab
Route::post('lab', 'LabController@store');

//update lab
Route::put('lab', 'LabController@store');

//delete lab
Route::delete('lab/{id}', 'LabController@destroy');
