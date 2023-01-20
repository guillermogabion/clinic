<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::group(['prefix' => '/v1'], function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('new-patient', [UserController::class, 'store']);
});
Route::group(['prefix' => '/v1', 'middleware' => ['auth:admin-api']], function () {

    Route::get('self', 'UserController@self');
    Route::get('user', 'UserController@index');
    Route::get('index-event', [EventController::class, 'index']);
    Route::get('user/pagination', [UserController::class, 'pagination']);
    Route::get('/fit', 'ParticipantController@index');

    Route::post('participant', [ParticipantController::class, 'store']);
    Route::post('participant/{id}', [ParticipantController::class, 'update']);
    Route::delete('participant/{id}', [ParticipantController::class, 'destroy']);
    Route::post('search-participant', [ParticipantController::class, 'search']);
    Route::get('participants/pagination', [ParticipantController::class, 'pagination']);
    Route::get('participants/get', [ParticipantController::class, 'index']);

    Route::post('event', [EventController::class, 'store']);
    Route::post('event/{id}', [EventController::class, 'update']);
    Route::delete('event/{id}', [EventController::class, 'destroy']);
    Route::get('events/pagination', [EventController::class, 'pagination']);

    Route::post('add-appointment', [EventController::class, 'add_appointment']);
    Route::put('update-status/{id}', [EventController::class, 'update_status']);


    // item 
    Route::get('items/pagination', [ItemController::class, 'pagination']);
    Route::post('items-search', [ItemController::class, 'search']);
    Route::post('add-item', [ItemController::class, 'store']);

    Route::get('get', [RecordController::class, 'get']);

    // dashboard 

    Route::get('count_appointment', [EventController::class, 'count_all']);
    Route::get('count_appointment_today', [EventController::class, 'count_today']);
    Route::get('count_item', [ItemController::class, 'count_all']);

    Route::get('get_all_services', [ServiceController::class, 'get_all']);
    Route::get('get_all_reserve', [ServiceController::class, 'get_reserve']);

    // service 

    Route::get('get-service', [ServiceController::class, 'get_services']);

    // Dashboard 
    Route::post('monthly-stats', 'DashboardController@charts');


    Route::get('get-history', 'EventController@get_all_history');

    Route::post('search-service', [ServiceController::class, 'search_service']);

    Route::get('get-record/{id}', [UserController::class, 'get_record']);
});
