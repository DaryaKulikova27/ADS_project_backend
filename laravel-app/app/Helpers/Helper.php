<?php

namespace App\Helpers;

use App\Models\Ticket;
use App\Models\Orders;
use App\Models\WorksInOrder;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


class Helper
{

    // dateTime view like 2021-05-01T00:00:00
    public static function apiTime($dateTime){
      switch ($dateTime) {
        case NULL:
          return '';
          break;

        default:
          $apitime = Carbon::parse($dateTime)->format('Y-m-d\TH:i:s');
          return $apitime;
          break;
      }
    }
    // get current date time
    public static function currentTime(){
      $time = Carbon::now()->timezone('Europe/Moscow');
      return $time;
    }
    // generate random ticket_number
    public static function generateTicketNumber($participant){
      $ticket_number = '';

      while (empty($ticket_number)) {
        $new_ticket_number = $participant.Str::random($strlentgh = 5);
        $ticket_number_exists = Ticket::where('ticket_number', $new_ticket_number)->exists();

        if (!$ticket_number_exists) {
          $ticket_number = $new_ticket_number;
        }
      }
      return $ticket_number;
    }

    /**
     * fillOrdersAdditionalData - заполняем данными доп дату инфой о заказе если она есть
     *
     * @param  mixed $ticket_id - ид тикета
     * @param  mixed $link - ссылка на тикет в заказе
     * @param  mixed $ticket_number - номер тикета
     * @return collection
     */
    public static function fillOrdersAdditionalData($ticket_id, $ticket_number)
    {
      if(Orders::where('ticket_numer', $ticket_number)->doesntExist()){
        return false;
      }

      $getOrders = Orders::where('ticket_numer', $ticket_number)->get();

      $result = [];
      foreach($getOrders as $order){

        $worksInOrders = WorksInOrder::where('order_id', $order->id)
        ->leftJoin('works', 'works.id', '=', 'works_in_orders.work_id')
        ->distinct()
        ->get([
          'works.work_external_id',
          'works_in_orders.price',
          'works.name',
          'works_in_orders.amount'
        ]);

        // $order->makeHidden(['id', 'ticket_id as t_id']);
        Arr::set($order, 'ticket_id', $ticket_number);
        Arr::add($order, 'works', $worksInOrders);

        $result = $order;
      }

      return $result;
    }

}
