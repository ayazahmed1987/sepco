<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TenderAttachmentType;
use Illuminate\Validation\Rules\Enum;

class TenderAttachmentRequest extends FormRequest
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
        $fileExists = $this->route('tender_attachment')?->file ?? false;

        return [
            'type'        => ['required', new Enum(TenderAttachmentType::class)],
            'tender_id'   => ['required', 'exists:tenders,id'],
            'file_title'  => ['required', 'string', 'max:255'],
            'file'        => $isUpdate ? ($fileExists ? ['nullable', 'file'] : ['required', 'file']) : ['required', 'file'],
            'sorting'     => ['required', 'integer'],
        ];
    }
}
