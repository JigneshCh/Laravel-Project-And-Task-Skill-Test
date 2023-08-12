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

Route::get('/projects/datatable', 'ProjectsController@dataTable');
Route::resource('/projects', 'ProjectsController');

Route::get('/', 'TasksController@index');
Route::post('/tasks/reset-priority', 'TasksController@resetPriority');
Route::resource('/tasks', 'TasksController');


