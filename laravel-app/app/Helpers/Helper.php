<?php

namespace App\Helpers;

use App\Models\Ticket;

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
}
