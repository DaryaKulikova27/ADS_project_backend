<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'created_ticket_at',
        'title',
        'client_id',
        'status',
        'description',
        'executor_id',
        'is_paid',
        'start_work',
        'end_work',
        'address',
        'phone_client',
        'dispatcher_id'
    ];
}
