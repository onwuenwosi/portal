<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParequestModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'Diagnosis',
        'Procedure',
        'Qty',
        'comment',
        'batch_id',
        'code',
        'user_id',
        'approvedBy',
        'client_id', //nullable
        'user', //nullable
        'UnitPrice', //nullable
        'Total', //nullable
        'Remark', //nullable default---Pending
        'HMO_comment', //nullable default---blank

    ];
    public $timestamps = true;

    protected $casts = [
        'Qty' => 'integer',
        'UnitPrice' => 'decimal:2',
        'Total' => 'decimal:2',
    ];
}
