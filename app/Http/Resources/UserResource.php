<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'avatar' => $this->whenAppended('imageUrl'),
            'address' => $this->whenNotNull($this->address),
            'city' => $this->whenNotNull($this->city),
            'country' => $this->whenNotNull($this->country),
            'postal_code' => $this->whenNotNull($this->postal_code),
            'phone' => $this->whenNotNull($this->phone),
            'roles' => RoleResource::collection($this->whenLoaded('roles'))
        ];
    }
}
