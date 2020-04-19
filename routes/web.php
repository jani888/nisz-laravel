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
    Route::get('/join/{code}', 'FamilyController@joinWithURL');
    Route::get('/join', 'FamilyController@join');
    Route::post('/family', 'FamilyController@store');
    Route::get('/invite', 'FamilyController@index');

    Route::get('/schedule', 'ScheduleController@index');
    Route::post('/schedule', 'ScheduleController@store');
    Route::delete('/schedule/{schedule}', 'ScheduleController@destroy');

    Route::view('/chat', 'chat.index')->name('chat');
    Route::get('/chat/conversations', 'ConversationController@index');
    Route::get('/chat/conversations/{id}', 'ConversationController@show');
    Route::get('/chat/conversations/{id}/read', 'ConversationController@read');

    Route::get('family-finder', 'FamilyFinderController@index');
    Route::post('family-finder/setlocation', 'FamilyFinderController@setLocation');
    Route::post('family-finder/{family}', 'FamilyFinderController@friendRequest');

    Route::resource('/todo', 'TodoController')->names(['destroy' => 'todo.delete', 'index' => 'todo.index', 'edit' => 'todo.edit']);
    Route::put('/todo/{todo}/done', 'TodoController@markAsDone')->name('todo.done');
});
