<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function auth;

class ReviewController extends Controller
{
    use ApiResponse;

    public function store(Request $request, Product $product)
    {

        $attributes = $request->validate([
            'rating' => ['required', 'integer'],
            'description' => ['string']
        ]);

        auth()->user()->reviews()->create($attributes + ['product_id' => $product->id]);

        return $this->response(Response::HTTP_CREATED, true, null, null, 'New review has been successfully created.');
    }

    public function update(Request $request, Review $review)
    {

        $this->authorize('update');

        $attributes = $request->validate([
            'rating' => ['required', 'integer'],
            'description' => ['string']
        ]);

        $review->update($attributes);

        return $this->response(Response::HTTP_OK, true, null, null, 'Review has been successfully updated.');
    }

    public function destroy(Request $request, Review $review)
    {

        $this->authorize('update');

        $review->delete();

        return $this->response(Response::HTTP_OK, true, null, null, 'Review has been successfully deleted.');
    }
}
