<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponse;
use App\Models\Product;

class AdminProductsController extends Controller
{

    use ApiResponse;

    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create_product');

        $product = Product::create(collect($request->validated())->except(['category_id'])->toArray());

        $product->categories()->attach($request->input('category_id'));

        return $this->response(201, true, null, ProductResource::make($product->load('categories')), 'Product has been successfully added.');
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('edit_product');

        $product->update(collect($request->validated())->except(['category_id'])->toArray());

        $product->categories()->sync($request->input('category_id'));

        return $this->response(201, true, null, ProductResource::make($product->load('categories')), 'Product has been successfully updated.');

    }

    public function destroy(Product $product)
    {
        $this->authorize('delete_product');

        $product->categories()->detach();
        $product->delete();

        return $this->response(204);
    }
}
