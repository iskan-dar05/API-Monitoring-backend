<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

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

    public function post(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
