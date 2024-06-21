<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\WorksController;
use App\Http\Middleware\CheckTokenUpdate;

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

Route::get('customers', [CustomerController::class, 'index']);

// Авторизация
Route::post('register', [AccountController::class, 'create'])->withoutMiddleware([CheckTokenUpdate::class]);
Route::post('signIn', [AccountController::class, 'signIn'])->withoutMiddleware([CheckTokenUpdate::class]);
Route::post('logout', [AccountController::class, 'logout'])->withoutMiddleware([CheckTokenUpdate::class]);

//Tickets Route

Route::middleware([CheckTokenUpdate::class])->group(function() {
    Route::prefix('tickets')->group(function () {
        Route::post('create', [TicketController::class, 'createOrUpdateTicket']);
        Route::post('update', [TicketController::class, 'createOrUpdateTicket']);
        Route::post('all', [TicketController::class, 'getAllTickets']);
        Route::post('appointExecutor', [TicketController::class, 'appointExecutor']);
        Route::post('getAllExecutors', [TicketController::class, 'getAllExecutors']);
        Route::post('queue', 'TicketController@allPartisipantTickets'); //Participant data from queue_tickets then clear it
    });
    
    // Worklist Root
    Route::prefix('worklist')->group(function() {
        Route::post('get', [WorksController::class, 'index']);
    });
});




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

