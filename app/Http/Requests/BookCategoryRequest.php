<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCategoryRequest extends FormRequest
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
            'categoryNew' => ['required','unique:books_category,category'],
        ];
    }

    public function attributes()
    {
        return [
            'categoryNew' => 'category',
        ];
    }

    public function messages()
    {
        return [
            'categoryNew.unique' => 'Categories already exist',
            'categoryNew.required' => 'Category is required',
        ];
    }
}
