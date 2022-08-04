<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'max:255',
            'phone_number' => 'max:255',
            'address' => 'nullable',
            'gender' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048|max:255',
        ];
    }
}
