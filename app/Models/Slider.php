<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['imageUrl'];

    public function getImageUrlAttribute()
    {
        if ($this->attributes['image'] == null)
            return asset('images/sliders/no_image.png');

        return asset('images/sliders/' . $this->attributes['image']);
    }

    public function getImageAttribute()
    {
        if ($this->attributes['image'] == null)
            return 'no_image.png';

        return $this->attributes['image'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
