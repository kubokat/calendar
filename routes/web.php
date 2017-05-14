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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/events', 'MeetingCalendar@index');
Route::get('/events/create', 'MeetingCalendar@create');
Route::get('/events/delete', 'MeetingCalendar@delete');
Route::get('/events/resize', 'MeetingCalendar@resize');
Route::get('/events/edit', 'MeetingCalendar@edit');

Route::post('invite', 'InviteController@send');
Route::get('auth/invite-only', 'InviteController@invitesonly')->name('invitesonly');
