<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use App\Http\Resources\SliderCollection;
use App\Http\Resources\SliderResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageTrait;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSlidersController extends Controller
{
    use ApiResponse, ImageTrait;


    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {
//        if ($request->has('status'))
//             $sliders = Slider::where('status', $request->input('status'));
        $sliders = Slider::latest();

        $sliders = $request->input('all') == 1 ? $sliders->get() : $sliders->paginate(self::PAGINATE_PER_PAGE);

        return SliderCollection::make($sliders);
    }

    public function show(Slider $slider)
    {

        return $this->response(200, true, null, SliderResource::make($slider));
    }

    public function store(SliderStoreRequest $request)
    {
        $sliderImage = $this->uploadImage($request, '/images' . DIRECTORY_SEPARATOR . 'sliders');

        $category = Category::create([
            'name' => $request->input('title'),
            'slug' => Str::slug($request->input('title'))
        ]);

        $slider = $category->slider()->create($request->only(['title', 'status', 'description']) +
            ['image' => $sliderImage, 'link' => 'products?category=' . $category->name]);

        return $this->response(201, true, null, SliderResource::make($slider), 'New slider has been successfully created.');
    }


    public function update(SliderUpdateRequest $request, Slider $slider)
    {
        $sliderImage = $this->updateImage($request, $slider?->image, '/images' . DIRECTORY_SEPARATOR . 'sliders' . DIRECTORY_SEPARATOR);

        $slider->update($request->only(['title', 'status', 'description']) +
            ['image' => $sliderImage]);

        $slider->category()->update(['name' => $request->input('title')]);

        return $this->response(200, true, null, SliderResource::make($slider), 'Slider has been successfully updated.');
    }


    public function destroy(Slider $slider)
    {
        if ($slider?->image !== null)
            $this->deleteImage($slider?->image, 'images' . DIRECTORY_SEPARATOR . 'sliders' . DIRECTORY_SEPARATOR);

        $category = $slider->category;

        $category->delete();

        return $this->response(204);
    }
}
