<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Universe
        Route::get('/universe', 'App\Http\Controllers\UniverseController@index')->name('universe.index');
        Route::get('/universe/create', 'App\Http\Controllers\UniverseController@create')->name('universe.create');
        Route::post('/universe/{universe_id}/update', 'App\Http\Controllers\UniverseController@update')->name('universe.update');
        Route::get('/universe/{universe_id}/show', 'App\Http\Controllers\UniverseController@show')->name('universe.show');
        Route::post('/universe/{universe_id}/publish', 'App\Http\Controllers\UniverseController@publish')->name('universe.publish');
        Route::post('/universe/{universe_id}/delete', 'App\Http\Controllers\UniverseController@delete')->name('universe.delete');
        Route::post('/universe/store', 'App\Http\Controllers\UniverseController@store')->name('universe.store');
   //Book
        Route::get('/universe/{universe_id}/books', 'App\Http\Controllers\BookController@index')->name('books.index');
        Route::get('/universe/{universe_id}/books/create', 'App\Http\Controllers\BookController@create')->name('books.create');
        Route::post('/universe/{universe_id}/books/{book_id}/update', 'App\Http\Controllers\BookController@update')->name('books.update');
        Route::get('/universe/{universe_id}/books/{book_id}/show', 'App\Http\Controllers\BookController@show')->name('books.show');
        Route::post('/universe/{universe_id}/books/{book_id}/publish', 'App\Http\Controllers\BookController@publish')->name('books.publish');
        Route::post('/universe/{universe_id}/books/{book_id}/delete', 'App\Http\Controllers\BookController@delete')->name('books.delete');
        Route::post('/universe/{universe_id}/books/store', 'App\Http\Controllers\BookController@store')->name('books.store');
    //Issues
        Route::get('/universe/{universe_id}/books/{book_id}/issues', 'App\Http\Controllers\IssuesController@index')->name('issues.index');
        Route::get('/universe/{universe_id}/books/{book_id}/issues/create', 'App\Http\Controllers\IssuesController@create')->name('issues.create');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/update', 'App\Http\Controllers\IssuesController@update')->name('issues.update');
        Route::get('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/show', 'App\Http\Controllers\IssuesController@show')->name('issues.show');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/publish', 'App\Http\Controllers\IssuesController@publish')->name('issues.publish');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/delete', 'App\Http\Controllers\IssuesController@delete')->name('issues.delete');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/store', 'App\Http\Controllers\IssuesController@store')->name('issues.store');

        //Uploader
            Route::get('/uploader', 'App\Http\Controllers\BookController@index')->name('admin.uploader');

});
