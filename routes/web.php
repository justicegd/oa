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

Route::get('/test', 'addOa@test')->name("test");
Route::get('/add_oa', 'addOa@addOaPage')->name("addOaPage");
Route::post('/add_oa', 'addOa@doAddOa')->name("addOa");


