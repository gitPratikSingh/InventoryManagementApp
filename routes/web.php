<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'EquipmentController@index');
Route::get('/', 'EquipmentController@login');

/* Equipment */
Route::get('equipment/', 'EquipmentController@index');
Route::get('equipment/export-to-excel', 'EquipmentController@exportToExcel');
Route::post('equipment/datatable', 'EquipmentController@datatable');
Route::post('equipment/datatable/state', 'EquipmentController@datatableState');
Route::get('equipment/add', 'EquipmentController@addEditItem');
Route::get('equipment/edit/{id}', 'EquipmentController@addEditItem');
Route::get('equipment/{slug}', 'EquipmentController@index');
Route::post('equipment/save', 'EquipmentController@saveItem');
Route::post('equipment/change-status', 'EquipmentController@itemStatus');
Route::get('equipment/bulk-update/{slug}', 'EquipmentController@addEditItem');
Route::post('equipment/bulk-update-execute', 'EquipmentController@bulkUpdate');
Route::post('equipment/save-note', 'EquipmentController@insertNotes');

/* User */
Route::get('user/', 'UserController@index');
Route::post('user/datatable', 'UserController@datatable');
Route::get('user/add', 'UserController@addEditItem');
Route::get('user/edit/{id}', 'UserController@addEditItem');
Route::get('user/delete/{id}', 'UserController@destroy');
Route::post('user/save', 'UserController@saveItem');
Route::post('user/getUserData', 'UserController@getUserData');
Route::get('user/searchGroups', 'UserController@searchGroups');
Route::get('logout', 'UserController@logout');
Route::get('switch-unit/{id}', 'UserController@switchUnit');


/* Dashboard */
Route::get('dashboard', 'DashboardController@index');
Route::get('/under-development', 'DashboardController@underDev');

/* Settings */
Route::get('settings/codes', 'SettingsController@index');
Route::post('settings/domainsDatatable', 'SettingsController@domainsDatatable');
Route::post('settings/groupsDatatable', 'SettingsController@groupsDatatable');
Route::post('settings/makesDatatable', 'SettingsController@makesDatatable');
Route::post('settings/osDatatable', 'SettingsController@osDatatable');
Route::post('settings/buildingsDatatable', 'SettingsController@buildingsDatatable');
Route::post('settings/typesDatatable', 'SettingsController@typesDatatable');

Route::post('settings/codes/getData', 'SettingsController@getData');

Route::get('settings/codes/groups/edit/{id}', 'SettingsController@addEditItem');
Route::get('settings/codes/delete/groups/{id}', 'SettingsController@destroy');
Route::post('settings/codes/save', 'SettingsController@saveItem');


/* History */
Route::get('history/', 'HistoryController@index');
Route::post('history/datatable', 'HistoryController@datatable');



/* Services */
Route::get('service/lookup', 'ServiceController@lookup');
Route::post('service/store', 'ServiceController@store');
Route::get('service/store/processor', 'ServiceController@processor');
