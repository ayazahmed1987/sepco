<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TabItemContentRequest extends FormRequest
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
            'tab_item_id' => 'required|exists:tab_items,id',
            'image' => ['nullable', 'image', 'max:51200'],
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'is_reversed' => 'required|in:0,1',
            'sorting'     => 'nullable|integer',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isEdit = $this->route('tab_item_content'); // adjust based on route binding name
            if ($isEdit) {
                $existing = \App\Models\TabItemContent::find($isEdit->id);
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
