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

Route::middleware(['auth', 'isContractor'])->namespace('App\Http\Controllers')->name('subcontractor.')->group(function () {
    Route::get('dashboard','AdminController@dashboard')->name('dashboard');
    Route::get('show', 'AdminController@show')->name('show.admin');
    Route::get('{slug}/edit', 'AdminController@edit')->name('edit.admin');
    Route::post('{slug}/update', 'AdminController@update')->name('update.admin');
    Route::post('{slug}/documents/upload', 'ContractorController@documentsupload')->name('documents.upload');
    Route::get('{id}/documents/delete', 'ContractorController@deleteDocument')->name('document.delete');
    Route::get('{user_id}/documents/submitted', 'ContractorController@submitdocument')->name('document.submit');

    Route::post('{docs_id}/documents/reupload', 'ContractorController@ReUploadDocument')->name('document.reupload');
    Route::get('architect/site', 'AjaxController@getSite')->name('admin.site');
    Route::get('architect/contractor', 'AjaxController@architectContractor')->name('admin.contractor');

    //worker
    Route::middleware(['status'])->group(function () {
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
    });
    // uploaded documents
    Route::get('{slug}/uploaded/documents', 'ContractorController@uploadedDocuments')->name('uploaded.documents');
    Route::post('{docs_id}/expired/documents/reupload', 'ContractorController@ReUploadExpiredDocument')->name('document.reupload.expired');



});
