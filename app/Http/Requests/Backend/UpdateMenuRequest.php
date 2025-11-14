<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends FormRequest
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
    public function rules()
    {
        $menuId = $this->route('menu'); // or $this->menu if route model binding is used

        return [
		/*
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'title')->ignore($menuId),
            ],
            'title_ur' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'title_ur')->ignore($menuId),
            ],
			*/
			'title' => 'required|string|max:255',
            'title_ur' => 'required|string|max:255',
			
            'type' => 'required|in:1,2,3',
            'parent_id' => 'nullable|exists:menus,id',
            'redirection_type' => [
                'required',
                'in:' . implode(',', array_map(fn($case) => $case->value, \App\Enums\MenuRedirectionType::cases()))
            ],
            'page_id' => 'nullable|required_if:redirection_type,1|exists:pages,id',
            'route' => 'nullable|required_if:redirection_type,2|string|max:255',
            'url' => 'nullable|required_if:redirection_type,3|url',
            'status' => 'required|in:0,1',
            'sorting' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'page_id.required_if' => 'The page is required if the redirection type is redirect to Page.',
            'route.required_if' => 'The page is required if the redirection type is redirect to Route.',
            'url.required_if' => 'The page is required if the redirection type is redirect to URL.',
        ];
    }
}
