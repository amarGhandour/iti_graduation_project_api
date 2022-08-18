<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageTrait;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Str;

class AdminProductsController extends Controller
{
    use ApiResponse, ImageTrait;

    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create_product');

        $productImageName = $this->uploadImage($request, 'images' . DIRECTORY_SEPARATOR . 'products');

        $product = Product::create($request->except(['categories', 'image', 'colors'])
            + ['slug' => Str::slug($request->input('name')), 'image' => $productImageName]);

        $product->categories()->attach($request->input('categories'));

        foreach ($request->validated('colors') as $code => $imageFile) {
            $colorImageName = $this->uploadImage($request, 'images' . DIRECTORY_SEPARATOR . 'colors', $imageFile);
            $color = Color::firstOrCreate(['code' => $code]);
            $product->colors()->attach($color, ['image' => $colorImageName]);
        }

        return $this->response(201, true, null, ProductResource::make($product->load('categories')), 'Product has been successfully added.');
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('edit_product');

        $productImageName = $this->updateImage($request, $product?->image, 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR);

        $$product = $product->update($request->except(['categories', 'image', 'colors'])
            + ['slug' => Str::slug($request->input('name')), 'image' => $productImageName]);

        $product->categories()->sync($request->input('categories'));

        $product->colors->each(function ($color, $key) {
            if (isset($color->pivot?->image))
                $this->deleteImage($color->pivot?->image, 'images' . DIRECTORY_SEPARATOR . 'colors' . DIRECTORY_SEPARATOR);
        });

        foreach ($request->validated('colors') as $code => $imageFile) {
            $colorImageName = $this->uploadImage($request, 'images' . DIRECTORY_SEPARATOR . 'colors', $imageFile);
            $color = Color::firstOrCreate(['code' => $code]);
            $product->colors()->sync($color, ['image' => $colorImageName]);
        }

        return $this->response(201, true, null, ProductResource::make($product->load('categories')), 'Product has been successfully updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete_product');

        if ($product?->image !== null)
            $this->deleteImage($product?->image, 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR);

        $product->colors->each(function ($color, $key) {
            if (isset($color->pivot?->image))
                $this->deleteImage($color->pivot?->image, 'images' . DIRECTORY_SEPARATOR . 'colors' . DIRECTORY_SEPARATOR);
        });
        $product->colors()->detach();

        $product->categories()->detach();

        $product->delete();

        return $this->response(204);
    }
}
