<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable =
    [
        'id',
        'name',
        'surname',
        'company',
        'telephone',
        'email',
        'orders_sum',
        'source_id',
        'delivery',
        'rate_value',
        'rate_description'
    ];
}
