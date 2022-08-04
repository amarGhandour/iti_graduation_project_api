<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rating' => round($this->rating / 10, 2),
            'description' => $this->whenNotNull($this->description),
            'user' => UserResource::make($this->whenLoaded('user')),
            'product' => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}
