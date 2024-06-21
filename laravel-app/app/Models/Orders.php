<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

/**
 * @property int $id
 * @property string $ticket_numer
 * @property string $order_sum
 * @property string $works_amount
 */

class Orders extends Model
{
    use HasFactory;

    protected $fillable = ['id' ,'ticket_numer', 'order_sum', 'works_amount'];

    public function addOrUpdate($data, $ticket_id)
    {
        $orderCheck = [
            'ticket_numer' => $data['ticketNumber']
        ];
        $orderTosave = [
            'order_sum' => $data['orderSum'],
            'works_amount' => $data['worksAmount']
        ];
        try {
            $saveOrder = self::updateOrCreate($orderCheck, $orderTosave);
            $saveOrder->save();
            return $saveOrder->id;
        } catch (QueryException $e) {
            return false;
        }
    }
}
