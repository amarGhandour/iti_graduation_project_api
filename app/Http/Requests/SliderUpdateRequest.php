<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SliderUpdateRequest extends FormRequest
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
        $slider = $this->route('slider')->category;
        return [
            'title' => ['required', Rule::unique('categories', 'name')->ignore($slider)],
            'description' => ['required'],
            'status' => ['required', 'boolean'],
            'image' => ['image'],
        ];
    }

    public function prepareForValidation()
    {
        if (is_string($this->input('status'))) {
            $this->merge([
                'status' => $this->input('status') === 'false' ? false : ($this->input('status') === 'true' ? true : "dummy")
            ]);
        }
    }
}
