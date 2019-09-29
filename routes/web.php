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

Route::get('/api','APIcontroller@api');
Route::get('/create','APIcontroller@create');
Route::post('/api','APIcontroller@apicall');
Route::post('/city','APIcontroller@city');
// Route::post('/api','APIcontroller@search');