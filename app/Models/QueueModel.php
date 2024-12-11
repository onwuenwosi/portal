<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueModel extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'surname',
        // 'othername',
        // 'DateOfBirth',
        // 'gender',
        // 'phone',
        // 'email',
        'check_in_by',
        'user_id',
        // 'policynumber',
        // 'StartDate',
        // 'EndDate',
        'client_id',
        // 'clienttype',
        // 'plantype',
        // 'policytype',
        // 'enrolleetype',
    ];
}