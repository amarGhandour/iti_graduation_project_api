<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "user" => UserResource::make($this->whenLoaded('user')),
            "billing_email" => $this->billing_email,
            "billing_name" => $this->billing_name,
            "billing_address" => $this->billing_address,
            "billing_city" => $this->billing_city,
            "billing_province" => $this->billing_province,
            "billing_postalcode" => $this->billing_postalcode,
            "billing_phone" => $this->billing_phone,
            "billing_name_on_card" => $this->billing_name_on_card,
            "billing_discount" => $this->billing_discount,
            "billing_discount_code" => $this->whenNotNull($this->billing_discount_code),
            "billing_subtotal" => $this->billing_subtotal,
            "billing_tax" => $this->billing_tax,
            "billing_total" => $this->billing_total,
            "payment_gateway" => $this->payment_gateway,
            "shipped" => $this->shipped == 0 ? "NO" : "YES",
            "error" => $this->error == null ? "NO" : "YES",
            "OrderItems" => OrderItemResource::collection($this->whenLoaded('items'))
        ];
    }
}
