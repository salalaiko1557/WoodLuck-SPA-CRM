<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $fillable =
    [
        'id',
        'name',
        'mire_id',
        'count',
        'limit',
        'comment',
        'email'
    ];
}
