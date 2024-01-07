<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $bookId = $this->route('id');

        $rules = [
            'title' => [
                'required',
                Rule::unique('books', 'title')->ignore($bookId),
            ],
            'catId' => ['required'],
            'description' => ['required', 'max:100'],
            'count' => ['required'],
            'pdf' => ['required', 'mimes:pdf'],
            'cover' => ['mimes:jpeg,jpg,png'],
        ];

        if ($this->isMethod('put')) {
            $rules['pdf'] = ['nullable'];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'title',
            'catId' => 'book_category_id',
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'Title already exist',
            'title.required' => 'Title is required',
            'catId.required' => 'Category Book is required',
            'description.required' => 'Description Book is required',
            'description.max' => 'The length of the description must be more or less than equal to 100',
            'count.required' => 'Number of books is required',
            'pdf.required' => 'Data PDF of book is required',
            'cover.mimes' => 'The cover must be a file of type: jpeg, jpg, png.',
        ];
    }
}
