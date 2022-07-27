<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        if ($this->productsAreNoLongerAvailable()) {
            return $this->response(404, false, null, null,
                'Sorry! One of the items in your cart is no longer available.');
        }

        $contents = Cart::instance('shopping')->content()->map(function ($item) {
            return $item->model->slug . ',' . $item->qty;
        })->values()->toJson();

        try {

            $charge = Stripe::charges()->create([
                'amount' => getNumbers()->get('newTotal') / 100,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('shopping')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson(),
                ],
            ]);

            // Todo insert orders to database, send order email to customer email

            $this->decreaseProductsQuantities();

            Cart::instance('shopping')->destroy();
            session()->forget('coupon');

            return $this->response(201, true, null, null, 'Thank you! Your Payment has been successfully Accepted.');

        } catch (CardErrorException $e) {
            return $this->response($e->getErrorCode(), false, ['error' => $e->getMessage()], null, $e->getMessage());
        }
    }

    private function productsAreNoLongerAvailable()
    {
        foreach (Cart::instance('shopping')->content() as $item) {
            if ($item->model->fresh()->quantity < $item->qty)
                return true;
        }
        return false;
    }

    private function decreaseProductsQuantities()
    {
        foreach (Cart::instance('shopping')->content() as $item) {
            $product = $item->model->fresh();
            $product->update([
                'quantity' => $product->quantity - $item->qty,
            ]);
        }
    }
}
