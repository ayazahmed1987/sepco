<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TechnicalEvaluationRequest extends FormRequest
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
        $fileExists = $this->route('technical_evaluation')?->file ?? false;
        $technicalEvaluationId = $this->route('technical_evaluation')?->id;
        return [
            'tender_id' => [ 'required', 'exists:tenders,id', Rule::unique('technical_evaluations', 'tender_id')->ignore($technicalEvaluationId),],
            'published_date' => ['required', 'date'],
            'financial_opening_date' => ['required', 'date'],
            'file' => $isUpdate ? ($fileExists ? ['nullable', 'file'] : ['required', 'file']) : ['required', 'file'],
        ];
    }
}
