<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => 'required|nullable|max:50',
            'content' => 'required|nullable',
            'cover_image' => 'nullable|max:255',
            'url_git' => 'required|nullable',
            'url_view' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'content.required' => 'Description is required',
            'url_git.require' => 'url in required',

        ];
    }
}
