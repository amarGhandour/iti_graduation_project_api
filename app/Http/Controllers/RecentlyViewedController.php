<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponse;
use App\Models\Product;

class RecentlyViewedController extends Controller
{
    use ApiResponse;

    public function __invoke()
    {
        $productsId = session()->get('products.recently_viewed');

        if (!isset($productsId))
            return $this->response(200, true, null, null, 'There are no products have viewed yet.');

        $products = Product::whereIn('id', $productsId)->latest()->take(4)->get();

        return $this->response(200, true, null, ProductResource::collection($products));
    }
}
