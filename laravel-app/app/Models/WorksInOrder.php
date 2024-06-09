<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Works;
use Illuminate\Database\QueryException;

/**
 * @property int $id
 * @property int $order_id
 * @property string $work_id
 * @property string $price
 * @property string $amount
 */

class WorksInOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'work_id', 'price', 'amount'];

    public function addOrUpdate($data, $order_id)
    {   
        echo($order_id . "\n");
        dd($data);
        $worksInOrder = $data['works'];
        try {
            foreach ($worksInOrder as $works) {
                $work_id = Works::where('work_external_id', $works['work_external_id'])->first()->id;
                $checkWork = [
                    'work_id' => $work_id,
                    'order_id' => $order_id
                ];
    
                $saveWork = [
                    'price' => $works['price'],
                    'amount' => $works['amount']
                ];
                $saveWorkInOrder = self::updateOrCreate($checkWork, $saveWork);
                $saveWorkInOrder->save();
            }

            return true;
        } catch (QueryException $e) {
            return false;
        }
    }



}
