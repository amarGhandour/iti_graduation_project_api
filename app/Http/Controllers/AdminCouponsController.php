<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponCollection;
use App\Http\Resources\CouponResource;
use App\Http\Traits\ApiResponse;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class AdminCouponsController extends Controller
{
    use ApiResponse;

    const PAGINATE_PER_PAGE = 10;

    public function index()
    {
        $coupons = Coupon::paginate(self::PAGINATE_PER_PAGE);

        return CouponCollection::make($coupons);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code' => ['required', 'size:6', Rule::unique('coupons', 'code')],
            'type' => ['required', Rule::in('fixed', 'percent')],
            'value' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'fixed';
            }), 'numeric'],
            'percent_off' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'percent';
            })]
        ]);

        $coupon = Coupon::create($attributes);

        return $this->response(201, true, null, CouponResource::make($coupon), 'New coupon has been successfully created.');

    }

    public function update(Request $request, Coupon $coupon)
    {
        $attributes = $request->validate([
            'code' => ['required', 'size:6', Rule::unique('coupons', 'code')->ignore($coupon->id)],
            'type' => ['required', Rule::in('fixed', 'percent')],
            'value' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'fixed';
            }), 'numeric'],
            'percent_off' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'percent';
            })]
        ]);

        $coupon->update($attributes);

        return $this->response(201, true, null, CouponResource::make($coupon), 'New coupon has been successfully updated.');

    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return $this->response(Response::HTTP_NO_CONTENT);
    }
}
