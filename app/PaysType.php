<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaysType extends Model
{
    protected $fillable =
    [
        'id',
        'name',
        'description',
    ];
}
