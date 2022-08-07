<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageTrait;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminSlidersController extends Controller
{
    use ApiResponse, ImageTrait;

    public function store(Request $request)
    {
        $this->authorize('create_slider');

        $attributes = $request->validate([
            'title' => ['required', Rule::unique('sliders', 'title')],
            'slug' => ['required', Rule::unique('sliders', 'slug')],
            'description' => ['required'],
            'status' => ['required', 'boolean'],
            'image' => ['image', 'mimes:png'],
            'route' => ['required']
        ]);

        // Todo admin can store slider image

        $sliderImage = $this->uploadImage($request, '/images/sliders');

        $slider = Slider::create($request->only(['slug', 'title', 'status', 'description']) + ['image' => $sliderImage]);

        return $this->response(201, true, null, SliderResource::make($slider), 'New slider has been successfully created.');
    }


    public function update(Request $request, Slider $slider)
    {
        $this->authorize('edit_slider');

        $attributes = $request->validate([
            'title' => ['required', Rule::unique('sliders', 'title')->ignore($slider->id)],
            'slug' => ['required', Rule::unique('sliders', 'slug')->ignore($slider->id)],
            'description' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        // Todo admin can update slider image

        $slider->update($attributes);

        return $this->response(200, true, null, SliderResource::make($slider), 'Slider has been successfully updated.');
    }


    public function destroy(Slider $slider)
    {
        $this->authorize('delete_slider');

        $slider->products()->detach();

        $slider->delete();

        return $this->response(204);
    }
}
