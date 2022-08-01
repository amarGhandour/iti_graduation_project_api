<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoriesController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', Rule::unique('categories', 'name')],
            'slug' => ['required', Rule::unique('categories', 'slug')]
        ]);

        // Todo admin can store category image

        $category = Category::create($attributes);

        return $this->response(201, true, null, CategoryResource::make($category), 'New category has been successfully created.');
    }


    public function update(Request $request, Category $category)
    {
        $attributes = $request->validate([
            'name' => ['required', Rule::unique('categories', 'name')->ignore($category->id)],
            'slug' => ['required', Rule::unique('categories', 'slug')->ignore($category->id)]
        ]);

        // Todo admin can update category image

        $category->update($attributes);

        return $this->response(200, true, null, CategoryResource::make($category), 'Category has been successfully updated.');
    }


    public function destroy(Category $category)
    {
        $category->products()->detach();

        $category->delete();

        return $this->response(204);
    }
}
