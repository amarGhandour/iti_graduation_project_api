<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class  RegisterRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6'],
            'password_confirm' => ['required', 'same:password'],
//            'phone' => [
//                'required',
//                Rule::unique('users', 'phone'),
//                'numeric',
//                'starts_with:010,011,012',
//                'digits:11',
//
//            ],
//            'country' => ['required'],
//            'city' => ['required'],
//            'postal_code' => ['required'],
//            'address' => ['required']
        ];
    }
}
