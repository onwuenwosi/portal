<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class claimModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'user_id',
        'request_id',
        'policynumber',
        'Remark',
        'status'
    ];
}