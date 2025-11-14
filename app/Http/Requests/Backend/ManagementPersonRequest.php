<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ManagementPersonRequest extends FormRequest
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
        $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';
        $fileExists = $this->route('management_person')?->image ?? false;
        return [
            'type' => ['required', 'in:1,2'],
            'name' => ['required'],
            'designation' => ['required'],
            'description' => ['nullable','string'],
            'image' => $isUpdate ? ($fileExists ? ['nullable', 'file'] : ['required', 'file']) : ['required', 'file'],
            'sorting' => ['required','integer'],
            'status' => ['required','integer','in:1,2']
        ];
    }
}
