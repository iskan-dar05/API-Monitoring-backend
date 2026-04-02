<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasFactory;

class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'url',
        'headers',
        'body',
        'response',
        'status',
        'duration',
        'type',
        'request_id'
    ];
}
