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
        $products = Product::with('categories')->withAvg('reviews', 'rating');

        if ($request->has('category')) {
            $products->whereHas('categories', function ($query) use ($request) {
                if (is_array($request->input('category')))
                    $query->whereIn('name', $request->input('category'));
                else
                    $query->where('name', $request->input('category'));
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

        if ($request->has('search')) {
            $products->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('rating')) {
            $products->orderByDesc('reviews_avg_rating');
        }

        if ($request->has('most-bought')) {
            $products->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
                ->selectRaw('products.*, COALESCE(sum(order_product.quantity),0) total')
                ->groupBy('products.id')
                ->orderBy('total', 'desc');
        }

        $products = $request->input('all') == 1 ? $products->latest()->get() : $products->latest()->paginate(self::PAGINATE_PER_PAGE);

        return ProductCollection::make($products);
    }

    public function show(Product $product)
    {
        session()->push('products.recently_viewed', $product->getKey());

        $product->load('categories', 'reviews.user')->loadAvg('reviews', 'rating');

        $product->append('related_products');

        return $this->response(Response::HTTP_OK, true, null, ProductResource::make($product));
    }
}
