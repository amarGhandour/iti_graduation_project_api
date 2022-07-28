<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Traits\ApiResponse;
use App\Models\Order;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    use ApiResponse;

    public function store(CheckoutRequest $request)
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

            // Todo  send order email to customer email

            $this->addToOrdersTables($request, null);

            $this->decreaseProductsQuantities();

            Cart::instance('shopping')->destroy();
            session()->forget('coupon');

            return $this->response(201, true, null, null, 'Thank you! Your Payment has been successfully Accepted.');

        } catch (CardErrorException $e) {
            $this->addToOrdersTables($request, $e->getMessage());
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

    protected function addToOrdersTables($request, $error)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalCode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->nameOnCard,
            'billing_discount' => getNumbers()->get('discount'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => getNumbers()->get('newSubtotal'),
            'billing_tax' => getNumbers()->get('newTax'),
            'billing_total' => getNumbers()->get('newTotal'),
            'error' => $error,
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            $order->products()->attach($item->model, [
                'quantity' => $item->qty,
                'price' => $item->model->price,
                'subtotal' => $item->subtotal()
            ]);
        }

        return $order;
    }
}
