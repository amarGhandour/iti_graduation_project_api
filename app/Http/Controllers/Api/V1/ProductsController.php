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

        $categories = $request->input('all') == 1 ? Product::all() : Product::paginate();

        return ProductCollection::make($categories);
    }

    public function show(Product $product)
    {

        return $this->response(Response::HTTP_OK, true, null, ProductResource::make($product));

    }
}
