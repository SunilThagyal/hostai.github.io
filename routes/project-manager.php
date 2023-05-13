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
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'isProjectManager'])->namespace('App\Http\Controllers')->name('project-manager.')->group(function () {

    // Route::get('qrcode/{slug}','QrCodeController@qrCode')->name('qrcode');

    Route::get('dashboard','AdminController@dashboard')->name('dashboard');
    Route::get('show', 'AdminController@show')->name('show.admin');
    Route::get('{slug}/edit', 'AdminController@edit')->name('edit.admin');
    Route::post('{slug}/update', 'AdminController@update')->name('update.admin');

    Route::get('architect/site', 'AjaxController@getSite')->name('admin.site');
    Route::get('architect/contractor', 'AjaxController@architectContractor')->name('admin.contractor');

    //architect
    // Route::get('architects', 'ArchitectController@index')->name('architects');
    // Route::get('add/architect', 'ArchitectController@create')->name('add.architect');
    // Route::post('architect/store', 'ArchitectController@store')->name('store.architect');
    // Route::get('architect/{slug}/show', 'ArchitectController@show')->name('show.architect');
    // Route::get('architect/{slug}/edit', 'ArchitectController@edit')->name('edit.architect');
    // Route::post('architect/{slug}/update', 'ArchitectController@update')->name('update.architect');
    // Route::get('architect/{slug}/delete', 'ArchitectController@destroy')->name('delete.architect');

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

    //worker
    Route::get('workers', 'WorkerController@index')->name('workers');
    Route::get('workers/create', 'WorkerController@create')->name('add.worker');
    Route::post('workers/store', 'WorkerController@store')->name('store.worker');
    Route::get('workers/{slug}/show', 'WorkerController@show')->name('show.worker');
    Route::get('workers/{slug}/edit', 'WorkerController@edit')->name('edit.worker');
    Route::post('workers/{slug}/update', 'WorkerController@update')->name('update.worker');
    Route::get('workers/{slug}/delete', 'WorkerController@destroy')->name('delete.worker');
    Route::get('workers/csv', 'WorkerController@uploadcsv')->name('csv.worker');
    Route::post('workers/csv', 'WorkerController@import')->name('csvstore.worker');
    Route::get('remove/{id}document', 'WorkerController@DocsRemove')->name('remove.document');
    //  worker accept and reject
    Route::get('workers/{slug}/accept', 'WorkerController@accept')->name('accept.worker');
    Route::post('workers/{slug}/reject', 'WorkerController@reject')->name('reject.worker');




    // mangers
    Route::get('{type}', 'ManagerController@index')->name('managers.index')->where('type','(manager|main-manager)');
    Route::get('{type}/create', 'ManagerController@create')->name('managers.create')->where('type','(manager|main-manager)');
    Route::post('{type}/store', 'ManagerController@store')->name('managers.store')->where('type','(manager|main-manager)');
    Route::get('{type}/{manager}/view', 'ManagerController@view')->name('managers.view')->where('type','(manager|main-manager)');
    Route::get('{type}/{manager}/edit', 'ManagerController@edit')->name('managers.edit')->where('type','(manager|main-manager)');
    Route::post('{type}/{manager}/update', 'ManagerController@update')->name('managers.update')->where('type','(manager|main-manager)');
    Route::get('{type}/{manager}/destroy', 'ManagerController@destroy')->name('managers.destroy')->where('type','(manager|main-manager)');
    
});
