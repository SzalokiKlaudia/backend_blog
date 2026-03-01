<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'content' => 'required|string|min:10',

            'image' => [
                'nullable',           
                'image',              
                'mimes:jpg,jpeg,png', 
                'max:2048',           
            ],
        ];
    }

    public function messages(): array
    {
        return [
           'title.required' => 'Please provide a title for your post.',
            'title.max' => 'The title is too long (maximum 100 characters).',
            'content.required' => 'The post content cannot be empty.',
            'content.min' => 'The content must be at least 10 characters long.',
            'image.image' => 'The file must be an image!',
            'image.max' => 'The image size can not be more than 2MB.',
        ];
    }
}
