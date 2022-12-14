<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiResponse;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    use ApiResponse;

    public function index()
    {

        if (Cart::instance('shopping')->count() == 0)
            return $this->response(200, true, null, null, 'There is no items in the cart.');

//        $items = Cart::instance('shopping')->content();

        $items = [];
        foreach (Cart::instance('shopping')->content() as $item) {
            $items[] = $item;
        }

        $productsIds = Cart::instance('shopping')->content()->pluck('id');
        $products = Product::find($productsIds);

        $productsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->id] = ProductResource::make($product->load('categories'));
        }

        $cart = collect([
            'items' => $items,
            'products' => $productsMap,
            'discount' => getNumbers()->get('discount'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
        ]);

        return $this->response(200, true, null, $cart->all());
    }

    public function store(Request $request)
    {

        $duplicates = Cart::instance('shopping')->search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return $this->response(200, true, null, null, 'Item is already in your cart!');
        }

        $product = Product::findOrFail($request->id);

        $newItem = Cart::instance('shopping')->add($product->id, $product->name, 1, $product->price)
            ->associate(Product::class);

//        Cart::instance('shopping')->store(auth()->user()->name);

        return $this->response(201, true, null, $newItem, 'New Item added to your Cart.');
    }

    public function update(Request $request, $rowId)
    {

        $attributes = $request->validate([
            'quantity' => ['required', 'numeric', 'between:1,5']
        ]);

        Cart::instance('shopping')->update($rowId, $attributes['quantity']);

        return $this->response(200, true, null, null, 'Item Quantity has been successfully updated.');
    }

    public function destroy($rowId)
    {
        try {
            Cart::instance('shopping')->remove($rowId);

        } catch (\Exception $exception) {
            return $this->response(404, false, null, null, 'Item not found');
        }

        return $this->response(Response::HTTP_NO_CONTENT);
    }

    public function destroyAll()
    {
        Cart::instance('shopping')->destroy();

        return $this->response(Response::HTTP_NO_CONTENT);
    }

    public function switchToSaveForLater($rowId)
    {
        try {
            $item = Cart::instance('shopping')->get($rowId);
            Cart::instance('shopping')->remove($rowId);
        } catch (\Exception $exception) {
            return $this->response(404, false, null, null, 'Item not found');
        }

        $duplicates = Cart::instance('saveForLater')->search(function ($saveForLaterItem, $rowId) use ($item) {
            return $saveForLaterItem->id === $item->id;
        });

        if ($duplicates->isNotEmpty()) {
            return $this->response(200, true, null, null, 'Item is already in Save for later!');
        }

        $newItem = Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate(Product::class);

        return $this->response(200, true, null, $newItem, 'New Item added to save for later.');

    }
}
