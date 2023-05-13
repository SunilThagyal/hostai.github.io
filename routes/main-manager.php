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

Route::middleware(['auth', 'isEditableManager'])->namespace('App\Http\Controllers')->name('main-manager.')->group(function () {
    Route::get('dashboard','AdminController@dashboard')->name('dashboard');
        Route::get('show', 'AdminController@show')->name('show.admin');
    Route::get('{slug}/edit', 'AdminController@edit')->name('edit.admin');
    Route::post('{slug}/update', 'AdminController@update')->name('update.admin');
    Route::match(['GET','POST'],'change/password', 'ManagerController@changePassword')->name('change.password');

    // Route::get('contractors', 'ManagerController@contractors')->name('contractors.index');
    // Route::get('contractors/{slug}/show', 'ManagerController@viewContractor')->name('contractors.view');
    // CONTRACTORS route
    //contractor
    Route::get('show/{slug}/details', 'ContractorController@showdetails')->name('contractors.details');
    Route::get('approve/contractors', 'ContractorController@approveindex')->name('approve.contractors');
    Route::get('unapprove/contractors', 'ContractorController@unverified')->name('unapprove.contractors');

    //contractor
    Route::post('reject/document/{doc_id}', 'ContractorController@rejectdocument')->name('reject.document');
    Route::get('approve/document/{doc_id}', 'ContractorController@approvedocument')->name('approve.document');
    Route::post('contractor/document/delete', 'ContractorController@destroyDocument')->name('contractor.delete.document');

    //
    Route::get('contractors', 'ContractorController@index')->name('contractors');
    Route::get('contractors/create', 'ContractorController@create')->name('add.contractor');
    Route::post('contractors/store', 'ContractorController@store')->name('store.contractor');
    Route::get('contractors/{slug}/show', 'ContractorController@show')->name('show.contractor');
    Route::get('contractors/{slug}/edit', 'ContractorController@edit')->name('edit.contractor');
    Route::post('contractors/{slug}/update', 'ContractorController@update')->name('update.contractor');
    Route::get('contractors/{slug}/delete', 'ContractorController@destroy')->name('delete.contractor');


    Route::get('workers', 'WorkerController@index')->name('workers');
    Route::get('add/worker', 'WorkerController@create')->name('add.worker');
    Route::post('worker/store', 'WorkerController@store')->name('store.worker');
    Route::get('worker/{slug}/show', 'WorkerController@show')->name('show.worker');
    Route::get('worker/{slug}/edit', 'WorkerController@edit')->name('edit.worker');
    Route::post('worker/{slug}/update', 'WorkerController@update')->name('update.worker');
    Route::get('worker/{slug}/delete', 'WorkerController@destroy')->name('delete.worker');
    Route::get('worker/csv', 'WorkerController@uploadcsv')->name('csv.worker');
    Route::post('add/worker/csv', 'WorkerController@import')->name('csvstore.worker');
    Route::post('update/document', 'WorkerController@updatedocs')->name('update.document');
    Route::post('worker/document/delete', 'WorkerController@deleteDocument')->name('delete.document');
    Route::get('architect/site', 'AjaxController@getSite')->name('admin.site');
    //  worker accept and reject
    Route::get('workers/{slug}/accept', 'WorkerController@accept')->name('accept.worker');
    Route::post('workers/{slug}/reject', 'WorkerController@reject')->name('reject.worker');
});
