<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PageComponentType;

class UpdateComponentRequest extends FormRequest
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
            'component_name' => ['required','string','max:255',Rule::unique('components', 'component_name')->ignore($this->component->id)->whereNull('deleted_at')],
            'type'           => ['required', Rule::enum(PageComponentType::class)],
            'fields'         => ['required_if:type,1', 'nullable', 'json'],
            'design'         => 'required|string',
            'css'         => 'nullable|string',
            'javascript'         => 'nullable|string',
            'status'         => 'required|in:0,1',
        ];
    }
}
