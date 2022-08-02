<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderCollection;
use App\Http\Traits\ApiResponse;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ApiResponse;

    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {

        $sliders = $request->input('all') == 1 ? Slider::all() : Slider::paginate(self::PAGINATE_PER_PAGE);

        return SliderCollection::make($sliders);
    }
}
