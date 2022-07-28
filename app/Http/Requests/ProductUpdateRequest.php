<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $product = $this->route('product');
        return [
            'name' => ['required', Rule::unique('products', 'name')->ignore($product->id), 'min:6'],
            'slug' => ['required', Rule::unique('products', 'slug')->ignore($product->id)],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'quantity' => ['sometimes', 'numeric'],
            'image' => ['sometimes', 'image'],
            'featured' => ['required'],
        ];
    }
}
