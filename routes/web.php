<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    if (Auth::check()) {
        return view('welcome');
    }
    return redirect()->route('login');

    // return view('home');
});

Route::get('/map', function () {
    if (Auth::check()) {
        return view('map');
    }
    return redirect()->route('login');

    // return view('home');
});


Auth::routes();

Route::get('/labs', 'HomeController@index')->name('home');
