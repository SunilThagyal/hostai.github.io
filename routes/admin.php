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

Route::get('architect/site', 'App\Http\Controllers\AjaxController@getSite')->name('admin.site');
    Route::get('architect/contractor', 'App\Http\Controllers\AjaxController@architectContractor')->name('admin.contractor');
Route::middleware(['auth','isAdmin'])->namespace('App\Http\Controllers')->name('admin.')->group(function () {

    Route::get('qrcode/{slug}','QrCodeController@qrCode')->name('qrcode');
    Route::get('qrcodeprint/{slug}','QrCodeController@qrCodePrint')->name('qrcodeprint');

    Route::match(['get', 'post'],'dashboard','AdminController@dashboard')->name('dashboard');
    Route::get('show', 'AdminController@show')->name('show.admin');
    Route::get('{slug}/edit', 'AdminController@edit')->name('edit.admin');
    Route::post('{slug}/update', 'AdminController@update')->name('update.admin');



    //architect
    Route::get('architects', 'ArchitectController@index')->name('architects');
    Route::get('add/architect', 'ArchitectController@create')->name('add.architect');
    Route::post('architect/store', 'ArchitectController@store')->name('store.architect');
    Route::get('architect/{slug}/show', 'ArchitectController@show')->name('show.architect');
    Route::get('architect/{slug}/edit', 'ArchitectController@edit')->name('edit.architect');
    Route::post('architect/{slug}/update', 'ArchitectController@update')->name('update.architect');
    Route::get('architect/{slug}/delete', 'ArchitectController@destroy')->name('delete.architect');

    //contractor
    Route::post('reject/document/{doc_id}', 'ContractorController@rejectdocument')->name('reject.document');
    Route::get('approve/document/{doc_id}', 'ContractorController@approvedocument')->name('approve.document');
    Route::post('contractor/document/delete', 'ContractorController@destroyDocument')->name('contractor.delete.document');

    Route::get('approve/contractors', 'ContractorController@approveindex')->name('approve.contractors');
    Route::get('unapprove/contractors', 'ContractorController@unverified')->name('unapprove.contractors');
    Route::get('show/{slug}/details', 'ContractorController@showdetails')->name('contractors.details');
    //
    Route::get('contractors', 'ContractorController@index')->name('contractors');
    Route::get('add/contractor', 'ContractorController@create')->name('add.contractor');
    Route::post('contractor/store', 'ContractorController@store')->name('store.contractor');
    Route::get('contractor/{slug}/show', 'ContractorController@show')->name('show.contractor');
    Route::get('contractor/{slug}/edit', 'ContractorController@edit')->name('edit.contractor');
    Route::post('contractor/{slug}/update', 'ContractorController@update')->name('update.contractor');
    Route::get('contractor/{slug}/delete', 'ContractorController@destroy')->name('delete.contractor');



    //worker
    Route::get('workers', 'WorkerController@index')->name('workers');
    Route::get('add/worker', 'WorkerController@create')->name('add.worker');
    Route::post('worker/store', 'WorkerController@store')->name('store.worker');
    Route::get('worker/{slug}/show', 'WorkerController@show')->name('show.worker');
    // Route::get('worker/{slug}/edit', 'WorkerController@edit')->name('edit.worker');
    // Route::post('worker/{slug}/update', 'WorkerController@update')->name('update.worker');
    Route::get('worker/{slug}/delete', 'WorkerController@destroy')->name('delete.worker');
    Route::get('worker/csv', 'WorkerController@uploadcsv')->name('csv.worker');
    Route::post('add/worker/csv', 'WorkerController@import')->name('csvstore.worker');
    Route::get('remove/{id}document', 'WorkerController@DocsRemove')->name('remove.document');


    //site
    Route::get('sites', 'SiteManagementController@index')->name('sites');
    Route::get('add/site', 'SiteManagementController@create')->name('add.site');
    Route::post('site/store', 'SiteManagementController@store')->name('store.site');
    Route::get('site/{slug}/edit', 'SiteManagementController@edit')->name('edit.site');
    Route::post('site/{slug}/update', 'SiteManagementController@update')->name('update.site');
    Route::get('site/{slug}/delete', 'SiteManagementController@destroy')->name('delete.site');

});
