<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorCollection;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        return ColorCollection::make(Color::all());
    }
}
