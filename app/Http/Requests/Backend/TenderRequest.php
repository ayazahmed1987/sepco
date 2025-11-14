<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TenderCategoryType;
use Illuminate\Validation\Rules\Enum;

class TenderRequest extends FormRequest
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
        $tenderId = $this->route('tender');
        return [
            'type' => ['required', new Enum(TenderCategoryType::class)],
            'ref_no' => ['required','string','max:255',Rule::unique('tenders', 'ref_no')->ignore($tenderId)],
            'title' => ['required', 'string', 'max:555'],
            'published_date' => ['required', 'date'],
            'participation_closing_date' => ['required', 'date'],
            'participation_closing_time' => ['required', 'date_format:H:i'],
            'bids_opening_date' => ['required', 'date'],
            'bids_opening_time' => ['required', 'date_format:H:i'],
            'tender_person_id' => ['required', 'exists:tender_persons,id'],
        ];
    }
}
