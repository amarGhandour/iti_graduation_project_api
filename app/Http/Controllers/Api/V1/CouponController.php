<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CouponController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'couponCode' => ['required', 'alpha_num', 'size:6']
        ]);

        $coupon = Coupon::where('code', $attributes['couponCode'])->first();

        if ($coupon) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $coupon?->valid_date, 'Africa/Cairo');
            $isValid = $date->gt(now('GMT+2'));
        }

        if (!$coupon || !$isValid) {
            return $this->response(404, false, ['code' => 'invalid coupon code.'], null, 'invalid coupon code');
        }

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::instance('shopping')->subtotal())
        ]);

        return $this->response(200, true, null, [
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::instance('shopping')->subtotal())
        ], 'The coupon has been successfully applied.');
    }

    public function destroy()
    {
        if (!session()->has('coupon'))
            return $this->response(404, false, null, null, 'There is no applied coupon.');

        session()->forget('coupon');

        return $this->response(200, true, null, null, 'Coupon has been removed.');
    }
}
