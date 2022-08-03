<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            "id" => $this->id,
            "product" => $this->product()->select('name')->get()->pluck('name')[0],
            "quantity" => $this->quantity,
            "price" => $this->price,
            "subtotal" => $this->subtotal,
        ];
    }
}
