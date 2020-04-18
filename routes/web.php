<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::middleware(['auth'])->group(function (){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/onboarding', 'OnboardingController@index')->name('onboarding');
    Route::get('/join', 'FamilyController@join');
    Route::post('/family', 'FamilyController@store');

    Route::get('/schedule', 'ScheduleController@index');
    Route::post('/schedule', 'ScheduleController@store');
    Route::delete('/schedule/{schedule}', 'ScheduleController@destroy');

    Route::resource('/todo', 'TodoController')->names(['destroy' => 'todo.delete', 'index' => 'todo.index', 'edit' => 'todo.edit']);
    Route::put('/todo/{todo}/done', 'TodoController@markAsDone')->name('todo.done');
});
