<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ImageTrait;
use App\Models\Product;
use Illuminate\Support\Str;

class AdminProductsController extends Controller
{

    use ApiResponse, ImageTrait;

    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create_product');

        $productImageName = $this->uploadImage($request, 'images' . DIRECTORY_SEPARATOR . 'products');

        $product = Product::create(collect($request->validated())->except(['categories', 'image'])->toArray()
            + ['slug' => Str::slug($request->input('name')), 'image' => $productImageName]);

        $product->categories()->attach($request->input('categories'));

        return $this->response(201, true, null, ProductResource::make($product->load('categories')), 'Product has been successfully added.');
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('edit_product');

        $productImageName = $this->updateImage($request, $product?->image, 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR);

        $$product = $product->update(collect($request->validated())->except(['categories', 'image'])->toArray()
            + ['slug' => Str::slug($request->input('name')), 'image' => $productImageName]);

        $product->categories()->sync($request->input('categories'));

        return $this->response(201, true, null, ProductResource::make($product->load('categories')), 'Product has been successfully updated.');

    }

    public function destroy(Product $product)
    {
        $this->authorize('delete_product');

        if ($product?->image !== null)
            $this->deleteImage($product?->image, 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR);

        $product->categories()->detach();
        $product->delete();

        return $this->response(204);
    }
}
