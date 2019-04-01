<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $casts = [
        'material_id' => 'array',
    ];
    protected $fillable =
    [
        'id',
        'customer_id',
        'order_type_id',
        'price',
        'pay_type_id',
        'description',
        'text_execution',
        'date_execution',
        'material_id',
        'material_count',
        'canban_status',
        'canban_column',
        'draw',
        'mires_id'
    ];
}
