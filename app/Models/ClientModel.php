<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class ClientModel extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'surname',
        'othername',
        'gender',
        'DateOfBirth',
        'phone',
        'email',
        'passport',
        'policynumber',
        'status',
        'StartDate',
        'EndDate',
        'clienttype',
        'plantype',
        'policytype',
        'enrolleetype',
        'user_id',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            $customer->policynumber = 'LHL/' . now()->format('YmdHis') . '/P';
        });
    }
}