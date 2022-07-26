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

        $contents = Cart::instance('shopping')->content()->map(function ($item) {
            return $item->model->slug . ',' . $item->qty;
        })->values()->toJson();


        try {
            $charges = Stripe::charges()->create([
                'amount' => ((int)Cart::instance('shopping')->total()) / 100,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('shopping')->count()
                ]
            ]);

            Cart::instance('shopping')->destroy();

            return $this->response(201, true, null, null, 'Thank you! Your Payment has been successfully Accepted.');

        } catch (CardErrorException $e) {
            return $this->response($e->getErrorCode(), false, ['error' => $e->getMessage()], null, $e->getMessage());
        }
    }
}
