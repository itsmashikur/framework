<?php


Route::get('/', 'HomeController@index');
Route::get('/contact', 'ContactController@index');
Route::get('/blog/{id}/{status}/{user}/{u}', 'BlogController@index');
Route::get('/form', 'HomeController@index');

Route::group('/admin', function() {
    Route::get('/', 'HomeController@index');
});
