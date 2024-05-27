<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('customers', function (Request $request) {
    return $request->customer();
})->middleware('auth:sanctum');

Route::prefix('api')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoice', InvoiceController::class);
});

Route::get('customersapi', [CustomerController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});


// //Participants route
// Route::prefix('participants')->group(function () {
//     Route::post('list', 'ParticipantsController@getRegistration');
//     Route::post('create', 'ParticipantsController@createRegistration');
//     Route::post('update', 'ParticipantsController@updateRegistration');
//     Route::post('delete','ParticipantsController@deleteRegistration');
// });

// //Tickets Route
// Route::prefix('tickets')->group(function () {
//     Route::post('create', 'TicketsController@createTicket');
//     Route::post('update', 'TicketsController@updateTicket');
//     Route::post('singleById', 'TicketsController@getTicket');
//     Route::post('all', 'TicketsController@getAllTicket');
//     Route::post('upload', 'TicketsController@uploadPostFile'); //post upload file
//     Route::post('download', 'TicketsController@getFileByUrl'); //download file
//     Route::post('queue', 'TicketsController@allPartisipantTickets'); //Participant data from queue_tickets then clear it
// });

// //Route for PartisipantEmulator
// Route::post('emulator/clients', 'ParticipantsEmulatorController@clientsCallback'); //recivie data from VS ADS
// Route::get('emulator/all', 'ParticipantsEmulatorController@getEmulatorTickets');   //show all wrote tickets
// Route::get('emulator/wroteAllTickets', 'ParticipantsEmulatorController@wroteAllTickets'); //recivie all Tickets from VS ADS


// Route::prefix('v1')->group(function(){
//     // paid tickets
//     Route::prefix('worklist')->group(function(){
//         Route::post('create', 'WorklistController@addOrUpdate'); // create paid tickets
//         Route::post('update', 'WorklistController@addOrUpdate'); // update paid tickets
//         Route::post('get', 'WorklistController@show'); // get paid tickets
//     });
//     Route::prefix('settings')->group(function(){
//         Route::post('create', 'SettingsController@createSetting'); // get paid tickets
//         Route::post('get', 'SettingsController@getSetting'); // get paid tickets
//     });
//     // messages
//     Route::prefix('tickets_messages')->group(function () {
//         Route::post('create', 'TicketsMessagesController@addOrUpdate'); // create ticket messages
//         Route::post('update', 'TicketsMessagesController@addOrUpdate'); // update ticket messages
//         Route::post('list', 'TicketsMessagesController@addOrUpdate'); // get once ticket messages
//         Route::post('changelist', 'TicketsMessagesController@getTicketsMessagesFromChangelist'); // get ticket message from changelist
//     });
// });

// //Route for Statistic
// Route::post('statistic/list', 'StatisticsController@getStatistic');

// //Route for test
// Route::post('test', 'ApiController@test');
// Route::get('mobile', 'ParticipantsEmulatorController@getTokenMobile');
