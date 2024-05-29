<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\AccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('customers', function (Request $request) {
//     return $request->customer();
// })->middleware('auth:sanctum');

Route::get('customers', [CustomerController::class, 'index']);


Route::post('register', [AccountController::class, 'create']);
Route::post('login', [AccountController::class, 'login']);

//Tickets Route
Route::prefix('tickets')->group(function () {
    Route::post('create', 'TicketController@createTicket');
    Route::post('update', 'TicketController@updateTicket');
    Route::post('singleById', 'TicketController@getTicket');
    Route::post('all', 'TicketController@getAllTicket');
    Route::post('upload', 'TicketController@uploadPostFile'); //post upload file
    Route::post('download', 'TicketController@getFileByUrl'); //download file
    Route::post('queue', 'TicketController@allPartisipantTickets'); //Participant data from queue_tickets then clear it
});

Route::prefix('v1')->group(function(){
    // paid tickets
    Route::prefix('worklist')->group(function(){
        Route::post('create', 'WorklistController@addOrUpdate'); // create paid tickets
        Route::post('update', 'WorklistController@addOrUpdate'); // update paid tickets
        Route::post('get', 'WorklistController@show'); // get paid tickets
    });
    Route::prefix('settings')->group(function(){
        Route::post('create', 'SettingsController@createSetting'); // get paid tickets
        Route::post('get', 'SettingsController@getSetting'); // get paid tickets
    });
    // messages
    Route::prefix('tickets_messages')->group(function () {
        Route::post('create', 'TicketsMessagesController@addOrUpdate'); // create ticket messages
        Route::post('update', 'TicketsMessagesController@addOrUpdate'); // update ticket messages
        Route::post('list', 'TicketsMessagesController@addOrUpdate'); // get once ticket messages
        Route::post('changelist', 'TicketsMessagesController@getTicketsMessagesFromChangelist'); // get ticket message from changelist
    });
});

