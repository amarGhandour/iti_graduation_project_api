<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorCollection;
use App\Http\Resources\ColorResource;
use App\Http\Traits\ApiResponse;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class AdminColorsController extends Controller
{
    use ApiResponse;

    const PAGINATE_PER_PAGE = 10;

    public function index()
    {
        $colors = Color::paginate(self::PAGINATE_PER_PAGE);

        return ColorCollection::make($colors);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code' => ['required', Rule::unique('colors', 'name')]
        ]);

        $color = Color::create($attributes);

        return $this->response(201, true, null, ColorResource::make($color), 'New color has been successfully created.');

    }

    public function update(Request $request, Color $color)
    {
        $attributes = $request->validate([
            'name' => ['required', Rule::unique('colors', 'name')->ignore($color->id)]
        ]);

        $color = Color::create($attributes);

        return $this->response(201, true, null, ColorResource::make($color), 'New color has been successfully updated.');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return $this->response(Response::HTTP_NO_CONTENT);
    }
}
