<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['imageUrl'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function slider()
    {
        return $this->hasOne(Slider::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->attributes['image'] == null)
            return asset('images' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR . 'no_image.png');

        return asset('images' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR . $this->attributes['image']);
    }

    public function getImageAttribute()
    {
        if ($this->attributes['image'] == null)
            return 'no_image.png';

        return $this->attributes['image'];
    }
}
