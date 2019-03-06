<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable =
    [
        'id',
        'name',
        'slug',
        'created_at',
        'updated_at',
    ];
}
