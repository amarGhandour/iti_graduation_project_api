<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
        $this->authorize('coupon_access');

        $coupons = Coupon::paginate(self::PAGINATE_PER_PAGE);

        return CouponCollection::make($coupons);
    }

    public function show(Coupon $coupon)
    {
        $this->authorize('coupon_show');

        return $this->response(200, true, null, CouponResource::make($coupon));
    }

    public function store(Request $request)
    {
        $this->authorize('coupon_create');

        $attributes = $request->validate([
            'code' => ['required', 'size:6', Rule::unique('coupons', 'code')],
            'type' => ['required', Rule::in('fixed', 'percent')],
            'value' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'fixed';
            }), 'numeric'],
            'percent_off' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'percent';
            })],
            'valid_date' => ['required', 'date_format:Y-m-d H:i:s']
        ]);

        $coupon = Coupon::create($attributes);

        return $this->response(201, true, null, CouponResource::make($coupon), 'New coupon has been successfully created.');

    }

    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('coupon_access');

        $attributes = $request->validate([
            'code' => ['required', 'size:6', Rule::unique('coupons', 'code')->ignore($coupon->id)],
            'type' => ['required', Rule::in('fixed', 'percent')],
            'value' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'fixed';
            }), 'numeric'],
            'percent_off' => [Rule::requiredIf(function () use ($request) {
                return $request->input('type') == 'percent';
            })],
            'valid_date' => ['required', 'date_format:Y-m-d H:i:s']
        ]);

        $coupon->update($attributes);

        return $this->response(201, true, null, CouponResource::make($coupon), 'New coupon has been successfully updated.');

    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('coupon_delete');

        $coupon->delete();

        return $this->response(Response::HTTP_NO_CONTENT);
    }
}
