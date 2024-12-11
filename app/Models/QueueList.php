<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueList extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in_by',
        'client_id',
        'user_id',
    ];
}
