<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Symfony\Component\HttpFoundation\Response;

class SaveForLaterController extends Controller
{
    use ApiResponse;

    public function index()
    {

        if (Cart::instance('saveForLater')->count() == 0)
            return $this->response(200, true, null, null, 'There is no items currently saved for later!');

        $items = Cart::instance('saveForLater')->content();

        return $this->response(200, true, null, $items);
    }

    public function switchToCart($rowId)
    {

        try {
            $item = Cart::instance('saveForLater')->get($rowId);

            Cart::instance('saveForLater')->remove($rowId);
        } catch (\Exception $exception) {
            return $this->response(404, false, null, null, 'Item not found');
        }

        $duplicates = Cart::instance('shopping')->search(function ($cartItem, $rowId) use ($item) {
            return $cartItem->id === $item->id;
        });

        if ($duplicates->isNotEmpty()) {
            return $this->response(200, true, null, null, 'Item is already in your Cart!');
        }

        $newItem = Cart::instance('shopping')->add($item->id, $item->name, 1, $item->price)
            ->associate(Product::class);

        return $this->response(200, true, null, $newItem, 'New Item added to your Cart.');
    }

    public function destroy($rowId)
    {

        try {
            Cart::instance('saveForLater')->remove($rowId);

        } catch (\Exception $exception) {
            return $this->response(404, false, null, null, 'Item not found');
        }

        return $this->response(Response::HTTP_NO_CONTENT, true, null);

    }
}
