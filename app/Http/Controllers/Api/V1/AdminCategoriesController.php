<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoriesController extends Controller
{
    use ApiResponse, ImageTrait;

    public function store(Request $request)
    {
        $this->authorize('create_category');

        $request->validate([
            'name' => ['required', Rule::unique('categories', 'name')],
            'image' => ['image']
        ]);

        $categoryImageName = $this->uploadImage($request, 'images' . DIRECTORY_SEPARATOR . 'categories');

        $category = Category::create($request->only(['name']) +
            ['slug' => Str::slug($request->input('name')), 'image' => $categoryImageName]);

        return $this->response(201, true, null, CategoryResource::make($category), 'New category has been successfully created.');
    }


    public function update(Request $request, Category $category)
    {
        $this->authorize('edit_category');

        $attributes = $request->validate([
            'name' => ['required', Rule::unique('categories', 'name')->ignore($category->id)],
            'image' => ['image']
        ]);

        $categoryImageName = $this->updateImage($request, $category?->image, 'images' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR);

        $category->update($request->only(['name', 'slug']) +
            ['slug' => Str::slug($request->input('name')), 'image' => $categoryImageName]);

        return $this->response(200, true, null, CategoryResource::make($category), 'Category has been successfully updated.');
    }


    public function destroy(Category $category)
    {
        $this->authorize('delete_category');

        if ($category?->image !== null)
            $this->deleteImage($category?->image, 'images' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR);

        $category->products()->detach();

        $category->delete();

        return $this->response(204);
    }
}
