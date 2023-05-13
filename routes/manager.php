<?php

use Illuminate\Support\Facades\Route;
// use QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great
|
*/

Route::middleware(['auth', 'isManager'])->namespace('App\Http\Controllers')->name('manager.')->group(function () {
    Route::get('dashboard','ManagerController@dashboard')->name('dashboard');
    Route::get('profile', 'ManagerController@profile')->name('profile');
    Route::get('profile/{slug}/edit', 'ManagerController@editProfile')->name('profile.edit');
    Route::post('profile/{slug}/update', 'ManagerController@updateProfile')->name('profile.update');
    Route::match(['GET','POST'],'change/password', 'ManagerController@changePassword')->name('change.password');

    Route::get('contractors', 'ManagerController@contractors')->name('contractors.index');
    Route::get('contractors/{slug}/show', 'ManagerController@viewContractor')->name('contractors.view');

    Route::get('workers', 'ManagerController@workers')->name('workers.index');
    Route::get('workers/{slug}/show', 'ManagerController@viewWorker')->name('workers.view');
    
});
