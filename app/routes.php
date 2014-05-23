<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/tasks', [
        'as'   => 'tasks.index',
        'uses' => 'TaskController@index'
    ]);

Route::post('/tasks', [
        'as' => 'tasks.store',
        'uses' => 'TaskController@store'
    ]);

Route::get('/tasks/{id}/edit', [
        'as' => 'tasks.edit',
        'uses' => 'TaskController@edit'
    ]);
