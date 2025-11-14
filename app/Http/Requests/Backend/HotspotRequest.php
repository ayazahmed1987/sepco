<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HotspotRequest extends FormRequest
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
        $isUpdate = $this->method() !== 'POST';

        return [
            'tab_item_content_id' => ['required', 'exists:tab_item_contents,id'],
            'type' => ['required', Rule::in(['front', 'back'])],
            'feature' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string'],
            'top' => ['required', 'numeric', 'between:0,100'],
            'left' => ['required', 'numeric', 'between:0,100'],
            'image' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:51200']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isEdit = $this->route('hotspot');
            if ($isEdit) {
                $existing = \App\Models\Hotspot::find($isEdit->id);
                if (!$existing || !$existing->image) {
                    if (!$this->hasFile('image')) {
                        $validator->errors()->add('image', 'The image field is required.');
                    }
                }
            } else {
                if (!$this->hasFile('image')) {
                    $validator->errors()->add('image', 'The image field is required.');
                }
            }
        });
    }
}
