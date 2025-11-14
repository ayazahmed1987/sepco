<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\MenuRedirectionType;
class MenuRequest extends FormRequest
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
        return [
            //'title' => 'required|string|max:255|unique:menus,title,',
            //'title_ur' => 'required|string|max:255|unique:menus,title_ur,',
			'title' => 'required|string|max:255',
            'title_ur' => 'required|string|max:255',
            'type' => 'required|in:1,2,3',
            'parent_id' => 'nullable|exists:menus,id',
            'redirection_type' => ['required', 'in:' . implode(',', array_map(fn($case) => $case->value, MenuRedirectionType::cases()))],
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
