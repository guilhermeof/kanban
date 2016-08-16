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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'project', 'namespace' => 'System'], function (){

    Route::get('', 'ProjectController@index')->name('ProjectMain');

    Route::get('/create', 'ProjectController@create')->name('ProjectCreate');

    Route::post('', 'ProjectController@store')->name('ProjectStore');

    Route::get('{project}/edit', 'ProjectController@edit')->name('ProjectEdit');

    Route::post('{project}/update', 'ProjectController@update')->name('ProjectUpdate');

    Route::get('{project}/destroy', 'ProjectController@destroy')->name('ProjectDestroy');

    Route::get('/{id}/task',  'TaskController@index' )->name('TaskMain');

    Route::get('/{id}/kanban',  'TaskController@kanban' )->name('TaskKanban');

    Route::get('{id}/task/create', 'TaskController@create' )->name('TaskCreate');

    Route::post('/task/store', 'TaskController@store')->name('TaskStore');

    Route::get('/task/{id}/destroy','TaskController@destroy' )->name('TaskDestroy');

    Route::get('/task/{id}/edit', 'TaskController@edit' )->name('TaskEdit');

    Route::post('/task/{id}/update', 'TaskController@update' )->name('TaskUpdate');

    Route::get('/task/{task}', 'TaskController@status')->name('TaskAtt');

    Route::get('/task/{id}/async/{status}', 'TaskController@async')->name('async');

    Route::post('/task/changestatus', 'TaskController@ascynChangeStatus')->name('ascynChangeStatus');

    Route::get('/task/change/{id}/status/{status}', 'TaskController@changeStatus');


});

//Route::group(['prefix' => '/{project}/task', 'namespace' => 'System'], function (){
//
//    Route::get('', 'TaskController@index')->name('TaskMain');
//    Route::get('/create', 'TaskController@create')->name('TaskCreate');
//    Route::post('/', 'TaskController@store')->name('TaskStore');
//    Route::post('/{task}/edit', 'TaskController@edit');
//    Route::put('/{task}/update', 'TaskController@update');
//    Route::delete('/{task}/destroy', 'TaskController@destroy');
//
//});
