<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependentModel extends Model
{
    use HasFactory;

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
        'relationship',
        'principal',
        'principal_ID',
        'user_id',

    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            $customer->policynumber = 'LHL/' . now()->format('YmdHis') . '/D';
        });
    }
}