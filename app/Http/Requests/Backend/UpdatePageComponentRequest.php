<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PageComponentType;

class UpdatePageComponentRequest extends FormRequest
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
        $rules = [
            'parent_id' => 'nullable|exists:page_components,id',
            'title' => 'required|string|max:255',
            'type' => ['required', 'in:' . implode(',', array_map(fn($case) => $case->value, PageComponentType::cases()))],
            'component_id' => 'nullable|required_if:type,1|exists:components,id',
            'fields_data' => 'nullable|required_if:type,2',
            'related_type' => 'nullable|required_if:type,2|max:555',
            'status' => 'required|in:0,1',
            'sorting' => 'required|integer',
        ];
        if ($this->component && $this->component->component && $this->component->component->fields) {
            $fields = $this->component->component->fields;
            $component = $this->component;
            $fields = null;
            if (isset($component->parent_id, $component->component) && $component->component_id == $component->component->id) {
                $fields = $component->component->fields['children'] ?? [];
            } elseif (isset($component->component)) {
                $fields = $component->component->fields['fields'] ?? [];
            }
            foreach ($fields as $field) {
                $name = $field['name'];
                $fieldRules = [];
                if (!empty($field['required'])) {
                    if(empty($this->component->fields_data[$name])){
                        $fieldRules[] = 'required';
                    }else{
                        $fieldRules[] = 'nullable';
                    }
                } else {
                    $fieldRules[] = 'nullable';
                }

                // Add type-based rule
                if ($field['type'] === 'file') {
                    $fieldRules[] = 'file';
                } elseif ($field['type'] === 'number') {
                    $fieldRules[] = 'numeric';
                } else {
                    $fieldRules[] = 'string';
                }

                $rules[$name] = $fieldRules;
            }
        }

        return $rules;
    }
}
