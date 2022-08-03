<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;
use function abort_if;
use function auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('user')->get();

        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {

        abort_if($order->user_id != auth()?->id(), Response::HTTP_FORBIDDEN);

        return OrderResource::make($order);
    }
}
