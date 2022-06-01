<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Customer extends Model
{
    use HasFactory , Billable;
    protected $fillable=[
        'name',
        'email',
        'mobile',
        'password',
        'address',
        'city',
        'state',
        'zip',
        'company',
        'gstin',
        'status',
    ];
}
