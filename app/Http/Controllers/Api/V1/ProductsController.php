<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {

        $products = Product::with('categories');

        if ($request->has('category')) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->where('slug', $request->input('category'));
            });
        }

        $products = $request->input('all') == 1 ? $products->get() : $products->paginate();

        return ProductCollection::make($products);
    }

    public function show(Product $product)
    {

        return $this->response(Response::HTTP_OK, true, null, ProductResource::make($product));

    }
}
