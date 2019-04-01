<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sources extends Model
{
    protected $fillable =
    [
        'id',
        'name',
        'description',
    ];
}
