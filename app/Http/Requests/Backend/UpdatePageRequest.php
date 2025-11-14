<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
    public function rules()
    {
        $page = $this->route('page'); // assumes route model binding

        return [
            'title' => 'required|max:255|unique:pages,title,' . $page->id,
            'title_ur' => 'required|max:255|unique:pages,title_ur,' . $page->id,
            'description' => 'required|string',
            'description_ur' => 'required|string',
            'image' => ($page->image ? 'nullable' : 'required') . '|image|max:5120',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
            'meta_keywords' => 'required|string',
            'status' => 'required|in:0,1',
        ];
    }
}
