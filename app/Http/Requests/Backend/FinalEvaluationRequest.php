<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FinalEvaluationRequest extends FormRequest
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
        $fileExists = $this->route('final_evaluation')?->file ?? false;
        $finalEvaluationId = $this->route('final_evaluation')?->id;
        return [
            'tender_id' => [ 'required', 'exists:tenders,id', Rule::unique('final_evaluations', 'tender_id')->ignore($finalEvaluationId),],
            'published_date' => ['required', 'date'],
            'po_issuance_date' => ['required', 'date'],
            'file' => $isUpdate ? ($fileExists ? ['nullable', 'file'] : ['required', 'file']) : ['required', 'file'],
        ];
    }
}
