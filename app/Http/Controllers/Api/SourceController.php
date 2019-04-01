<?php

namespace App\Http\Controllers\Api;

use App\Sources;
use App\Http\Resources\SourceResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourceController extends Controller
{
    public function all()
    {
        return SourceResource::collection(Sources::all());
    }
}
