<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GRCRequest extends FormRequest
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
        $grcId = $this->route('grc');
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:grcs,email',
            'email'       => ['required', Rule::unique('grcs', 'email')->ignore($grcId)],
            'designation' => 'required|string|max:255',
            'status'      => 'required|in:1,2',
        ];
    }
}
