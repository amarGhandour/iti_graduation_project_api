<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderCollection;
use App\Models\Slider;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{

    public function index()
    {
        $sliders = Slider::where('status', true)->get();

        return SliderCollection::make($sliders);
    }
}
