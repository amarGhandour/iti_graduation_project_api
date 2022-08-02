<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColorCollection;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        return ColorCollection::make(Color::all());
    }
}
