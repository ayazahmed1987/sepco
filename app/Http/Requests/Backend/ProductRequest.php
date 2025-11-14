<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $productId = $this->route('product')?->id;
        return [
            'name' => ['required', 'max:255', Rule::unique('products', 'name')->ignore($productId)->whereNull('deleted_at')],
            'thumbnail' => [$this->isMethod('post') ? 'required' : 'nullable','image','max:5120']
        ];
    }
}
