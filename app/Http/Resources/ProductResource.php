<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => round($this->price / 10, 2),
            'quantity' => $this->quantity,
            'featured' => $this->featured == 1,
            'image' => $this->whenAppended('imageUrl'),
            'rating' => $this->when($this->reviews_avg_rating != 0, round($this->reviews_avg_rating / 10, 2)),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'colors' => ColorResource::collection($this->whenLoaded('colors')),
            'relatedProducts' => ProductResource::collection($this->whenAppended('related_products'))
        ];
    }
}
