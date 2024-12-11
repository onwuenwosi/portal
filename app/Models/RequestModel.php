<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'Diagnosis',
        'Procedure',
        'Qty',
        'user_id',
        'comment',
        'client_id', //nullable
        'user', //nullable
        'UnitPrice', //nullable
        'Total', //nullable
        'Remark', //nullable default---Pending
        'HMO_comment', //nullable default---blank

    ];

    protected $casts = [
        'Qty' => 'integer',
        'UnitPrice' => 'decimal:2',
        'Total' => 'decimal:2',
    ];
}