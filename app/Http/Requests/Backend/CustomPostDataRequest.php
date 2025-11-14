<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomPostDataRequest extends FormRequest
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
        /*
		return [
            'table_name' => ['required','string','max:255', Rule::unique('custom_posts', 'table_name')->whereNull('deleted_at')],
            'fields'         => ['required','nullable','json'],
			//'fields'         => ['required_if:type,1', 'nullable', 'json'],
            'design'         => 'required|string',
			'css'         => 'nullable|string',
            'javascript'         => 'nullable|string',
            'status'         => 'required|in:0,1',
        ];
		*/
		
		
		return [
		
            // 'page_id' => 'required|exists:page,id',
            //'parent_id' => 'nullable|exists:page_components,id',
            //'title' => 'required|string|max:255',
            //'type' => ['required', 'in:' . implode(',', array_map(fn($case) => $case->value, PageComponentType::cases()))],
            //'component_id' => 'nullable|required_if:type,1|exists:components,id',
			//'related_type' => 'nullable|required_if:type,2|max:555',
			
			'custom_post_id' => 'nullable|required|exists:custom_posts,id',
            'fields_data' => 'nullable',
            'status' => 'required|in:0,1',
            'sorting' => 'required|integer',
        ];
		
		
    }
}
