<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $billing_email
 * @property string|null $billing_name
 * @property string|null $billing_address
 * @property string|null $billing_city
 * @property string|null $billing_province
 * @property string|null $billing_postalcode
 * @property string|null $billing_phone
 * @property string|null $billing_name_on_card
 * @property int $billing_discount
 * @property string|null $billing_discount_code
 * @property int $billing_subtotal
 * @property int $billing_tax
 * @property int $billing_total
 * @property string $payment_gateway
 * @property int $shipped
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingDiscountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingNameOnCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingPostalcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price', 'subtotal')->withTimestamps();
    }
}
