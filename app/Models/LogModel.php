<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    use HasFactory;

    protected $table = 'log';

    protected $fillable = [
        'endpoint',
        'method',
        'request_body',
        'response_body',
        'status_code',
        'user_id'
    ];
}
