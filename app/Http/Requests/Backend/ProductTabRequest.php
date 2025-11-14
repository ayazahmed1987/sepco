<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProductTabType;

class ProductTabRequest extends FormRequest
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
        $productTabId = $this->route('product_tab')?->id;
        return [
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required',Rule::in(array_column(ProductTabType::options(), 'id')),Rule::unique('product_tabs')
                ->where(fn ($query) => $query->where('product_id', $this->product_id))
                ->whereNull('deleted_at')
                ->ignore($productTabId)
            ],
            'title' => ['required', 'string', 'max:255'],
        ];
    }
}
