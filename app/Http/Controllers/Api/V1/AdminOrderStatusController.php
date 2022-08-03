<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Traits\ApiResponse;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderStatusController extends Controller
{
    use ApiResponse;

    public function update(Request $request, Order $order)
    {

        $attributes = $request->validate([
            'shipped' => ['required', 'required']
        ]);

        $order->update($attributes);

        return $this->response(200, true, null, OrderResource::make($order), 'Order status has been successfully updated.');
    }
}
