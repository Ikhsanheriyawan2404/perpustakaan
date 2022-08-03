<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|max:255',
            'image' => 'nullable|max:255',
            'isbn' => 'nullable|max:255',
            'publisher' => 'nullable|max:255',
            'pusblish_year' => 'nullable|max:255',
            'author' => 'nullable|max:255',
            'price' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'quantity' => 'nullable|max:255',
            'booklocation_id' => 'nullable|max:255',
        ];
    }
}
