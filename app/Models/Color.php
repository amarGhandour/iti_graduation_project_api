<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['imageUrlPivot'];

    public function products()
    {
        $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function getImageUrlPivotAttribute()
    {
        if ($this->pivot->image == null)
            return asset('images/colors/no_image.png');

        return asset('images/colors/' . $this->pivot->image);
    }

}
