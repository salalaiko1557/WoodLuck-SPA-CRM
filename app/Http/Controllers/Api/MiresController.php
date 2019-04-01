<?php

namespace App\Http\Controllers\Api;

use App\Mires;
use App\Http\Resources\MiresResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MiresController extends Controller
{
    public function all()
    {
        return MiresResource::collection(Mires::all());
    }
}
