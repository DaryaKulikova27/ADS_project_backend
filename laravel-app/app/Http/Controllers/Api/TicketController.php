<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Works;
use App\Models\Orders;
use App\Models\WorksInOrder;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class TicketController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOrUpdateTicket(Request $request)
    {
        $userId = User::where('token', $request->token)->first()->id;

        $ticket = Ticket::updateOrCreate(
            ['ticket_number' => Arr::get($request, ('ticket.ticketNumber'))],
            ['dispatcher_id' => 1, 
            'client_id' => $userId,
            'executor_id' => empty(Arr::get($request, ('ticket.executorId'))) ? null : Arr::get($request, ('ticket.executorId')),
            'is_paid' => Arr::get($request, ('ticket.isPaid')) === null ? false : $this->getIsPaidValue($request),
            'description' => Arr::get($request, ('ticket.description')),
            'start_work' => empty(Arr::get($request, ('ticket.startWork'))) ? null : Arr::get($request, ('ticket.startWork')),
            'end_work' => empty(Arr::get($request, ('ticket.endWork'))) ? null : Arr::get($request, ('ticket.endWork')),
            'address' => Arr::get($request, ('ticket.address')),
            'title' => Arr::get($request, ('ticket.title')),
            'phone_client' => empty(Arr::get($request, ('ticket.phoneClient'))) ? null : Arr::get($request, ('ticket.phoneClient')),
            'status' => empty(Arr::get($request, ('ticket.status'))) ? 1 : Arr::get($request, ('ticket.status')),
            'created_ticket_at' => Arr::get($request, ('ticket.createdAt'))
            ]
        );
        $ticket->save();

        $this->parseOrders($request, $ticket->ticket_number);

        return BaseController::sendResponse(["ticketNumber" => $ticket->ticket_number], 'Заявка создана!');
    }

    private function getIsPaidValue(Request $request) {
        if (Arr::get($request, ('ticket.isPaid')) == true) return 1;
        return 0;
    }

    private static function parseOrders($request, $ticket_id)
    {
      if(!empty(Arr::get($request, ('additionalData.orders')))) {
        try {
          $orders = Arr::get($request, ('additionalData.orders'));

          foreach ($orders as $order) {
            $saveOrders = new Orders;
            $saveOrders = $saveOrders->addOrUpdate($order, $ticket_id);

            $saveWorksInOrders = new WorksInOrder;
            $saveWorksInOrders = $saveWorksInOrders->addOrUpdate($order, $saveOrders);
          }
        } catch (\Throwable $e) {
          return false;
        }

        return true;
      }
      return false;
    }

    private function getAdditinalData() {
        
    }


    public function getAllTickets(Request $request) {
        $userRole = User::where('token', $request->token)->first()->role;
        $result = [];
        $additionalData = [];

        if ($userRole === 1) {
            $tickets = Ticket::where('client_id', User::where('token', $request->token)->first()->id)->get();
        } elseif ($userRole === 2) {
            $tickets = Ticket::where('executor_id', User::where('token', $request->token)->first()->id)->get();
        } else {
            $tickets = Ticket::all();
        }

        foreach ($tickets as $ticket) {
            $currentTicketData = [];
            $currentTicketData = [
                'ticketNumber' => $ticket->ticket_number,
                'title' => $ticket->title,
                'description' => $ticket->description,
                'address' => $ticket->address,
                'phoneClient' => $ticket->phone_client,
                'isPaid' => $ticket->is_paid == 1 ? true : false,
                'status' => $ticket->status,
                'createdAt' => Helper::apiTime($ticket->created_ticket_at),
                'startWork' => Helper::apiTime($ticket->start_work),
                'endWork' => Helper::apiTime($ticket->end_work),
                'executorId' => $ticket->executor_id,
                'clientId' => $ticket->client_id,
                'dispatcherId' => $ticket->dispatcher_id,
                'executor_name' => $ticket->executor_id != null ? User::where('id', $ticket->executor_id)->first()->name : null,
                'client_name' => $ticket->client_id != null ? User::where('id', $ticket->client_id)->first()->name : null
            ];

            $ordersData = Helper::fillOrdersAdditionalData($ticket->id, $currentTicketData['ticketNumber']);
            if($ordersData !== false){
                $additionalData['orders'][] = $ordersData;
            }

            $result['tickets'][] = $currentTicketData;
        }

        if (empty($result)) {
            $result = (object)$result;
        }

        return BaseController::sendResponse($result, [], $additionalData);
    }

    public function appointExecutor(Request $request) {
        $ticket = Ticket::where('ticket_number', Arr::get($request, ('ticketNumber')))->first();
        $ticket->executor_id = User::where('executor_id', Arr::get($request, ('executorId')))->first()->id;
        $ticket->status = 2;
        $ticket->save();
        return BaseController::sendResponse(["ticketNumber" => $ticket->ticket_number], 'Исполнитель назначен!');
    }

    public function getAllExecutors(Request $request) {
        $executors = User::where('role', 2)->get();
        $result = [];

        foreach ($executors as $executor) {
            $currentExecutorData = [];
            $currentExecutorData = [
                'executor_id' => $executor->executor_id,
                'name' => $executor->name
            ];

            $result['executors'][] = $currentExecutorData;
        }

        if (empty($result)) {
            $result = (object)$result;
        }

        return BaseController::sendResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
