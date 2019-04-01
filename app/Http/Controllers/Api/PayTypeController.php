<?php

namespace App\Http\Controllers\Api;

use App\PaysType;
use App\Http\Resources\PaysTypeResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayTypeController extends Controller
{
    public function all()
    {
        return PaysTypeResource::collection(PaysType::all());
    }
}
