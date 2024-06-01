<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;

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
            'is_paid' => Arr::get($request, ('ticket.isPaid')) === null ? false : Arr::get($request, ('ticket.isPaid')),
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

        // $orders = Arr::get($request, ('additionalData.orders'));
        // if (!empty($orders)) {
        //     foreach ($orders as $order) {
        //         $ticket->additional_data()->updateOrCreate(
        //             ['key' => $key],
        //             ['value' => $value]
        //         );
        //     }
        // }

        //$this->parseOrders($request, $ticket->id, $client_id->client_id);

        return BaseController::sendResponse(["ticketNumber" => $ticket->ticket_number], 'Заявка создана!');
    }

    private static function parseOrders($request, $ticket_id, $client_id)
    {
      // проверяем присутсвие заказов в бд, если нет, сносим
      if(!empty(Arr::get($request, ('additional_data.orders')))) {
        try {
          $orders = Arr::get($request, ('additional_data.orders'));
          foreach ($orders as $order) {
            // проверяем присутсвие работ в бд, если нет, сносим
            foreach ($order['works'] as $workKey => $workValue) {
              Log::channel('worklist_info')->info('Start parsing worklist data', [$workValue['work_external_id'], $client_id]);
              $checkWork = Works::workExists($workValue['work_external_id'], $client_id);
              if($checkWork == false) {
                Works::addWorkFromIncommingTicket($workValue, $client_id);
              }
            }

            $saveOrders = new Order;
            $saveOrders = $saveOrders->addOrUpdate($order, $ticket_id);

            $saveWorksInOrders = new WorksInOrder;
            $saveWorksInOrders = $saveWorksInOrders->addOrUpdate($order, $saveOrders);
          }
        } catch (\Throwable $e) {
          Log::channel('worklist_error')->error('parseOrders', array(
            'message' => 'Произошла ошибка при создание или обновление:' . $e->getMessage(),
            'ticket_id' => $ticket_id,
            'IP' => request()->ip(),
            'divice' => request()->userAgent()
        ));
          return false;
        }

        return true;
      }
      return false;
    }


    public function getAllTickets(Request $request) {
        $userRole = User::where('token', $request->token)->first()->role;
        if ($userRole === 1) {
            $tickets = Ticket::where('client_id', User::where('token', $request->token)->first()->id)->get();
        } elseif ($userRole === 2) {
            $tickets = Ticket::where('executor_id', User::where('token', $request->token)->first()->id)->get();
        } else {
            $tickets = Ticket::all();
        }

        return BaseController::sendResponse($tickets, 'Заявки получены!');
    }

    public function appointExecutor(Request $request) {
        $ticket = Ticket::where('ticket_number', Arr::get($request, ('ticketNumber')))->first();
        $ticket->executor_id = User::where('executor_id', Arr::get($request, ('executorId')))->first()->id;
        $ticket->save();
        return BaseController::sendResponse(["ticketNumber" => $ticket->ticket_number], 'Исполнитель назначен!');
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
