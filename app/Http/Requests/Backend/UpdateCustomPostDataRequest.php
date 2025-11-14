<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomPostDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'custom_post_id' => 'nullable|exists:custom_posts,id',
            'fields_data' => 'nullable',
            'status' => 'required|in:0,1',
			'sorting' => 'required|integer',
        ];
		
        
		
        if ($this->custompostdata && $this->custompostdata->custompost && $this->custompostdata->custompost->fields) {

            $custompostdata = $this->custompostdata;
            $fields = [];

            // Choose correct structure depending on context
            if (isset($custompostdata->custompost)) {
                if ($custompostdata->custom_post_id == $custompostdata->custompost->id) {
                    //$fields = $custompostdata->custompost->fields['children'] ?? [];
                    //} else {
                    $fields = $custompostdata->custompost->fields['fields'] ?? [];
                }
				
				
            }
            
            // Loop dynamic fields
            foreach ($fields as $field) {
                $name = $field['name'];
                $fieldRules = [];

                // Required or nullable
                if (!empty($field['required'])) {
                    $fieldRules[] = empty($custompostdata->fields_data[$name])
                        ? 'required'
                        : 'nullable';
                } else {
                    $fieldRules[] = 'nullable';
                }

                // Type-based rules
                switch ($field['type']) {
                    case 'file':
                        $fieldRules[] = 'file';
                        break;
					case 'files':
                        // Main field must be an array
                        $rules[$name] = array_merge($fieldRules, ['array']);
                        // Each element in the array must be a valid file
                        $rules["{$name}.*"] = ['file', 'mimes:jpg,jpeg,png,gif,pdf', 'max:2048'];
                        continue 2; // skip duplicate assignment at the end
	
                    case 'number':
                        $fieldRules[] = 'numeric';
                        break;
                    default:
                        $fieldRules[] = 'string';
                        break;
                }

                $rules[$name] = $fieldRules;
            }
			
			
        }

        return $rules;
		
    }
}
