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

    const PAGINATE_PER_PAGE = 10;

    public function index(Request $request)
    {

        $products = Product::with('categories');

        if ($request->has('category')) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->where('slug', $request->input('category'));
            });
        }

        if ($request->has('price')) {
            $range = explode('-', $request->input('price'));
            $products->whereBetween('price', $range);
        }

        if ($request->has('color')) {
            $products->whereHas('colors', function ($query) use ($request) {
                $query->where('name', $request->input('color'));
            });
        }

        $products = $request->input('all') == 1 ? $products->get() : $products->paginate(self::PAGINATE_PER_PAGE);

        return ProductCollection::make($products);
    }

    public function show(Product $product)
    {
        $product->load('categories');
        return $this->response(Response::HTTP_OK, true, null, ProductResource::make($product));
    }
}
