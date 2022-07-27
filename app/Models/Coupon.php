<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coupon
 *
 * @method static \Database\Factories\CouponFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @mixin \Eloquent
 */
class Coupon extends Model
{
    use HasFactory;

    public function discount($total)
    {
        if ($this->type == 'fixed')
            return $this->value;
        elseif ($this->type == 'percent')
            return round(($this->percent_off / 100) * $total);

        return 0;
    }
}
