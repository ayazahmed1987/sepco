<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
            'title' => 'required|unique:pages,title|max:255',
            'title_ur' => 'required|unique:pages,title_ur|max:255',
            'title' => ['required','max:255', Rule::unique('pages', 'title')->whereNull('deleted_at')],
            'title_ur' => ['required','max:255', Rule::unique('pages', 'title_ur')->whereNull('deleted_at')],
            'description' => 'required|string',
            'description_ur' => 'required|string',
            'image' => 'required|image|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
            'meta_keywords' => 'required|string',
            'status' => 'required|in:0,1',
        ];
    }
}
