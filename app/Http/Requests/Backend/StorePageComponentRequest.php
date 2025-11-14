<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PageComponentType;
class StorePageComponentRequest extends FormRequest
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
            // 'page_id' => 'required|exists:page,id',
            'parent_id' => 'nullable|exists:page_components,id',
            'title' => 'required|string|max:255',
            'type' => ['required', 'in:' . implode(',', array_map(fn($case) => $case->value, PageComponentType::cases()))],
            'component_id' => 'nullable|required_if:type,1|exists:components,id',
            'fields_data' => 'nullable|required_if:type,2',
            'related_type' => 'nullable|required_if:type,2|max:555',
            'status' => 'required|in:0,1',
            'sorting' => 'required|integer',
        ];
    }
}
