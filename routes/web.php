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
        Route::get('/universe/{universe_id}/edit', 'App\Http\Controllers\UniverseController@edit')->name('universe.edit');
        Route::post('/universe/{universe_id}/delete', 'App\Http\Controllers\UniverseController@destroy')->name('universe.delete');
        Route::post('/universe/store', 'App\Http\Controllers\UniverseController@store')->name('universe.store');
   //Book
        Route::get('/universe/{universe_id}/books', 'App\Http\Controllers\BookController@index')->name('books.index');
        Route::get('/universe/{universe_id}/books/create', 'App\Http\Controllers\BookController@create')->name('books.create');
        Route::get('/universe/{universe_id}/books/{book_id}/edit', 'App\Http\Controllers\BookController@edit')->name('books.edit');
        Route::post('/universe/{universe_id}/books/{book_id}/update', 'App\Http\Controllers\BookController@update')->name('books.update');
        Route::get('/universe/{universe_id}/books/{book_id}/show', 'App\Http\Controllers\BookController@show')->name('books.show');
        Route::post('/universe/{universe_id}/books/{book_id}/publish', 'App\Http\Controllers\BookController@publish')->name('books.publish');
        Route::post('/universe/{universe_id}/books/{book_id}/delete', 'App\Http\Controllers\BookController@destroy')->name('books.delete');
        Route::post('/universe/{universe_id}/books/store', 'App\Http\Controllers\BookController@store')->name('books.store');
    //Issues
        Route::get('/universe/{universe_id}/books/{book_id}/issues', 'App\Http\Controllers\IssuesController@index')->name('issues.index');
        Route::get('/universe/{universe_id}/books/{book_id}/issues/create', 'App\Http\Controllers\IssuesController@create')->name('issues.create');
        Route::get('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/edit', 'App\Http\Controllers\IssuesController@edit')->name('issues.edit');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/update', 'App\Http\Controllers\IssuesController@update')->name('issues.update');
        Route::get('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/show', 'App\Http\Controllers\IssuesController@show')->name('issues.show');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/publish', 'App\Http\Controllers\IssuesController@publish')->name('issues.publish');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/delete', 'App\Http\Controllers\IssuesController@destroy')->name('issues.delete');
        Route::post('/universe/{universe_id}/books/{book_id}/issues/store', 'App\Http\Controllers\IssuesController@store')->name('issues.store');

    //Issue Page
    Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/pages/{page_id}/pageIsVisible', 'App\Http\Controllers\IssuePagesController@pageIsVisible')->name('issue_pages.pageIsVisible');
    Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/pages/{page_id}/update', 'App\Http\Controllers\IssuePagesController@update')->name('issue_pages.update');
    Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/pages/{page_id}/delete', 'App\Http\Controllers\IssuePagesController@destroy')->name('issue_pages.delete');
    Route::post('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/pages/{page_id}/swapPageNumber', 'App\Http\Controllers\IssuePagesController@swapPageNumber')->name('issue_pages.swapPageNumber');
    Route::get('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/pages/{page_id?}/editPage', 'App\Http\Controllers\IssuePagesController@editPage')->name('issue_pages.editPage');
    Route::get('/universe/{universe_id}/books/{book_id}/issues/{issue_id}/addPage', 'App\Http\Controllers\IssuePagesController@addPage')->name('issue_pages.addPage');

        //Uploader
            Route::get('/uploader', 'App\Http\Controllers\BookController@index')->name('admin.uploader');

    //Events
    Route::get('/events', 'App\Http\Controllers\EventsController@index')->name('events.index');
    Route::get('/events/create', 'App\Http\Controllers\EventsController@create')->name('events.create');
    Route::get('/events/{event_id}}/edit', 'App\Http\Controllers\EventsController@edit')->name('events.edit');
    Route::get('/events/store', 'App\Http\Controllers\EventsController@store')->name('events.store');
    Route::post('/events/update', 'App\Http\Controllers\EventsController@update')->name('events.update');
    Route::get('/events/show', 'App\Http\Controllers\EventsController@show')->name('events.show');
    Route::post('/events/{event_id}/publish', 'App\Http\Controllers\EventsController@publish')->name('events.publish');
    Route::post('/events/{event_id}/delete', 'App\Http\Controllers\EventsController@destroy')->name('events.delete');

        // Event Registrations
        Route::get('/events/{event_id}/registrations/index', 'App\Http\Controllers\EventRegistrationsController@index')->name('events.registrations.index');
        Route::get('/events/{event_id}/registrations/{registration_id}/show', 'App\Http\Controllers\EventRegistrationsController@show')->name('events.registrations.show');
        Route::get('/events/{event_id}/registrations/create', 'App\Http\Controllers\EventRegistrationsController@create')->name('events.registrations.create');
        Route::get('/events/{event_id}/registrations/{registration_id}/edit', 'App\Http\Controllers\EventRegistrationsController@edit')->name('events.registrations.edit');
        Route::post('/events/{event_id}/registrations/{registration_id}/update', 'App\Http\Controllers\EventRegistrationsController@update')->name('events.registrations.update');
        Route::post('/events/{event_id}/registrations/store', 'App\Http\Controllers\EventRegistrationsController@store')->name('events.registrations.store');
        Route::post('/events/{event_id}/registrations/{registration_id}/delete', 'App\Http\Controllers\EventRegistrationsController@destroy')->name('events.registrations.delete');
        Route::post('/events/{event_id}/registrations/{registration_id}/publish', 'App\Http\Controllers\EventRegistrationsController@publish')->name('events.registrations.publish');
        
    //Blaze Tokens
    Route::get('/tokens/dashboard', 'App\Http\Controllers\BlazeTokensController@dashboard')->name('tokens.dashboard');
    Route::get('/tokens/tiers/index', 'App\Http\Controllers\BlazeTokensController@index')->name('tokens.tiers.index');
    Route::get('/tokens/tiers/create', 'App\Http\Controllers\BlazeTokensController@create')->name('tokens.tiers.create');
    Route::get('/tokens/tiers/{token_tier_id}/show', 'App\Http\Controllers\BlazeTokensController@show')->name('tokens.tiers.show');
    Route::post('/tokens/tiers/submit', 'App\Http\Controllers\BlazeTokensController@submit')->name('tokens.tiers.submit');
    Route::post('/tokens/tiers/{token_tier_id}/update', 'App\Http\Controllers\BlazeTokensController@update')->name('tokens.update');

});
