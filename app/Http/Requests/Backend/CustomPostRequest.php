<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomPostRequest extends FormRequest
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
		    'title'         => 'required|string',
            'table_name' => ['required','string','max:255', Rule::unique('custom_posts', 'table_name')->whereNull('deleted_at')],
            'fields'         => ['required','nullable','json'],
			//'fields'         => ['required_if:type,1', 'nullable', 'json'],
            'design'         => 'required|string',
			'css'         => 'nullable|string',
            'javascript'         => 'nullable|string',
			'page' => 'required|array',
            'status'         => 'required|in:0,1',
        ];
    }
}
