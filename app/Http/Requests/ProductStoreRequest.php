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
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'categories' => ['required', Rule::exists('categories', 'id')],
            'quantity' => ['sometimes', 'numeric'],
            'image' => ['sometimes', 'image'],
            'featured' => ['required', 'boolean'],
            'colors' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        if (is_string($this->featured)) {
            $this->merge([
                'featured' => $this->featured === 'false' ? false : ($this->featured === 'true' ? true : 'dummy'),
            ]);
        }
    }
}
