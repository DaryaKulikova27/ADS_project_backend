<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_external_id',
        'name',
        'price',
        'parent',
        'is_folder'
    ];
}
