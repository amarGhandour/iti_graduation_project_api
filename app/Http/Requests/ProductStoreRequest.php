<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends FormRequest
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
        return [
            'name' => ['required', Rule::unique('products', 'name'), 'min:6'],
            'slug' => ['required', Rule::unique('products', 'slug')],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'quantity' => ['sometimes', 'numeric'],
            'image' => ['sometimes', 'image'],
            'featured' => ['required', 'boolean'],
        ];
    }
}
